<?php

return [
    'plugin_name' => 'Booking',
    'plugin_description' => 'Room Booking plugin, with front and backend',
    'settings_description' => 'Configure room booking plugin',
    'booking' => [
        'amount'=>'Amount',
        'currency'=>'Currency',
        'validated'=>'Validated',
        'registered'=>'Registered',
        
        'backend' => [
            'new' => 'New Booking',
            'room_id_label'=>'Room',
            'visitor'=>[
                'tab_title'=>'Visitor',
                'full_name'=>'Full name',
                'email'=>'E-mail',
                'phone'=>'Phone number',
                'persons'=>'Persons',
                'rooms'=>'Rooms',
                'comment'=>'Comment',
            ],
            'stay'=>[
                'tab_title'=>'Visitor stay',
                'checkin'=>'Check in',
                'checkout'=>'Check out',
                'nights'=>'Total nights',
            ],
            'pay_plan'=>[
                'tab_title'=>'Pay plan',
                'options_title'=>'Pay plan',
            ],
            'columns'=>[
                'id'=>'ID',
                'room_name'=>'Room name or number',
                'customer_name'=>'Full name',
                'customer_email'=>'E-mail',
                'customer_phone'=>'Phone',
                'persons'=>'Persons',
                'rooms'=>'Rooms',
                'checkin'=>'Check In',
                'checkout'=>'Check Out',
                'total_days'=>'Total days',
                'total_nights'=>'Total nights',
                'pay_plan'=>'Pay plan',
                'comment'=>'Comment',
            ],
            'select_one' => '-- Select one --',
        ],
    ],
    'room' => [
        'backend' => [
            'new'=>'New Room',
            'name'=>'Room name or Number',
            'name_placeholder'=>'New room name or number',
            'slug'=>'Slug',
            'slug_placeholder'=>'new-room-name-or-number',
            'available_manual'=>'Available (Manualy activate or deactivate)',
            'description_tab_title'=>'Full description',
            'manage_tab_title'=>'Manage',
            'excerpt'=>'Excerpt',
            'max_persons'=>'Max number of persons in the room ',
            'featured_images'=>'Featured images',
            'columns'=> [
                'name'=>'Name or Number',
                'available'=>'Available',
            ]
        ],
    ],
    'payplans' => [
        'backend' => [
            'new'=>'New PayPlan',
            'name'=>'Title',
            'name_ph'=>'Give this pay plan a name',
        ],
    ],
    'components' => [
        'booking_form' => [
            'name' =>'Booking Form',
            'description' =>'Display booking form',
            'params' => [
                'redirect_title' => 'Redirect to',
                'redirect_desc' => 'Page name to redirect to after booking success',
                'room_page_title' => 'Room slug',
                'room_page_desc' => 'The expected parameter name used to the room page. Should be the same as the "Room slug" into the Room Details component',
            ],
        ],
        'room' => [
            'name' => 'Room details',
            'description' => 'Display a room details on the page',
            'params' => [
                'slug_title' => 'Slug param',
                'slug_desc' => 'The URL route parameter used for looking up the room by its slug.',
            ],
        ],
        'room_list' => [
            'name' => 'Room List Component',
            'description' => 'Display a list of rooms',
            'params' => [
                'rooms_per_page_title' => 'Rooms per page',
                'room_per_page_validation' => 'Invalid format of the rooms per page value',
                'page_param_title' => 'Pagination parameter name',
                'page_param_desc' => 'The expected parameter name used by the pagination pages.',
                'room_page_title' => 'Room page',
                'room_page_desc' => 'Name of the room page file for the "Learn more" links. This property is used by the default component partial.',
                'room_slug_title' => 'Room slug',
                'room_slug_desc' => 'The expected parameter name used when creating links to the room page.',
                'no_room_title' => 'No rooms message',
                'no_room_desc' => 'Message to display in the booking room list in case if there are no rooms. This property is used by the default component partial.',
                'no_room_default' => 'No room found',
            ],
        ],
    ],
    'permissions' => [
        'tab' => 'Room Bookings',
        'bookings' => 'Manage bookings',
        'rooms' => 'Manage rooms',
        'payplans' => 'Manage pay plans',
        'settings' => 'Manage settings',
    ],
];