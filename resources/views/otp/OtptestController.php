<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OTPHP\TOTP;

class OtptestController extends Controller
{
    //
    public function index(){
     	
    $otp = $this->createTOTP(6, 'sha1', 30);
   
	// Authorisation details.
	$username = "dilippareba@gmail.com";
	$hash = "99eff0ce725f1651995b499b940f194bd6487c0d8f6d8d7d4aeb1b925f95c4d9";

	// Config variables. Consult http://api.textlocal.in/docs for more info.
	$test = "0";

	// Data for text message. This is the text message data.
	$sender = "TXTLCL"; // This is who the message appears to be from.
	$numbers = "918369705174"; // A single number or a comma-seperated list of numbers
	$message = "Welcome to Clinicjet your OTP is".$otp->now();
	
	// A single number or a comma-seperated list of numbers
	// $message = urlencode($message);
	// $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	// $ch = curl_init('http://api.textlocal.in/send/?');
	// curl_setopt($ch, CURLOPT_POST, true);
	// curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// $result = curl_exec($ch); // This is the result from the API
	// curl_close($ch);
	return view('otptest',['otpgen'=>$otp->now(),'otpat'=>$otp->at(time())]);
    }

    public function verify(Request $request){

 		$otpno = $request['otpno'];
 		$otp = $this->createTOTP(6, 'sha1', 30);
 		$totp = $otp->at(time());
 		$result = $otp->verify($otpno);
 		echo $totp.'|'.$otpno.'|'.$result;
    	
    }

    private function createTOTP($digits, $digest, $period, $secret = 'JDDK4U6G3BJLEZ7Y', $label='', $issuer="Clinicjet")
    {
        $otp = new TOTP($label, $secret, $period, $digest, $digits);
        $otp->setIssuer($issuer);

        return $otp;
    }


}
