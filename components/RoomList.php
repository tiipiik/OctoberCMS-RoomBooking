<?php namespace Tiipiik\Booking\Components;

use App;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Tiipiik\Booking\Models\Room;

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
            'roomPage' => [
                'title'       => 'tiipiik.booking::lang.components.room_list.params.room_page_title',
                'description' => 'tiipiik.booking::lang.components.room_list.params.room_page_desc',
                'type'        => 'dropdown',
                'default'     => 'booking/room'
            ],
            'roomPageIdParam' => [
                'title'       => 'tiipiik.booking::lang.components.room_list.params.room_slug_title',
                'description' => 'tiipiik.booking::lang.components.room_list.params.room_slug_desc',
                'type'        => 'string',
                'default'     => ':slug',
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
        
        $this->roomParam = $this->page['roomParam'] = $this->property('roomParam');
        $this->roomPage = $this->page['roomPage'] = $this->property('roomPage');
        $this->roomPageIdParam = $this->page['roomPageIdParam'] = $this->property('roomPageIdParam');
    }
    
    protected function listRooms()
    {
        return Room::make()->listFrontEnd([
            'room' => $this->propertyOrParam('roomParam'),
        ]);
    }


}