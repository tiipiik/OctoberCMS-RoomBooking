<?php namespace Tiipiik\RoomBooking;

use Backend;
use System\Classes\PluginBase;
use Tiipiik\RoomBooking\Classes\TagProcessor;

/**
 * Booking Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'RoomBooking',
            'description' => 'Room Booking plugin, with front and backend',
            'author'      => 'Tiipiik',
            'icon'        => 'icon-leaf'
        ];
    }

    public function registerFormWidgets()
    {
        return [
            'Tiipiik\RoomBooking\FormWidgets\Preview' => [
                'label' => 'Preview',
                'alias' => 'preview'
            ]
        ];
    }
    
    public function registerComponents()
    {
        return [
            'Tiipiik\RoomBooking\Components\RoomList' => 'room_list',
            'Tiipiik\RoomBooking\Components\Room' => 'room',
            'Tiipiik\RoomBooking\Components\BookingForm' => 'booking_form',
        ];
    }
    
    public function registerNavigation()
    {
        return [
            'roombooking' => [
                'label'       => 'Room Booking',
                'url'         => Backend::url('tiipiik/roombooking/bookings'),
                'icon'        => 'icon-list',
                'permissions' => ['user:*'],
                'order'       => 500,
                
                'sideMenu'    => [
                    'bookings'  => [
                        'label'       => 'Bookings',
                        'url'         => Backend::url('tiipiik/roombooking/bookings'),
                        'icon'        => 'icon-list',
                        'permissions' => ['user:*'],
                    ],
                    'rooms'  => [
                        'label'       => 'Rooms',
                        'url'         => Backend::url('tiipiik/roombooking/rooms'),
                        'icon'        => 'icon-gear',
                        'permissions' => ['user:*'],
                    ],
                ]
            ]
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     */
    public function register()
    {
        /*
         * Register the image tag processing callback
         */

        TagProcessor::instance()->registerCallback(function($input, $preview){
            if (!$preview)
                return $input;

            return preg_replace('|\<img alt="([0-9]+)" src="image"([^>]*)\/>|m',
                '<span class="image-placeholder" data-index="$1">
                    <span class="dropzone">
                        <span class="label">Click or drop an image...</span>
                        <span class="indicator"></span>
                    </span>
                    <input type="file" class="file" name="image[$1]"/>
                    <input type="file" class="trigger"/>
                </span>', 
            $input);
        });
    }
}
