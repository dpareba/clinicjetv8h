<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctorinfos', function (Blueprint $table) {
            $table->increments('id');

            $table->string('registrationnumber');
            $table->integer('speciality_id')->unsigned();
            $table->integer('medicalcouncil_id')->unsigned();
            $table->integer('registrationyear_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('speciality_id')->references('id')->on('specialities');
            $table->foreign('medicalcouncil_id')->references('id')->on('medicalcouncils');
            $table->foreign('registrationyear_id')->references('id')->on('registrationyears');      

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
        Schema::dropIfExists('doctorinfos');
    }
}
