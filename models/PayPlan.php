<?php namespace Tiipiik\Booking\Models;

use Model;

/**
 * PayPlan Model
 */
class PayPlan extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    public $table = 'tiipiik_booking_pay_plans';
    
    /**
     * @var array Translatable fields
     */
    public $translatable = ['title'];

    protected $guarded = ['*'];
    
    public $rules = [
        'title'=>'required',
    ];
    
     /**
     * Add translation support to this model, if available.
     * @return void
     */
    public static function boot()
    {
        // Call default functionality (required)
        parent::boot();

        // Check the translate plugin is installed
        if (!class_exists('RainLab\Translate\Behaviors\TranslatableModel'))
            return;

        // Extend the constructor of the model
        self::extend(function($model){

            // Implement the translatable behavior
            $model->implement[] = 'RainLab.Translate.Behaviors.TranslatableModel';

        });
    }
}