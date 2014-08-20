<?php namespace Tiipiik\Booking\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreatePayPlansTable extends Migration
{

    public function up()
    {
        Schema::create('tiipiik_booking_pay_plans', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tiipiik_booking_pay_plans');
    }

}
