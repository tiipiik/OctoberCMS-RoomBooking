<?php namespace Tiipiik\Booking\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateRoomsTable extends Migration
{

    public function up()
    {
        Schema::create('tiipiik_booking_rooms', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('max_persons')->nullable();
            $table->text('excerpt')->nullable();
            $table->text('content')->nullable();
            $table->text('content_html')->nullable();
            $table->integer('is_available')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('tiipiik_booking_rooms');
    }

}
