<?php namespace Tiipiik\Booking\Models;

use Model;

/**
 * PayPlan Model
 */
class PayPlan extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    public $table = 'tiipiik_booking_pay_plans';

    protected $guarded = ['*'];
    
    public $rules = [
        'title'=>'required',
    ];
}