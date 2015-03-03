<?php namespace Tiipiik\Booking\Components;

use Flash;
use Input;
use Redirect;
use Validator;
use Exception;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use ValidationException;
use Tiipiik\Booking\Models\Booking;
use Tiipiik\Booking\Models\PayPlan;


// custom validation rules (could be place in an external file) -- use with not_in rule
Validator::extend('is_booked_date', function($field, $value, $params)
{
    $rules = array();
    foreach ($value as $email)
    {
        $rules[] = array($email=>'email');
    }

    // start validation as 0
    $validation = 0;
    $validator = Validator::make($value, $rules);
    
    if (!$validator->passes())
    {
        $validation++;
    }
    
    if ($validation > 0)
        return false;
    else
        return true;
});

class BookingForm extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'tiipiik.booking::lang.components.booking_form.name',
            'description' => 'tiipiik.booking::lang.components.booking_form.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'redirect' => [
                'title'       => 'tiipiik.booking::lang.components.booking_form.params.redirect_title',
                'description' => 'tiipiik.booking::lang.components.booking_form.params.redirect_desc',
                'type'        => 'dropdown',
                'default'     => '',
            ],
            'room_slug' => [
                'title'       => 'tiipiik.booking::lang.components.booking_form.params.room_page_title',
                'description' => 'tiipiik.booking::lang.components.booking_form.params.room_page_desc',
                'type'        => 'string',
                'default'     => '{{ :slug }}',
            ],
        ];
    }

    public function getRedirectOptions()
    {
        return [''=>'- none -'] + Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }
    
    public function onRun()
    {
        $this->addCss('/plugins/tiipiik/booking/assets/css/datepicker.css');
        $this->addJs('/plugins/tiipiik/booking/assets/js/bootstrap-datepicker.js');
        $this->addJS('/plugins/tiipiik/booking/assets/js/dpb-booking.js');
        
        //$room = new Room;
        $slug = $this->property('room_slug');
        
        $this->payplans = $this->page['payplans'] = $this->listPayPlans();
        
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
        $booking->arrival = self::reforgeDate($data['arrival']);
        $booking->departure = self::reforgeDate($data['departure']);
        $booking->pay_plan_id = $data['pay_plan'];
        $booking->comment = $data['comment'];
        $booking->total_days = 0;
        $booking->total_nights = 0;
        $booking->amount = 0;
        $booking->currency = '';
        $booking->save();
        
        /*
         * Redirect to the intended page after successful booking
         */
        $redirectUrl = $this->pageUrl($this->property('redirect'));

        if ($redirectUrl = post('redirect', $redirectUrl))
            return Redirect::intended($redirectUrl);
        
    }
    
    private function reforgeDate($date)
    {
        $aDate = explode('-', $date);
        $reforgedDate = $aDate[2].'-'.$aDate[1].'-'.$aDate[0];
        
        return $reforgedDate;
    }
    
    protected function listPayPlans()
    {
        $aPayplans = [];
        $payplans = PayPlan::all();
        if (sizeof($payplans) > 0)
        {
            foreach ($payplans as $payplan)
            {
                $aPayplans[] = [
                    'id' => $payplan->id,
                    'title' => $payplan->title,
                ];
            }
        }
        return $aPayplans;
    }

}