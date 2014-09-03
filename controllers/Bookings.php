<?php namespace Tiipiik\Booking\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Bookings Back-end Controller
 */
class Bookings extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $bodyClass = 'compact-container';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Tiipiik.Booking', 'booking', 'bookings');
    }
}