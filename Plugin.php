<?php namespace Tiipiik\Booking;

use Backend;
use System\Classes\PluginBase;
use Tiipiik\Booking\Classes\TagProcessor;

/**
 * Booking Plugin Information File
 */
class Plugin extends PluginBase
{

    public $require = ['RainLab.Translate'];
    
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Booking',
            'description' => 'Room Booking plugin, with front and backend',
            'author'      => 'Tiipiik',
            'icon'        => 'icon-leaf'
        ];
    }

    public function registerFormWidgets()
    {
        return [
            'Tiipiik\Booking\FormWidgets\Preview' => [
                'label' => 'Preview',
                'alias' => 'preview'
            ]
        ];
    }
    
    public function registerComponents()
    {
        return [
            'Tiipiik\Booking\Components\RoomList' => 'room_list',
            'Tiipiik\Booking\Components\Room' => 'room',
            'Tiipiik\Booking\Components\BookingForm' => 'booking_form',
        ];
    }
    
    public function registerNavigation()
    {
        return [
            'booking' => [
                'label'       => 'Room Booking',
                'url'         => Backend::url('tiipiik/booking/bookings'),
                'icon'        => 'icon-list',
                'permissions' => ['user:*'],
                'order'       => 500,
                
                'sideMenu'    => [
                    'bookings'  => [
                        'label'       => 'Bookings',
                        'url'         => Backend::url('tiipiik/booking/bookings'),
                        'icon'        => 'icon-list',
                        'permissions' => ['user:*'],
                    ],
                    'rooms'  => [
                        'label'       => 'Rooms',
                        'url'         => Backend::url('tiipiik/booking/rooms'),
                        'icon'        => 'icon-gear',
                        'permissions' => ['user:*'],
                    ],
                    'payplans'  => [
                        'label'       => 'Pay PLans',
                        'url'         => Backend::url('tiipiik/booking/payplans'),
                        'icon'        => 'icon-money',
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
