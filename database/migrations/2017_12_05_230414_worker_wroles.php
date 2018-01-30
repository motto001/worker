<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WorkerWroles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_wroles', function(Blueprint $table) {
        $table->increments('id');
        $table->integer('worker_id')->unsigned();
        $table->foreign('worker_id')->references('id')->on('workers');
        $table->integer('wrole_id')->unsigned();
        $table->foreign('wrole_id')->references('id')->on('wroles');
        $table->date('start');
        $table->date('end');
        });
   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('worker_wroles');
    }
}
