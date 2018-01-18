<?php namespace Tiipiik\Booking\Models;

use Model;
use Carbon\Carbon;
use Tiipiik\Booking\Models\Room;
use Tiipiik\Booking\Models\PayPlan;

/**
 * Booking Model
 */
class Booking extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tiipiik_booking_bookings';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'room_id' => 'required',
        'validated' => '',
        'full_name' => 'required',
        'email' => 'required',
        'phone' => '',
        'persons' => '',
        'rooms' => '',
        'arrival' => 'required',
        'departure' => 'required',
        'total_nights' => '',
        'amount' => '',
        'currency' => '',
        'pay_plan_id' => '',
        'comment' => ''
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'Room' => ['Tiipiik\Booking\Models\Room'],
        'PayPlan' => ['Tiipiik\Booking\Models\PayPlan']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
    
    public static function getRoomsOptions()
    {
        $allRooms = Room::select('id','name')
            ->get();
        
        $aRooms = [];
        
        if (sizeof($allRooms) == 0)
        {
            $aRooms = [
                ''=>'There is no room, create one.'
            ];
        }
        
        foreach ($allRooms as $data)
        {
            $aRooms[$data->id] = $data->name;
        }
        
        return $aRooms;
    }
    
    public static function getPayPlanOptions()
    {
        $allPayPlans = PayPlan::select('id','title')
            ->get();
        
        $aPayPlans = [];
        
        if (sizeof($allPayPlans) == 0)
        {
            $aPayPlans = [
                ''=>'There is no pay plan, create one.'
            ];
        }
        
        foreach ($allPayPlans as $data)
        {
            $aPayPlans[$data->id] = $data->title;
        }
        
        return $aPayPlans;
    }

    public static function getBookedDates($room_slug = null)
    {
        // Retrieve room id from slug
        if (isset($room_slug))
        {
            $room = Room::select('id')
                ->whereSlug($room_slug)
                ->first();
            $room_id = $room->id;
        }
        
        // Select booked dates
        $bookings = self::select('arrival', 'departure');
        
        if (isset($room_slug))
        {
            $bookings = $bookings->whereRoomId($room_id);
        }
        $bookings = $bookings->whereValidated(1)->get();
        
        $bookedDates = collect([]);

        // Creates all dates booked
        foreach ($bookings as $booking) {
            $arrival = new Carbon($booking['arrival']);
            $departure = new Carbon($booking['departure']);

            while ($arrival->lt($departure)) {
                $bookedDates->push([
                    'year' => $arrival->year,
                    'month' => $arrival->month,
                    'day' => $arrival->day
                ]);
                $arrival->addDay();
            }
        }

        // Creates output array
        $array = [];
        $years = $bookedDates->pluck('year')->unique()->sort();
        foreach ($years as $year) {
            $months = $bookedDates->where('year', $year)->pluck('month')->unique()->sort();
            foreach ($months as $month) {
                $days = $bookedDates->where('year', $year)->where('month', $month)->pluck('day')->unique()->sort()->values();
                $array[$year][$month] = $days->toArray();
            }
        }
        
        return $array;
    }

}
