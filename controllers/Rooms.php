<?php namespace Tiipiik\Booking\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Tiipiik\Booking\Models\Room;

/**
 * Rooms Back-end Controller
 */
class Rooms extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $bodyClass = 'compact-container';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Tiipiik.Booking', 'booking', 'rooms');
        
        $this->addCss('/plugins/tiipiik/booking/assets/css/tiipiik.booking-preview.css');
        $this->addCss('/plugins/tiipiik/booking/assets/css/tiipiik.booking-preview-theme-default.css');

        $this->addCss('/plugins/tiipiik/booking/assets/vendor/prettify/prettify.css');
        $this->addCss('/plugins/tiipiik/booking/assets/vendor/prettify/theme-desert.css');

        $this->addJs('/plugins/tiipiik/booking/assets/js/post-form.js');
        $this->addJs('/plugins/tiipiik/booking/assets/vendor/prettify/prettify.js');
    }

    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $postId) {
                if (!$post = Room::find($postId))
                    continue;

                $post->delete();
            }

            Flash::success('Successfully deleted those rooms.');
        }

        return $this->listRefresh();
    }

    public function onRefreshPreview()
    {
        $data = post('Room');

        $previewHtml = Room::formatHtml($data['content'], true);

        return [
            'preview' => $previewHtml
        ];
    }
}