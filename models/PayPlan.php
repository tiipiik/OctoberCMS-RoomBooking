<?php namespace Tiipiik\Booking\Models;

use Model;

/**
 * PayPlan Model
 */
class PayPlan extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tiipiik_booking_pay_plans';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}