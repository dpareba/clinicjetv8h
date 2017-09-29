<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->increments('id');

            $table->string('cliniccode');
            $table->string('name',100)->unique();
            $table->text('address');
            $table->string('state',50);
            $table->string('city');
            $table->string('pin',6);
            $table->string('clinictype');
            $table->string('phoneprimary',10)->unique();
            $table->string('phoneprimarylandarea',5);
            $table->string('phoneprimarylandtel',8);
            $table->string('phonealternate',10);
            $table->string('email');
            $table->string('website');
            $table->boolean('isActivated')->default(true);

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
        Schema::dropIfExists('clinics');
    }
}
