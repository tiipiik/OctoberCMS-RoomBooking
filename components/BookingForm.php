<?php namespace Tiipiik\RoomBooking\Components;

use Flash;
use Input;
use Redirect;
use Validator;
use Exception;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use October\Rain\Support\ValidationException;
use Tiipiik\RoomBooking\Models\Booking;
use Tiipiik\RoomBooking\Components\Room;

class BookingForm extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Booking Form Component',
            'description' => 'Display booking form'
        ];
    }

    public function defineProperties()
    {
        return [
            'redirect' => [
                'title'       => 'Redirect to',
                'description' => 'Page name to redirect to after booking success',
                'type'        => 'dropdown',
                'default'     => '',
            ],
            'roomPageIdParam' => [
                'title'       => 'Room page param name',
                'description' => 'The expected parameter name used to the room page. Should be the same as the "Slug param name" into the Room Details component',
                'type'        => 'string',
                'default'     => ':slug',
            ],
        ];
    }

    public function getRedirectOptions()
    {
        return [''=>'- none -'] + Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }
    
    public function onRun()
    {
        $this->addCss('/plugins/tiipiik/roombooking/assets/css/datepicker.css');
        $this->addJs('/plugins/tiipiik/roombooking/assets/js/bootstrap-datepicker.js');
        $this->addJS('/plugins/tiipiik/roombooking/assets/js/dpb-booking.js');
        
        $room = new Room;
        $slug = $room->property('idParam');
        $slug = str_replace(':', '', $slug);
        $slug = $this->param($slug);
        
        $bookedDates = Booking::getBookedDates($slug);
        
        $this->booked_dates = $this->page['booked_dates'] = json_encode($bookedDates);
    }
    
    public function onBooking()
    {
        /*
         *    Validate Input
         */
        $rules = [
            'room_id'   => 'required',
            'name'      => 'required',
            'email'     => 'required|email|min:2|max:64',
            'phone'     => 'required',
            'persons'   => 'required|numeric',
            'rooms'     => 'required|numeric',
            'arrival'   => 'required|date',
            'departure' => 'required|date',
            'pay_plan'  => '',
            'comment'   => '',
        ];
        
        $validation = Validator::make(post(), $rules);
        if ($validation->fails())
            throw new ValidationException($validation);
        
        /*
         * Record Booking
         */
        $data = Input::all();
        
        $booking = new Booking();
        $booking->room_id = $data['room_id'];
        $booking->full_name = $data['name'];
        $booking->email = $data['email'];
        $booking->phone = $data['phone'];
        $booking->persons = $data['persons'];
        $booking->rooms = $data['rooms'];
        $booking->arrival = $data['arrival'];
        $booking->departure = $data['departure'];
        $booking->pay_plan = $data['pay_plan'];
        $booking->comment = $data['comment'];
        $booking->total_days = '';
        $booking->total_nights = '';
        $booking->amount = '';
        $booking->currency = '';
        $booking->save();
        
        /*
         * Redirect to the intended page after successful booking
         */
        $redirectUrl = $this->pageUrl($this->property('redirect'));

        if ($redirectUrl = post('redirect', $redirectUrl))
            return Redirect::intended($redirectUrl);
        
    }

}