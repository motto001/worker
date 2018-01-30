<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKapcsoloTable extends Migration
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


        Schema::create('wroleunit_wrole', function(Blueprint $table) {
            
              $table->integer('wroleunit_id')->unsigned();
              $table->foreign('wroleunit_id')->references('id')
              ->on('wroleunits')->onDelete('cascade');

              $table->integer('wrole_id')->unsigned();
              $table->foreign('wrole_id')->references('id')
              ->on('wroles')->onDelete('cascade');
          }); 
         Schema::create('worker_timeframe', function(Blueprint $table) {
            
              $table->integer('timeframe_id')->unsigned();
              $table->foreign('timeframe_id')->references('id')
              ->on('timeframes')->onDelete('cascade');

              $table->integer('worker_id')->unsigned();
              $table->foreign('worker_id')->references('id')
              ->on('workers')->onDelete('cascade');
          });
          Schema::create('daytype_timeframe', function(Blueprint $table) {
            
              $table->integer('timeframe_id')->unsigned();
              $table->foreign('timeframe_id')->references('id')
              ->on('timeframes')->onDelete('cascade');

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
