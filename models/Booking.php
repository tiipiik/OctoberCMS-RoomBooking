<?php namespace Tiipiik\Booking\Models;

use Model;
use Carbon\Carbon;
use Tiipiik\Booking\Models\Room;

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
        'pay_plan' => '',
        'comment' => ''
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'Room' => ['Tiipiik\Booking\Models\Room']
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
                ->get();
        }
        else
        {
            // No room id ? Get all booked dates of all rooms (in this case we consider that only one room exists) 
            $booking = self::select('arrival','departure')
                ->get();
        }
        
        // Construct array of booked dates
        $bookedDates = [];
        
        foreach ($booking as $d)
        {
            $arrival = explode('-', $d->{"arrival"});
            $departure = explode('-', $d->{"departure"});
            
            // Compute difference between arrival and departure, how many nights are booked ?
            $aDate = Carbon::create($arrival[2], $arrival[1], $arrival[0], 0);
            $dDate = Carbon::create($departure[2], $departure[1], $departure[0], 0);
            
            $diffInDays = $dDate->diffInDays($aDate);
            
            // for each booked day, add entry in the array
            for ($i=1;$i<=$diffInDays;$i++)
            {
                $nextDate = $aDate->addDay()->format("d-m-Y");
                $nextDate = explode('-', $nextDate);
                
                // Place year into array
                if ( !in_array((int) $nextDate[2], $bookedDates) )
                {
                    $bookedDates[''] = [
                        (int) $nextDate[2] => []
                    ];
                }
                // Place month into array
                if ( !isset( $bookedDates[ (int) $nextDate[2] ][ (int) $nextDate[1]]) )
                {
                    $bookedDates[ (int) $nextDate[2] ][ (int) $nextDate[1] ] = [];
                }
                // Place day into array
                if ( !isset($bookedDates[ (int) $nextDate[2] ][ (int) $nextDate[1] ][ (int) $nextDate[0] ]) )
                {
                    $bookedDates[ (int) $nextDate[2] ][ (int) $nextDate[1] ][] = (int) $nextDate[0];
                }
            }
        }
        
        return $bookedDates;
    }

}