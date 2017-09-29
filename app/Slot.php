<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{

	protected $dates = ['slotdate'];

     public function user(){
    	return $this->belongsTo('App\User');
    }

      public function patient(){
    	return $this->belongsTo('App\Patient');
    }

    public function clinic(){
    	return $this->belongsTo('App\Clinic');
    }

    public function slotstatus(){
      return $this->belongsTo('App\Slotstatus');
    }
}
