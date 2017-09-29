<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str; //Added
use Illuminate\Auth\Events\Registered; //Added
use Illuminate\Support\Facades\DB;

use Auth;
use App\User;
use App\Clinic;
use App\Member;
use App\Jobtype;
use App\Role;
use App\Speciality;
use App\Medicalcouncil;
use App\Registrationyear;
use App\Doctorinfo;
use App\Clinicroleuser;
use Session;

class MemberController extends Controller
{

  public function index()
  {
    return view('member.join');
  }

  public function getCodeNumber(Request $request)
  {
    $clinicid = Session::get('clinicid');
    $jobtypeid = $request->jobtype;
    $findnumber = Member::where('clinic_id','=',$clinicid)->where('jobtype_id','=',$jobtypeid)->get()->pluck('joincode');

    if($findnumber->first()==null)
    {
      $findnumber = rand(0,1000);   
      $newmember = new Member;
      $newmember->joincode = $findnumber;
      $newmember->clinic_id = $clinicid;
      $newmember->jobtype_id = $jobtypeid;
      $newmember->save();
    }
    return response()->json($findnumber);
  }
    
  public function getMember(Request $request)
  {
        $email = $request['email'];
        if($email!=Auth::user()->email)
          {
            $user = User::where('email',$email)->get()->first();
            //dd($user);
            return response()->json($user);
          }
          return response()->json(['email'=>'Not Allowed!']);
  }

  public function joincode(Request $request)
  {
    $this->validate($request,['joincode' => 'required|max:15']);
    $newjoincode = $request['joincode'];
    $joincode = Member::where('joincode',$newjoincode)->get()->first();

    if($joincode==null)
    {
      $request->session()->flash('message','Code not matching!');
      return view('member.join');
    }else
    {
      $clinicid = $joincode->clinic_id;
      $jobtypeid = $joincode->jobtype_id;
      $jobtype = Jobtype::where('id',$jobtypeid)->pluck('jobtype')->first();

      if($jobtype=='Doctor' || $jobtype=='JrDoctor')
      {
        $specialities = Speciality::all();
        $medicalcouncils = Medicalcouncil::where('id','!=','1')->get();
        $registrationyears = Registrationyear::where('year','!=','1900')->orderBy('year','desc')->get();
        $joincode->delete();
        $roleid = Role::where('role','Doctor')->pluck('id')->first();
        return view('member.newdoctor',['roleid'=>$roleid,'jobtypeid'=>$jobtypeid,'clinicid'=>$clinicid,'specialities'=>$specialities,'medicalcouncils'=>$medicalcouncils,'registrationyears'=>$registrationyears]);
      }else
      {
        $joincode->delete();
        $roleid = Role::where('role','View')->pluck('id')->first();
  
        return view('member.newreceptionist',['roleid'=>$roleid,'jobtypeid'=>$jobtypeid,'clinicid'=>$clinicid]);
      }
    }
  }

  public function managemember()
  {

    $clinicid = Session::get('clinicid');

    $users = Clinic::find($clinicid)->users()->get();
    return view('member.managemember',['users'=>$users]);
  }

  public function attachmember(Request $request)
  {
      $userid = $request['userid'];
      $user = User::find($userid);
      $roleid = $request['roleid'];
      $clinicid = Session::get('clinicid');
      $user->roles()->attach($roleid,['clinic_id'=>$clinicid,'role_id'=>$roleid]);      
      return redirect()->route('managemember');           
  }  

  public function delete(Request $request)
  {
      $userid = $request['userid'];
      $clinicid = Session::get('clinicid');
      $user = User::find($userid);
      $roleid = $user->roles()->wherePivot('clinic_id',$clinicid)->get();
      $user->roles()->wherePivot('clinic_id',$clinicid)->detach($roleid); 
      return redirect()->route('managemember');
  }  
  public function createnew()
  {
      $jobtypes = Jobtype::whereNotIn('jobtype',['System','Accountant','Analyst'])->get();
      return view('member.create',['jobtypes'=>$jobtypes]);
  }

  public function newdoctor(Request $request)
  {
      $this->validator($request->all())->validate();
      event(new Registered($user = $this->create($request->all())));
      $docinfo = new Doctorinfo;
      $docinfo->user_id = $user->id;
      $docinfo->speciality_id = $request->speciality;
      $docinfo->medicalcouncil_id = $request->medicalcouncil;
      $docinfo->registrationyear_id = $request->registrationyear;
      $docinfo->registrationnumber = Str::upper($request->registrationnumber);
      $docinfo->save();

      $roleid = Role::where('role','Doctor')->pluck('id')->first();

      $user->roles()->attach($roleid,['clinic_id'=>$request->clinicid,'role_id'=>$roleid]);
      
      return redirect()->route('login');
  }

 protected function validatorRecep(array $data){

      return Validator::make($data, [
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:6|confirmed',
      'phone' => 'required|min:10|max:10|unique:users,phone'
      ],[
      'phone.unique'=>'User with this phone number already exists',
      ]);
  }

  public function newrecep(Request $request){

        $this->validatorRecep($request->all())->validate();
        event(new Registered($user = $this->createRecep($request->all())));
        $roleid = Role::where('role','View')->pluck('id')->first();

        $user->roles()->attach($roleid,['clinic_id'=>$request->clinicid,'role_id'=>$roleid]);        

        return redirect()->route('login');

  }

  protected function createRecep(array $data)
  {
      return User::create([
      'name' => Str::upper($data['name']),
      'email' => $data['email'],
      'password' => bcrypt($data['password']),
      'phone' => $data['phone'],
      'pan' => Str::upper($data['pan']),
      'aadhar'=>$data['aadhar'],
      'jobtype_id'=>$data['jobtypeid'],
      'r_id'=>$data['roleid'],
      ]);
  }    

  protected function validator(array $data)
  {
      return Validator::make($data, [
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:6|confirmed',
      'phone' => 'required|min:10|max:10|unique:users,phone',
      'pan' => 'required|min:10|max:10|unique:users,pan',
      'speciality' => 'required',
      'medicalcouncil' => 'required',
      'registrationyear' => 'required',
      'registrationnumber'=>'required'
      ],[
      'pan.required' => 'PAN Number is required',
      'pan.unique'=>'A User with this PAN Number already exists!',
      'phone.unique'=>'User with this phone number already exists',
      'medicalcouncil.required'=>'The Medical Council name is required',
      'registrationyear.required'=>'The Registration Year is required',
      'registrationnumber.required'=>'Please provide Registration Number'
      ]);
  }

  protected function create(array $data)
  {
      return User::create([
      'name' => Str::upper($data['name']),
      'email' => $data['email'],
      'password' => bcrypt($data['password']),
      'phone' => $data['phone'],
      'pan' => Str::upper($data['pan']),
      'aadhar'=>$data['aadhar'],
      'jobtype_id'=>$data['jobtypeid'],
      'r_id'=>$data['roleid'],
      ]);
  } 


}