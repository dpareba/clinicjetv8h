<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');

            $table->string('joincode')->nullable();
            $table->boolean('isActive')->default(false);
            
            $table->integer('clinic_id')->unsigned();
            $table->integer('jobtype_id')->unsigned();

            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('jobtype_id')->references('id')->on('jobtypes');


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
        Schema::dropIfExists('members');
    }
}
