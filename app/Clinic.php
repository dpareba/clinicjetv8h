<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
	
    public function users()
    {
        return $this->belongsToMany('App\User','clinic_role_user','clinic_id','user_id');
    }

    public function visits(){
    	return $this->hasMany('App\Visit');
    }

    public function slots(){
        return $this->hasMany('App\Slot');
   }
}
