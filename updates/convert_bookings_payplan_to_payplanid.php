<?php namespace Tiipiik\Booking\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class ConvertBookingsPayplanToPayplanid extends Migration
{

    public function up()
    {
        Schema::table('tiipiik_booking_bookings', function($table)
        {
            $table->renameColumn('pay_plan', 'pay_plan_id');
        });
    }

    public function down()
    {
        Schema::table('tiipiik_booking_bookings', function($table)
        {
            $table->renameColumn('pay_plan_id', 'pay_plan');
        });
    }

}
