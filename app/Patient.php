<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
	protected $dates = ['dob','approxdob'];

    public function users(){
    	return $this->belongsToMany('App\User','patient_user','patient_id','user_id');
    }

    public function visits(){
    	return $this->hasMany('App\Visit')->orderBy('created_at','desc');
    }

   public function slots(){
        return $this->hasMany('App\Slot');
   }
}
