<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->increments('id');

            $table->text('rem_notes')->nullable();
            $table->text('rem_history')->nullable();
            $table->text('rem_complaints')->nullable();
            $table->text('chiefcomplaints')->nullable();
            $table->text('examinationfindings')->nullable();
            $table->text('patienthistory')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('advise')->nullable();
            $table->string('systolic')->nullable();
            $table->string('diastolic')->nullable();
            $table->string('randombs')->nullable();
            $table->string('pulse')->nullable();
            $table->string('resprate')->nullable();
            $table->string('spo')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('bmi')->nullable();
            $table->boolean('isSOS')->default(true);
            $table->date('nextvisit');
            $table->string('created_by_name');

            $table->integer('clinic_id')->unsigned();
            $table->integer('patient_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('visits');
    }
}
