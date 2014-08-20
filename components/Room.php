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
            'name'        => 'Room details',
            'description' => 'Display a room details on the page'
        ];
    }

    public function defineProperties()
    {
        return [
            'idParam' => [
                'title'       => 'Slug param name',
                'description' => 'The URL route parameter used for looking up the room by its slug.',
                'default'     => ':slug',
                'type'        => 'string'
            ],
        ];
    }

    public function onRun()
    {
        $this->room = $this->page['room'] = $this->loadRoom();
        $this->page->meta_title = $this->room->name;
        $this->page->meta_description = $this->room->except;
        
        // To use add ùse DB` at the top of this page
        //echo '<pre>';
        //$queries = DB::getQueryLog();
        //dd($queries); // only last query -> dd(end($queries));
            
        if (!$this->room) {
            return Response::make($this->controller->run('404'), 400, array());
        }
    }

    protected function loadRoom()
    {
        $slug = $this->propertyOrParam('idParam');
        return RoomDetails::where('slug', '=', $slug)->first();
    }

}