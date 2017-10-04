<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ActivationController extends Controller
{
    
    public function activateuser($token){
    	
    	$user = User::where('isactivatedtoken','=',$token)->first();
    	//dd($user);
    	if ($user == null) {
    		$message = 'User is already activated OR token is invalid';
    		return view('activation.useractivationstatus')->withMessage($message);
    	}else{
    		$user->isActivated = true;
    		$user->isactivatedtoken = null;
    		$user->save();
    		$message = 'User activated successfully';
    		return view('activation.useractivationstatus')->withMessage($message);
    	}
    }
}
