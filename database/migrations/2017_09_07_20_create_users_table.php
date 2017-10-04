<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('email',100)->unique();
            $table->string('password');
            $table->string('token')->nullable();
            $table->string('avatar')->default('default.jpg');
            $table->string('phone');
            $table->string('pan')->nullable();
            $table->string('aadhar')->nullable();
            $table->boolean('isActivated')->default(false);
            $table->string('isactivatedtoken')->nullable();
            $table->boolean('verified')->default(false);
            $table->integer('jobtype_id')->unsigned();
            $table->integer('r_id')->unsigned();            
            $table->rememberToken();

            $table->foreign('jobtype_id')->references('id')->on('jobtypes');
            $table->foreign('r_id')->references('id')->on('roles');
            
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
        Schema::dropIfExists('users');
    }
}
