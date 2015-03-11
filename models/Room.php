<?php namespace Tiipiik\Booking\Models;

use App;
use Str;
use Model;
use Markdown;
use ValidationException;
use Tiipiik\Booking\Classes\TagProcessor;
use Cms\Classes\Controller as BaseController;
use Tiipiik\Booking\Models\Settings;
use Url;

/**
 * Room Model
 */
class Room extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tiipiik_booking_rooms';

    /**
     * @var array Translatable fields
     */
    public $translatable = ['name', 'excerpt', 'content'];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'name' => 'required',
        'slug' => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i'],
        'content' => 'required',
        'excerpt' => ''
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [
        'featured_images' => ['System\Models\File'],
        'content_images' => ['System\Models\File']
    ];

    /*
        Avoid 'preview' to be passed on save & update requests
    */
    public $preview = null;
    
     /**
     * Add translation support to this model, if available.
     * @return void
     */
    public static function boot()
    {
        // Call default functionality (required)
        parent::boot();

        // Check the translate plugin is installed
        if (!class_exists('RainLab\Translate\Behaviors\TranslatableModel'))
            return;

        // Extend the constructor of the model
        self::extend(function($model){

            // Implement the translatable behavior
            $model->implement[] = 'RainLab.Translate.Behaviors.TranslatableModel';

        });
    }
    
    /**
     * Lists rooms for the front end
     * @param  array $options Display options
     * @return self
     */
    public function listFrontEnd($options)
    {
        /*
         * Default options
         */
        extract(array_merge([
            'page' => 1,
            'perPage' => (int) $options['perPage'],
            'sort' => 'created_at',
            'search' => '',
        ], $options));
        
        $allowedSortingOptions = ['name', 'created_at', 'updated_at'];
        $searchableFields = ['name', 'slug', 'content'];

        $obj = $this->newQuery();
        
        /*
         * Sorting
         */
        if (!is_array($sort)) $sort = [$sort];
        foreach ($sort as $_sort) {

            $parts = explode(' ', $_sort);
            if (count($parts) < 2) array_push($parts, 'desc');
            list($sortField, $sortDirection) = $parts;

            if (in_array($sortField, $allowedSortingOptions))
                $obj->orderBy($_sort, 'desc');
        }

        /*
         * Search
         */
        $search = trim($search);
        if (strlen($search)) {
            $obj->searchWhere($search, $searchableFields);
        }

        return $obj->paginate($perPage, $page);
    }

    public static function formatHtml($input, $preview = false)
    {
        $result = Markdown::parse(trim($input));

        if ($preview)
            $result = str_replace('<pre>', '<pre class="prettyprint">', $result);

        $result = TagProcessor::instance()->processTags($result, $preview);

        return $result;
    }
    
    public function beforeSave()
    {
        $this->content_html = self::formatHtml($this->content);
    }

    /**
     * Handler for the pages.menuitem.getTypeInfo event.
     * Returns a menu item type information. The type information is returned as array
     */
    public static function getMenuTypeInfo($type)
    {
        return [
            'dynamicItems' => true
        ];
    }

    /**
     * Handler for the pages.menuitem.resolveItem event.
     * Returns information about a menu item. The result is an array
     */
    public static function resolveMenuItem($item, $url, $theme)
    {
        $result = [
            'items' => []
        ];

        $rooms = self::orderBy('name')->get();
        $roomPage = Settings::get('roomPage');

        foreach ($rooms as $room) {
            $fullSlug = $roomPage .'/'. $room->slug;

            $roomItem = [
                'title' => $room->name,
                'url'   => Url::action('Cms\Classes\Controller@run', ['slug' => $fullSlug]),
                'mtime' => $room->updated_at,
            ];

            $roomItem['isActive'] = $roomItem['url'] == $url;

            $result['items'][] = $roomItem;
        }

        return $result;
    }

}