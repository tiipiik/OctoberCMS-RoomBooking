<?php

return [
    'booking' => [
        'amount'=>'Amoont',
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
];