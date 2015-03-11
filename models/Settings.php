<?php namespace Tiipiik\Booking\Models;

use October\Rain\Database\Model;

/**
 * Tiipiik Booking plugin settings model
 *
 * @package system
 * @author Matiss Janis Aboltins <matiss@mja.lv>
 */
class Settings extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'tiipiik_booking_settings';

    public $settingsFields = 'fields.yaml';

    /**
     * Validation rules
     */
    public $rules = [
        'roomPage' => 'required',
        'room_page_slug' => 'required',
    ];
}