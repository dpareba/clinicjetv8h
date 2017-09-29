<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slotstatus extends Model
{
    public function slots(){
        return $this->hasMany('App\Slot');
   }
}
