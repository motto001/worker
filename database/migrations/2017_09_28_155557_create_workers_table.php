<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('worker_wrole_id')->unsigned();
            $table->foreign('worker_wrole_id')->references('id')->on('worker_wroles');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->integer('workertype_id')->unsigned();
            $table->foreign('workertype_id')->references('id')->on('workertypes');
            $table->integer('workergroup_id')->unsigned();
            $table->foreign('workergroup_id')->references('id')->on('workergroups');
            $table->integer('salary');
            $table->string('salary_type');
            $table->string('position');
            $table->string('foto')->nullable();
            $table->string('fullname');
            $table->string('cim');
            $table->string('tel')->nullable();
            $table->date('birth');
            $table->string('ado')->nullable();
            $table->string('tb')->nullable();
            $table->date('start');
            $table->date('end')->nullable();
            $table->string('note')->nullable();
            $table->integer('pub');       
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
        Schema::drop('workers');
    }
}
