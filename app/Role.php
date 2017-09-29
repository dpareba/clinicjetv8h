<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

	public function users()
	{
		return $this->belongsToMany('App\User','role_clinic_user','role_id','user_id');
	}
    public function user(){
    	return $this->hasMany('App\User');
    }


}
