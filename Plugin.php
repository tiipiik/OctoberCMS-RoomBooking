<?php namespace Tiipiik\Booking;

use Backend;
use Event;
use System\Classes\PluginBase;
use Tiipiik\Booking\Classes\TagProcessor;
use Tiipiik\Booking\Models\Room;

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
            'name'        => 'tiipiik.booking::lang.plugin_name',
            'description' => 'tiipiik.booking::lang.plugin_description',
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
    
	public function registerPermissions()
	{
		return [
            'tiipiik.booking.access_bookings' => [
                'tab' => 'tiipiik.booking::lang.permissions.tab',
                'label' => 'tiipiik.booking::lang.permissions.bookings'
            ],
            'tiipiik.booking.access_rooms' => [
                'tab' => 'tiipiik.booking::lang.permissions.tab',
                'label' => 'tiipiik.booking::lang.permissions.rooms'
            ],
            'tiipiik.booking.access_payplans' => [
                'tab' => 'tiipiik.booking::lang.permissions.tab',
                'label' => 'tiipiik.booking::lang.permissions.payplans'
            ],
            'tiipiik.booking.manage_settings' => [
                'tab' => 'tiipiik.booking::lang.permissions.tab',
                'label' => 'tiipiik.booking::lang.permissions.settings'
            ],
        ];
	} 
    
    public function registerNavigation()
    {
        return [
            'booking' => [
                'label'       => 'Room Booking',
                'url'         => Backend::url('tiipiik/booking/bookings'),
                'icon'        => 'icon-list',
                'permissions' => ['tiipiik.booking.*'],
                'order'       => 500,
                
                'sideMenu'    => [
                    'bookings'  => [
                        'label'       => 'Bookings',
                        'url'         => Backend::url('tiipiik/booking/bookings'),
                        'icon'        => 'icon-list',
                        'permissions' => ['tiipiik.booking.access_bookings'],
                    ],
                    'rooms'  => [
                        'label'       => 'Rooms',
                        'url'         => Backend::url('tiipiik/booking/rooms'),
                        'icon'        => 'icon-gear',
                        'permissions' => ['tiipiik.booking.access_rooms'],
                    ],
                    'payplans'  => [
                        'label'       => 'Pay PLans',
                        'url'         => Backend::url('tiipiik/booking/payplans'),
                        'icon'        => 'icon-money',
                        'permissions' => ['tiipiik.booking.access_payplans'],
                    ],
                ]
            ]
        ];
    }

    public function registerSettings()
    {
        return [
            'config' => [
                'label'       => 'tiipiik.booking::lang.plugin_name',
                'icon'        => 'icon-list',
                'description' => 'tiipiik.booking::lang.settings_description',
                'class'       => 'Tiipiik\Booking\Models\Settings',
                'permissions' => ['tiipiik.booking.manage_settings'],
                'keywords'    => 'room booking pay plans'
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

    public function boot()
    {
        /*
         * Register menu items for the RainLab.Pages and RainLab.Sitemap plugin
         */
        Event::listen('pages.menuitem.listTypes', function() {
            return [
                'all-rooms' => 'All rooms',
            ];
        });

        Event::listen('pages.menuitem.getTypeInfo', function($type) {
            if ($type == 'all-rooms')
                return Room::getMenuTypeInfo($type);
        });

        Event::listen('pages.menuitem.resolveItem', function($type, $item, $url, $theme) {
            if ($type == 'all-rooms')
                return Room::resolveMenuItem($item, $url, $theme);
        });
    }
}
