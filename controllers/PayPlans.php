<?php namespace Tiipiik\Booking\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * PayPlans Back-end Controller
 */
class PayPlans extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Tiipiik.Booking', 'booking', 'payplans');
    }
}