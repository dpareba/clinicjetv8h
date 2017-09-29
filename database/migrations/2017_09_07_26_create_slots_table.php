<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slots', function (Blueprint $table) {
            $table->increments('id');

            $table->date('slotdate');
            $table->integer('token')->default(0);
            $table->string('systolic')->nullable();
            $table->string('diastolic')->nullable();
            $table->string('randombs')->nullable();
            $table->string('pulse')->nullable();
            $table->string('resprate')->nullable();
            $table->string('spo')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('bmi')->nullable();
            $table->boolean('isactive')->default(false);

            $table->datetime('issuetime')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->datetime('arrivaltime');
            $table->string('status',50)->nullable();
            $table->datetime('visitstart');
            $table->datetime('visitend');
            
            $table->integer('user_id')->unsigned();
            $table->integer('patient_id')->unsigned();
            $table->integer('clinic_id')->unsigned();
            $table->integer('slotstatus_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('slotstatus_id')->references('id')->on('slotstatuses');
           

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
        Schema::dropIfExists('slots');
    }
}
