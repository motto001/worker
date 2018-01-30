<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Kapcsolo2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wroleunit_daytype', function(Blueprint $table) {
            
              $table->integer('wroleunit_id')->unsigned();
              $table->foreign('wroleunit_id')->references('id')
              ->on('wroleunits')->onDelete('cascade');
  
              $table->integer('daytype_id')->unsigned();
              $table->foreign('daytype_id')->references('id')
              ->on('daytypes')->onDelete('cascade');
          });  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
