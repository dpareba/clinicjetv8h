<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use App\Http\Requests;
use Carbon\Carbon;
use OTPHP\TOTP;

use Auth;
use Session;
use Charts;

use App\User;
use App\Patient;
use App\Clinic;
use App\Pathology;
use App\State;
use App\Visit;
use App\Template;
use App\Slot;
use App\Consent;
use App\Jobtype;


class PatientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $patients = Patient::all();
        return view('patients.index',['patients'=>$patients]);
     }

    public function dashboard(Request $request)
    {

        $clinic = Clinic::find($request)->first();
        Session::put('clinicid',$clinic->id);
        $clinicid = Session::get('clinicid');
        $dt = Carbon::now('Asia/Kolkata');
        $slots = Slot::where('clinic_id',$clinicid)->where('user_id','=',Auth::user()->id)->where('slotdate','=',$dt->toDateString())->orderBy('token','asc')->get();
        return view('patients.today',['slots'=>$slots]);
    }

    public function create()
    {
        $states = State::all();
        return view('patients.create1')->withStates($states);
    }

    public function store(Request $request)
    {
        if ($request->cbage == "on") {
            $this->validate($request,[
                'approxage'=>'required',
                'name'=>'required|max:255',
                'midname'=>'max:255',
                'surname'=>'required|max:255',
                'dob'=>'date_format:d/m/Y|before:tomorrow',
                'gender'=>'required|max:6',
                'bloodgroup'=>'required|max:10',
                'allergies'=>'required',
                'address'=>'required',
                'patientstate'=>'required',
                'patientcity'=>'required',
                'patientpin'=>'required|min:6|max:6',
                'idproof' => 'digits:12|unique:patients,idproof',
                'phoneprimary'=>'required|digits:10|unique:patients,phoneprimary',
                'phonealternate'=>'required|digits:10',
                'email'=>'email'
                ],[
                'approxage.required'=>'Approximate age of patient not entered',
                'name.required'=>'First Name is required to be entered',
                'surname.required'=>'Surname is required to be entered',
                'name.alpha'=>'The Name may only contain alphabets',
                'allergies.required'=>'Please enter know allergies.Enter Not known otherwise.',
                'phoneprimary.required'=>'Primary Phone Number is compulsory',
                'phoneprimary.digits'=>'Phone number needs to contain 10 digits',
                'phoneprimary.unique'=>'Patient with this phone number is already registered',
                'phonealternate.required'=>'Emergency Phone Number is compulsory',
                'phonealternate.digits'=>'Phone number needs to contain 10 digits',
                'idproof.digits'=>'Aadhar number needs to contain 12 digits',
                'dob.date'=>'The Date of Birth should be in mm/dd/yyyy format.',
                'dob.before'=>'The Date of Birth cannot be later than the date today.',
                'idproof.digits'=>'Invalid Aadhar Number',
                'idproof.unique'=>'Aadhar number already exists'
                ]);
        }
        else
        {
            $this->validate($request,[
                'name'=>'required|max:255',
                'midname'=>'max:255',
                'surname'=>'required|max:255',
                'dob'=>'date_format:d/m/Y|before:tomorrow',
                'gender'=>'required|max:6',
                'bloodgroup'=>'required|max:10',
                'allergies'=>'required',
                'address'=>'required',
                'patientstate'=>'required',
                'patientcity'=>'required',
                'patientpin'=>'required|min:6|max:6',
                'idproof' => 'digits:12|unique:patients,idproof',
                'phoneprimary'=>'required|digits:10|unique:patients,phoneprimary',
                'phonealternate'=>'required|digits:10',
                'email'=>'email'
                ],[
                'name.required'=>'First Name is required to be entered',
                'surname.required'=>'Surname is required to be entered',
                'name.alpha'=>'The Name may only contain alphabets',
                'allergies.required'=>'Please enter know allergies.Enter Not known otherwise.',
                'phoneprimary.required'=>'Primary Phone Number is compulsory',
                'phoneprimary.digits'=>'Phone number needs to contain 10 digits',
                'phoneprimary.unique'=>'Patient with this phone number is already registered',
                'dob.date'=>'The Date of Birth should be in mm/dd/yyyy format.',
                'dob.before'=>'The Date of Birth cannot be later than the date today.',
                'idproof.digits'=>'Invalid Aadhar Number',
                'idproof.unique'=>'Aadhar number already exists'
                ]);
        }

        $clinic = Clinic::where(['cliniccode'=>Session::get('clinicid')])->first();
        $patient = new Patient;
        $name = trim(Str::upper($request->name));
        $midname = trim(Str::upper($request->midname));
        $surname = trim(Str::upper($request->surname));
        $namesur = $name+$surname;
        $namemidsur = $name+$midname+$surname;
        $patient->name =  $name;
        $patient->midname = $midname;
        $patient->surname = $surname;
        $patient->namemidsur = $namemidsur;
        $patient->namesur = $namesur;

        if ($request->dob == "")
        {
            $input = '01/01/1900';
        }
        else
        {
            $input = $request->dob;
        }
        if($request->cbage == "on")
        {
            $patient->isapproxage = true;
            $approxdobinput = $request->approxdob;
            $patient->approxage = $request->approxage;
        }
        else
        {
            $patient->isapproxage = false;
            $approxdobinput = '01/01/1900';
            $patient->approxage = '';
        }
        $format = 'd/m/Y';
        $date = Carbon::createFromFormat($format,$input);
        $patient->dob = $date;
        $approxdate = Carbon::createFromFormat($format,$approxdobinput);
        $patient->approxdob = $approxdate;
        $patient->gender = Str::upper($request->gender);
        $patient->phoneprimary = $request->phoneprimary;
        $patient->phonealternate = $request->phonealternate;
        $patient->email = $request->email;
        $patient->address = Str::upper($request->address);
        $patient->patientstate = Str::upper($request->patientstate);
        $patient->patientcity = Str::upper($request->patientcity);
        $patient->patientpin = Str::upper($request->patientpin);
        $patient->allergies = Str::upper($request->allergies);
        $patient->bloodgroup = $request->bloodgroup;
        $maxpatid = Patient::orderBy('id','desc')->first();
        $maxpatid = Patient::orderBy('patientcode','desc')->first();
        if ($maxpatid == null)
        {
            $patient->patientcode = 1000;
        }
        else
        {
             $patient->patientcode = $maxpatid->patientcode + 1;
        }

        $patient->idproof = $request->idproof;

        $patient->created_by = Auth::user()->id;
        $patient->save();
        $jobtype = Auth::user()->jobtype()->first();
        if($jobtype->jobtype=="Doctor")
        {

            $patient->users()->attach(Auth::user()->id);
        }
        

        Session::flash('message','Success!!');
        Session::flash('text','New Patient Added to Clinic successfully!!');
        Session::flash('type','success');
        Session::flash('timer','5000');

        return redirect()->route('patients.index');
    }


    public function createconsult($id,$repeatvisitid,$editconsult)
    {
        $patient = Patient::findOrFail($id);

        $visitstart = Carbon::now('Asia/Kolkata');

        $slot = Slot::where('patient_id',$id)->where('visitstart',null)->first();
        if($slot)
        {
            $slot->visitstart = $visitstart;
            $slot->status = "With Doctor";
            $slot->save();
        }

        $uservalid = Auth::user()->patients()->where('patient_id',$id)->first();
        if($uservalid==null)
        {
            return back();
        }
        if ($repeatvisitid!=0)
        {
            $repeatid = $repeatvisitid;
        }
        else
        {
            $repeatid = 0;
        }
                
        $user = User::find($patient->created_by);
        $pathologies = Pathology::where('user_id','=','1')->orWhere('user_id','=',Auth::user()->id)->get();
        $templates = Template::where('user_id','=',Auth::user()->id)->get();
        $bpdata = Visit::where('patient_id','=',$patient->id)->where('systolic','!=','')->where('diastolic','!=','')->get();
        $randombsdata = Visit::where('patient_id','=',$patient->id)->where('randombs','!=','')->get();
        $pulsedata = Visit::where('patient_id','=',$patient->id)->where('pulse','!=','')->get();
        $respratedata = Visit::where('patient_id','=',$patient->id)->where('resprate','!=','')->get();
        $spodata = Visit::where('patient_id','=',$patient->id)->where('spo','!=','')->get();
        $weightdata = Visit::where('patient_id','=',$patient->id)->where('weight','!=','')->get();
        $heightdata = Visit::where('patient_id','=',$patient->id)->where('height','!=','')->get();
        $bmidata = Visit::where('patient_id','=',$patient->id)->where('bmi','!=','')->get();

        $bpchart = Charts::multi('areaspline','highcharts')
        ->height(250)
        ->colors(['#72DDF7','#2F4858'])
        ->title('Blood Pressure (mmHg)')
        ->elementLabel('mmHg')
        ->labels($bpdata->pluck('created_at'))
        ->dataset('Systolic',$bpdata->pluck('systolic'))
        ->dataset('Diastolic',$bpdata->pluck('diastolic'))
        ->responsive(false);

        $randombschart = Charts::multi('line','highcharts')
        ->height(300)
        ->colors(['#2F4858'])
        ->title('Random Blood Sugar (mg/dl)')
        ->elementLabel('mg/dl')
        ->labels($randombsdata->pluck('created_at'))
        ->dataset('Random Blood Sugar',$randombsdata->pluck('randombs'))
        ->responsive(false);

        $pulsechart = Charts::multi('line','highcharts')
        ->height(300)
        ->colors(['#2F4858'])
        ->title('Pulse (beats per minute)')
        ->elementLabel('beats per minute')
        ->labels($pulsedata->pluck('created_at'))
        ->dataset('Pulse',$pulsedata->pluck('pulse'))
        ->responsive(false);

        $respratechart = Charts::multi('area','highcharts')
        ->height(300)
        ->colors(['#2F4858'])
        ->title('Respiratory Rate (breaths per minute)')
        ->elementLabel('breaths per minute')
        ->labels($respratedata->pluck('created_at'))
        ->dataset('Respiratory Rate',$respratedata->pluck('resprate'))
        ->responsive(false);

        $spochart = Charts::multi('bar','highcharts')
        ->height(300)
        ->colors(['#2F4858'])
        ->title('SPO2 (%)')
        ->elementLabel('%')
        ->labels($spodata->pluck('created_at'))
        ->dataset('SPO2',$spodata->pluck('spo'))
        ->responsive(false);

        $weightchart = Charts::multi('areaspline','highcharts')
        ->height(300)
        ->colors(['#2F4858'])
        ->title('Weight (in kgs)')
        ->elementLabel('kgs')
        ->labels($weightdata->pluck('created_at'))
        ->dataset('Weight',$weightdata->pluck('weight'))
        ->responsive(false);

        $heightchart = Charts::multi('bar','highcharts')
        ->height(300)
        ->colors(['#2F4858'])
        ->title('height (in cms)')
        ->elementLabel('cms')
        ->labels($heightdata->pluck('created_at'))
        ->dataset('Height',$heightdata->pluck('height'))
        ->responsive(false);

        $bmichart = Charts::multi('line','highcharts')
        ->height(300)
        ->colors(['#2F4858'])
        ->title('BMI')
        ->elementLabel('BMI')
        ->labels($bmidata->pluck('created_at'))
        ->dataset('BMI',$bmidata->pluck('bmi'))
        ->responsive(false);

        return view('patients.createconsult')->withPatient($patient)->withUser($user)->withPathologies($pathologies)->withBpchart($bpchart)->withRandombschart($randombschart)->withPulsechart($pulsechart)->withRespratechart($respratechart)->withSpochart($spochart)->withWeightchart($weightchart)->withHeightchart($heightchart)->withBmichart($bmichart)->withTemplates($templates)->withRepeatid($repeatid)->withEditconsult($editconsult);
    }

    public function show($id)
    {

        $patient = Patient::find($id);
        $user = Auth::user()->patients()->where('patient_id',$id)->first();
        if($user==null && Auth::user()->jobtype->jobtype=="Doctor")
        {
             return view('patients.consent',['patient'=>$patient->id,'userid'=>Auth::user()->id,'event'=>'addpatient']);
        }
       return  view('patients.show',['patient'=>$patient]);

    }
 
    public function consent(request $request)
    {

        $otpno = $request['consent'];
        $otp = $this->createTOTP(6, 'sha1', 60);
        $totp = $otp->at(time());
        $result = $otp->verify($otpno);

        $clinicid = Session::get('clinicid');
        $patientid = $request->patientid;
        $userid = $request->userid;
        $event = $request->event;
        
        if($result){
            $match = Consent::where('otp',$otpno)->where('clinic_id',$clinicid)->where('user_id',$userid)->where('patient_id',$patientid)->first();            
            $consent = Consent::find($match->id);
            $consent->matchotp = $otpno;
            $consent->save();
            $event = $consent->event;
            switch ($event)
            {
                case 'addpatient':
                    $user = User::find($userid);
                    $user->patients()->attach($patientid);
                    return redirect()->route('patients.show',['patientid'=>$patientid]);
                break;
                case 'editpatient':
                    $patient = Patient::find($patientid);
                    return view('patients.edit',['patient'=>$patient]);
                break;
                case 'assigntoken':
                    $user = User::find($userid);
                    $user->patients()->attach($patientid);
                    $jobtype = Jobtype::where('jobtype','Doctor')->first();
                    $users = Clinic::find($clinicid)->users()->where('jobtype_id',$jobtype->id)->get();
                    $patient = Patient::findOrFail($patientid);
                    return view('slots.assigntoken')->withPatient($patient)->withUsers($users);
                    
                break;
            }

            Session::flash('message','Success!!');
            Session::flash('text','Consent successfully accepted!');
            Session::flash('type','success');
            Session::flash('timer','5000');

            
        }
        else
        {
            Session::flash('message','Oops!!');
            Session::flash('text','Consent OTP not matching');
            Session::flash('type','error');
            Session::flash('timer','5000');
            return view('patients.consent',['patient'=>$patientid,'userid'=>$userid,'event'=>$event]);
        }

    }

    public function edit($id)
    {
        return view('patients.consent',['patient'=>$id,'userid'=>Auth::user()->id,'event'=>'editpatient']);
    }

    public function update(Request $request, $id)
    {
     $this->validate($request,[
        'name'=>'required|max:255',
        'midname'=>'max:255',
        'surname'=>'required|max:255',
        'gender'=>'required|max:6',
        'bloodgroup'=>'required|max:10',
        'phoneprimary'=>'max:15',
        'phonealternate'=>'max:15',
        'email'=>'email'
        ],[
        'name.required'=>'Full Name is required to be entered',
        'name.alpha'=>'The Name may only contain alphabets'
        ]);
        $name = trim(Str::upper($request->name));
        $midname = trim(Str::upper($request->midname));
        $surname = trim(Str::upper($request->surname));
        $namesur = $name+$surname;
        $namemidsur = $name+$midname+$surname;
        $patient = Patient::find($id);
        $patient->name =  $name;
        $patient->midname = $midname;
        $patient->surname = $surname;
        $patient->namemidsur = $namemidsur;
        $patient->namesur = $namesur;
        $patient->gender = Str::upper($request->gender);
        $patient->phoneprimary = $request->phoneprimary;
        $patient->phonealternate = $request->phonealternate;
        $patient->email = $request->email;
        $patient->address = Str::upper($request->address);
        $patient->allergies = Str::upper($request->allergies);
        $patient->bloodgroup = $request->bloodgroup;
        $patient->idproof = $request->idproof;
        $patient->save();

        Session::flash('message','Success!!');
        Session::flash('text','Patient Details updated successfully!!');
        Session::flash('type','success');
        Session::flash('timer','5000');

        return redirect()->route('patients.show',$patient->id);

    }
    public function getOTP(Request $request)
    {
 
        $otp = $this->createTOTP(6, 'sha1', 60);

        $clinicid = Session::get('clinicid');
        $patientid = $request->patientid;
        $userid = $request->userid;
        $event = $request->event;
 
        $otpnumber = new Consent;
        $otpnumber->otp = $otp->now();
        $otpnumber->clinic_id = $clinicid;
        $otpnumber->patient_id = $patientid;
        $otpnumber->user_id = $userid;
        $otpnumber->event = $event;
        $otpnumber->save();
        
       
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
        //return view('otptest',['otpgen'=>$otp->now(),'otpat'=>$otp->at(time())]);
        return response()->json($otp->now());
    }

    public function getMyPatient()
    {
        $patientid = Auth::user()->patients()->pluck('patient_id');
        $patients = Patient::whereIn('id',$patientid)->get();
        return response()->json($patients);
    }

    public function getAllPatient()
    {
        $patients = Patient::all();
        return response()->json($patients);
    }


    public function destroy($id)
    {
        //
    }

    private function createTOTP($digits, $digest, $period, $secret = 'JDDK4U6G3BJLEZ7Y', $label='', $issuer="Clinicjet")
    {
        $otp = new TOTP($label, $secret, $period, $digest, $digits);
        $otp->setIssuer($issuer);
        return $otp;
    }


}
