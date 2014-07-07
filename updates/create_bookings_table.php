<?php namespace Tiipiik\Booking\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateBookingsTable extends Migration
{

    public function up()
    {
        Schema::create('tiipiik_booking_bookings', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('room_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('full_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('persons')->nullable();
            $table->string('rooms')->nullable();
            $table->string('arrival')->nullable();
            $table->string('departure')->nullable();
            $table->integer('total_days')->nullable();
            $table->integer('total_nights')->nullable();
            $table->integer('amount')->nullable();
            $table->string('currency')->nullable();
            $table->string('pay_plan')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('validated')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('tiipiik_booking_bookings');
    }

}
