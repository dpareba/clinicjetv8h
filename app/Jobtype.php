<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jobtype extends Model
{
    public function user(){
    	return $this->hasMany('App\User');
    }
}
