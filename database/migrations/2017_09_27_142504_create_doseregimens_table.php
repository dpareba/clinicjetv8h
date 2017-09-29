<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoseregimensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doseregimens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('morning');
            $table->integer('afternoon');
            $table->integer('night');
            $table->integer('sos');
            $table->string('other');
            $table->integer('visit_id')->unsigned();
            $table->integer('dosetype_id')->unsigned();

            $table->foreign('visit_id')->references('id')->on('visits');
            $table->foreign('dosetype_id')->references('id')->on('dosetypes');
            


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
        Schema::dropIfExists('doseregimens');
    }
}
