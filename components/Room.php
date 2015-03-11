<?php namespace Tiipiik\Booking\Components;

use DB;
use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Request;
use Response;
use Tiipiik\Booking\Models\Room as RoomDetails;

class Room extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'tiipiik.booking::lang.components.room.name',
            'description' => 'tiipiik.booking::lang.components.room.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'tiipiik.booking::lang.components.room.params.slug_title',
                'description' => 'tiipiik.booking::lang.components.room.params.slug_desc',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],
        ];
    }

    public function onRun()
    {
        $this->room = $this->page['room'] = $this->loadRoom();
        $this->page->meta_title = $this->room->name;
        $this->page->meta_description = strip_tags($this->room->excerpt);

        // To use add `use DB` at the top of this page
        //echo '<pre>';
        //$queries = DB::getQueryLog();
        //dd($queries); // only last query -> dd(end($queries));

        if (!$this->room) {
            return Response::make($this->controller->run('404'), 400, array());
        }
    }

    protected function loadRoom()
    {
        $slug = $this->property('slug');
        return RoomDetails::where('slug', '=', $slug)->first();
    }

}
