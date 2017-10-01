<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Str;
use Auth;
use Session;
use App\State;
use App\User;
use App\Clinic;
use App\Role;
use App\Jobtype;
use App\Visit;


class ClinicController extends Controller
{
 

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function check()
    {
        if (Auth::user()->isActivated) {
            $jobtype = Auth::user()->jobtype->jobtype;
        if (Auth::user()->clinics()->first() == null)
         {
            if($jobtype=='Doctor')
            {
                return view('clinics.newuser');
            }
        }
        $clinics = Auth::user()->clinics()->get();
        return view('clinics.index',['clinics'=>$clinics,'jobtype'=>$jobtype]);
        }else{
            return view('errors.userverification');
        }      
       
    }

    public function create()
    {
        $states = State::all();
        return view('clinics.create',['states'=>$states]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|max:255|unique:clinics,name',
            'clinictype'=>'required|max:255',
            'address'=>'required|unique:clinics,address',
            'state'=>'required|max:50',
            'city'=>'required|max:255',
            'pin'=>'required|integer|digits:6',
            'phoneprimary'=>'required|digits:10|unique:clinics,phoneprimary|unique:clinics,phonealternate',
            'phonealternate'=>'digits:10|unique:clinics,phonealternate|unique:clinics,phoneprimary',
            'email'=>'email|unique:clinics,email'
            ],[
            'name.required'=>'Clinic Name is required',
            'name.unique'=>'A Clinic by this name is already registered.',
            'clinictype.required'=>'Type of Clinic is required.',
            'address.required'=>'Clinic Address is required',
            'address.unique'=>'A Clinic with this address is already Registered',
            'state.required'=>'State field cannot be left blank',
            'city.required'=>'City field cannot be left blank',
            'pin.required'=>'Pincode cannot be blank',
            'pin.integer'=>'Invalid Pincode Format',
            'pin.digits'=>'Invalid Pincode Format',
            'phoneprimary.required'=>'Primary Phone Number of clinic is required',
            'phoneprimary.digits'=>'Phone Number field must contain 10 digits',
            'phoneprimary.unique'=>'A Clinic with this Phone Number is already Registered',
            'phonealternate.digits'=>'Phone Number field must contain 10 digits',
            'phonealternate.unique'=>'A Clinic with this Phone Number is already Registered',
            'email.unique'=>'A Clinic with this email is already Registered'
            ]);

        $user = User::find(Auth::user()->id);
        $clinic = new Clinic;
        $clinic->name = Str::upper($request->name);
        $clinic->address = Str::upper($request->address);
        $clinic->clinictype = Str::upper($request->clinictype);
        $clinic->state = Str::upper($request->state);
        $clinic->city = Str::upper($request->city);
        $clinic->pin = $request->pin;
        $clinic->phoneprimary = $request->phoneprimary;
        $clinic->phoneprimarylandarea = $request->phoneprimarylandarea;
        $clinic->phoneprimarylandtel = $request->phoneprimarylandtel;
        $clinic->phonealternate = $request->phonealternate;
        $clinic->email = $request->email;
        $clinic->website = $request->website;
        $clinic->cliniccode = rand(1000,9999);
        $clinic->save();
        $roleid = Role::where('role','SuperAdmin')->first();
        $user->roles()->attach($roleid->id,['clinic_id'=>$clinic->id,'role_id'=>$roleid->id]);
        Session::flash('message','Success!!');
        Session::flash('text','New Clinic Registered successfully!!');
        Session::flash('type','success');

        return redirect()->route('check');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
