<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChworkerdaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chworkerdays', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('workerday_id')->unsigned();
            $table->integer('daytype_id')->unsigned();
            $table->string('managernote')->nullable();
            $table->string('workernote')->nullable();
            $table->integer('pub')->default('0');
            $table->foreign('workerday_id')->references('id')->on('days');
            $table->foreign('daytype_id')->references('id')->on('daytypes');
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
        Schema::drop('chworkerdays');
    }
}
