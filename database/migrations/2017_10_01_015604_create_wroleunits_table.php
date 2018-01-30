<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWroleunitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wroleunits', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('unit');
            $table->integer('long');
            $table->string('note')->nullable();
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
        Schema::drop('wroleunits');
    }
}
