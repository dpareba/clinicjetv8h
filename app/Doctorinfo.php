<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctorinfo extends Model
{
     protected $fillable = [
        'speciality_id','medicalcouncil_id','registrationyear_id','registrationnumber'
    ];

    public function user(){
    	return $this->belongsTo('App\User');
    }
    public function speciality(){
        return $this->belongsTo('App\Speciality');
    }
   public function medicalcouncil(){
        return $this->belongsTo('App\Medicalcouncil');
   }

    public function registrationyear(){
        return $this->belongsTo('App\Registrationyear');
   }

}
