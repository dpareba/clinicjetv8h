<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicalcouncil extends Model
{
    public function users(){
    	return $this->hasMany('App\User');
    }
}
