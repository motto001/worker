<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChworkertimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chworkertimes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('workerday_id')->unsigned();
            $table->foreign('workerday_id')->references('id')->on('workerdays');
            $table->integer('workertime_id')->unsigned();
            $table->foreign('workertime_id')->references('id')->on('workertimes');
            $table->integer('timetype_id')->unsigned();
            $table->foreign('timetype_id')->references('id')->on('timetypes');
            $table->time('start');
            $table->time('end')->nullable();
            $table->integer('hour');
            $table->string('managernote')->nullable();
            $table->string('workernote')->nullable();
            $table->integer('pub')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chworkertimes');
    }
}
