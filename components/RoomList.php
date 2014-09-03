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
            'name'        => 'Room List Component',
            'description' => 'Display a list of rooms'
        ];
    }

    public function defineProperties()
    {
        return [
            'roomsPerPage' => [
                'title'             => 'Rooms per page',
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'Invalid format of the rooms per page value',
                'default'           => '10',
            ],
            'pageParam' => [
                'title'       => 'Pagination parameter name',
                'description' => 'The expected parameter name used by the pagination pages.',
                'type'        => 'string',
                'default'     => ':page',
            ],
            'roomPage' => [
                'title'       => 'Room page',
                'description' => 'Name of the room page file for the "Learn more" links. This property is used by the default component partial.',
                'type'        => 'dropdown',
                'default'     => 'booking/room'
            ],
            'roomPageIdParam' => [
                'title'       => 'Room page param name',
                'description' => 'The expected parameter name used when creating links to the room page.',
                'type'        => 'string',
                'default'     => ':slug',
            ],
            'noRoomsMessage' => [
                'title'        => 'No rooms message',
                'description'  => 'Message to display in the booking room list in case if there are no rooms. This property is used by the default component partial.',
                'type'         => 'string',
                'default'      => 'No rooms found'
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