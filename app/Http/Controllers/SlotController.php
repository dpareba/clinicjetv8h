<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Session;
use DB;
use Auth;

use App\Patient;
use App\User;
use App\Clinic;
use App\Slot;
use App\Jobtype;


class SlotController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {   
        $clinicid = Session::get('clinicid');
        $dt = Carbon::now('Asia/Kolkata');
        $slots = Slot::where('clinic_id',$clinicid)->where('slotdate','=',$dt->toDateString())->orderBy('user_id')->get();
        //dd($slots);
        $slots = $slots->groupBy('user_id');
        //dd($slots);
        return view('slots.index',['slots'=>$slots]);
    }

    public function appointmentstoday()
    {
       $dt = Carbon::now('Asia/Kolkata');
       $clinicid = Session::get('clinicid');
       $slots = Slot::where('clinic_id',$clinicid)->where('user_id','=',Auth::user()->id)->where('slotdate','=',$dt->toDateString())->orderBy('token','asc')->get();
       $users = Slot::where('clinic_id',$clinicid)->where('user_id','=',Auth::user()->id)->where('slotdate','=',$dt->toDateString())->orderBy('token','asc')->get();
       return view('patients.today',['slots'=>$slots]);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'user'=>'required',
            'slotdate'=>'required'
            ]);
        $patientid = $request->patient_id;
        $doctor = User::find($request->user);
        $user = $doctor->patients()->where('patient_id',$patientid)->first();
        if($user==null)
        {
            return view('patients.consent',['patient'=>$patientid,'userid'=>$doctor->id,'event'=>'assigntoken']);
        }        
        $format = 'd/m/Y';
        $input = $request->slotdate;
        $date = Carbon::createFromFormat($format,$input);
        $clinicid = Session::get('clinicid');

        $patientdup = Slot::where('user_id','=',$request->user)->where('slotdate','=',$date->toDateString())->where('clinic_id','=',$clinicid)->where('patient_id','=',$request->patient_id)->get();
        if($patientdup->isEmpty())
        {
            $slot = new Slot;
            $slot->slotdate = $date;
            $slot->user_id = $request->user;
            $slot->patient_id = $request->patient_id;

            $slot->clinic_id = $clinicid;
            $slot->slotstatus_id = 1;
            $slots = Slot::where('user_id','=',$request->user)->where('slotdate','=',$date->toDateString())->where('clinic_id','=',$clinicid)->orderBy('token','DESC')->first();
            if ($slots == null) 
            {
                $slot->token = 1;
            }
            else
            {
                $slot->token = $slots->token + 1;
            }
            $slot->save();
            Session::flash('message','Success!!');
            Session::flash('text','New Token Number generated successfully!!');
            Session::flash('type','success');
            Session::flash('timer','5000');
        }
        else
        {
            Session::flash('message','Failed!!');
            Session::flash('text','Patient has already been issued token for this doctor on this day!!');
            Session::flash('type','error');
        }
        return redirect()->route('patients.index');
    }

    public function show($id)
    {
    }
    public function edit($id)
    {
    }
    public function update(Request $request, $id)
    {
    }
    public function destroy($id)
    {
    }

    public function assigntoken(Request $request)
    {
        $patient = Patient::findOrFail($request->patient_id);
        $clinicid = Session::get('clinicid');
        $jobtype = Jobtype::where('jobtype','Doctor')->first();
        $users = Clinic::find($clinicid)->users()->where('jobtype_id',$jobtype->id)->get();
        return view('slots.assigntoken')->withPatient($patient)->withUsers($users);
    }
    public function getArrivalTime(Request $request)
    {
        $slotid = $request->slotid;
        $arrivaltime = Carbon::now('Asia/Kolkata');

        $slot = Slot::find($slotid);
        $slot->arrivaltime = $arrivaltime;
        $slot->status = "Arrived";
        $slot->save();
        return response()->json($arrivaltime->toTimeString());
    }
}
