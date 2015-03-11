<?php namespace Tiipiik\Booking\Components;

use App;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Tiipiik\Booking\Models\Room;
use Tiipiik\Booking\Models\Settings;

class RoomList extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'tiipiik.booking::lang.components.room_list.name',
            'description' => 'tiipiik.booking::lang.components.room_list.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'roomsPerPage' => [
                'title'             => 'tiipiik.booking::lang.components.room_list.params.rooms_per_page_title',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'tiipiik.booking::lang.components.room_list.params.room_per_page_validation',
                'default'           => '10',
            ],
            'pageParam' => [
                'title'       => 'tiipiik.booking::lang.components.room_list.params.page_param_title',
                'description' => 'tiipiik.booking::lang.components.room_list.params.page_param_desc',
                'type'        => 'string',
                'default'     => ':page',
            ],
            'noRoomsMessage' => [
                'title'        => 'tiipiik.booking::lang.components.room_list.params.no_room_title',
                'description'  => 'tiipiik.booking::lang.components.room_list.params.no_room_desc',
                'type'         => 'string',
                'default'      => 'tiipiik.booking::lang.components.room_list.params.no_room_default'
            ],
        ];
    }
    
    public function getRoomPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }
    
    public function onRun()
    {
        $this->rooms = $this->page['rooms'] = $this->listRooms();
        $this->noRoomsMessage = $this->page['noRoomsMessage'] = $this->property('noRoomsMessage');
        // get the path of current theme
        //$this->themePath = $this->page['themePath'] = $this->themeUrl();
        
        //$this->roomParam = $this->page['roomParam'] = $this->property('roomParam');
        $this->roomPage = $this->page['roomPage'] = Settings::get('roomPage');
        $this->room_page_slug = $this->page['room_page_slug'] = Settings::get('room_page_slug');
    }
    
    protected function listRooms()
    {
        return Room::make()->listFrontEnd([
            'room' => Settings::get('room_page_slug'),
            'perPage' => $this->property('roomsPerPage'),
        ]);
    }


}