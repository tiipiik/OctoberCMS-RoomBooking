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

    public static function getBookedDates($roomSlug = null)
    {
        // Retrieve room id from slug
        if (isset($roomSlug))
        {
            $room = Room::select('id')
                ->where('slug', '=', $roomSlug)
                ->first();
            $roomId = $room->id;
        }
        
        // Select booked dates
        // don't know why this doesn't work when separate requests oO
        if (isset($roomSlug))
        {
            $booking = self::select('arrival','departure')
                ->where('room_id', '=', $roomId)
                ->whereValidated(1)
                ->get();
        }
        else
        {
            // No room id ? Get all booked dates of all rooms (in this case we consider that only one room exists) 
            $booking = self::select('arrival','departure')
                ->whereValidated(1)
                ->get();
        }
        
        // Construct array of booked dates
        $bookedDates = [];
        
        foreach ($booking as $d)
        {
            $arrival = explode('-', $d->{"arrival"});
            $departure = explode('-', $d->{"departure"});
            
            if (isset($arrival[0]) && !empty($arrival[0])
                && isset($departure[0]) && !empty($departure[0]))
            {
                // Compute difference between arrival and departure, how many nights are booked ?
                $aDate = Carbon::create($arrival[0], $arrival[1], $arrival[2], 0);
                $dDate = Carbon::create($departure[0], $departure[1], $departure[2], 0);
                
                $diffInDays = $dDate->diffInDays($aDate);
                
                // for each booked day, add entry in the array
                for ($i=1;$i<=$diffInDays;$i++)
                {
                    $nextDate = $aDate->addDay()->format("Y-m-d");
                    $nextDate = explode('-', $nextDate);
                    
                    // Place year into array
                    if ( !in_array((int) $nextDate[2], $bookedDates) )
                    {
                        $bookedDates[''] = [
                            (int) $nextDate[2] => []
                        ];
                    }
                    // Place month into array
                    if ( !isset( $bookedDates[ (int) $nextDate[0] ][ (int) $nextDate[1]]) )
                    {
                        $bookedDates[ (int) $nextDate[0] ][ (int) $nextDate[1] ] = [];
                    }
                    // Place day into array
                    if ( !isset($bookedDates[ (int) $nextDate[0] ][ (int) $nextDate[1] ][ (int) $nextDate[2] ]) )
                    {
                        $bookedDates[ (int) $nextDate[0] ][ (int) $nextDate[1] ][] = (int) $nextDate[2];
                    }
                } 
            }
        }
        
        return $bookedDates;
    }

}