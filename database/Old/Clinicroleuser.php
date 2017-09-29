<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinicroleuser extends Model
{
    public function clinic()
    {
    	$this->belongsToMany(Clinic::class);
    }

    public function role()
    {
    	$this->belongsTo(Role::class);
    }

    public function user()
    {
    	$this->belongsTo(User::class);
    }
}
