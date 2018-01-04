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
        $booking = self::select('arrival', 'departure');
        
        if (isset($room_slug))
        {
            $booking = $booking->whereRoomId($room_id);
        }
        $booking = $booking->whereValidated(1)->get();
        
        
        // Construct array of booked dates
        $bookedDates = [];
        
        foreach ($booking as $d)
        {
            $arrival = $d->{"arrival"};
            $departure = $d->{"departure"};
            
            // Compute difference between arrival and departure, how many nights are booked ?
            $aDate = new Carbon($arrival);
            $dDate = new Carbon($departure);

            $diffInDays = $dDate->diffInDays($aDate);

            // for each booked day, add entry in the array
            for ($i=1;$i<=$diffInDays;$i++)
            {
                $nextDate = $aDate->format("Y-m-d");
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

                $aDate->addDay();
            }
        }
        
        return $bookedDates;
    }

}
