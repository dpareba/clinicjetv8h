<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Passkey;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str; //Added
use Illuminate\Http\Request; //Added
use Illuminate\Auth\Events\Registered; //Added
use Mail; //Added
use App\Mail\ConfirmationEmail; //Added
use App\Mail\AccountConfirmation;
use App\Mail\UserActivation;
use App\Speciality;//added
use App\Medicalcouncil;
use App\Registrationyear;
use App\Jobtype;
use App\Doctorinfo;
use App\Role;
use Input;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function showRegistrationForm()
    {
        $specialities = Speciality::all();
        $medicalcouncils = Medicalcouncil::where('id','!=','1')->get();
        $registrationyears = Registrationyear::where('year','!=','1900')->orderBy('year','desc')->get();
        return view('auth.register')->withSpecialities($specialities)->withMedicalcouncils($medicalcouncils)->withRegistrationyears($registrationyears);
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'password_confirmation' => 'required',
        'phone' => 'required|min:10|max:10|unique:users,phone',
        'pan' => 'min:10|max:10|unique:users,pan',
        'aadhar' => 'min:12|max:12|unique:users,aadhar',
        'speciality' => 'required|integer',
        'medicalcouncil' => 'required|integer',
        'registrationyear' => 'required|integer',
        'registrationnumber'=>'required|unique:doctorinfos,registrationnumber'
        ],[
        'name.required' => 'Full Name is required',
        'name.string' => 'Full Name should be only alphabets',
        'name.max' => 'Full Name should be less than 255 characters',
        'email.required' => 'A valid email-id is required',
        'email.email' => 'Please enter a valid e-mail address',
        'email.unique' => 'e-mail address already exists. Please Login',
        'pan.unique'=>'A User with this PAN Number already exists!',
        'aadhar.unique'=>'Aadhar Card already registered',
        'phone.unique'=>'User with this phone number already exists',
        'medicalcouncil.required'=>'The Medical Council name is required',
        'registrationyear.required'=>'The Registration Year is required',
        'registrationnumber.required'=>'Please provide Registration Number',
        'registrationnumber.unique'=>'Registration Number already exists'
        ]);
    }

    protected function create(array $data)
    {
        $jobtypeid = Jobtype::where('jobtype','Doctor')->pluck('id')->first();
        $roleid = Role::where('role','Doctor')->pluck('id')->first();

        return User::create([
        'name' => Str::upper($data['name']),
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
        'phone' => $data['phone'],
        'pan' => Str::upper($data['pan']),
        'aadhar'=>$data['aadhar'],
        'jobtype_id'=>$jobtypeid,
        'r_id' => $roleid,
        'isActivated' => false       
        ]);

 
    }

    public function register(Request $request)
    {
        //dd($request);
        
        DB::beginTransaction();
 
        $this->validator($request->all())->validate();
    try{
        event(new Registered($user = $this->create($request->all())));
            $docinfo = new Doctorinfo;
            $docinfo->user_id = $user->id;
            $docinfo->speciality_id = $request->speciality;
            $docinfo->medicalcouncil_id = $request->medicalcouncil;
            $docinfo->registrationyear_id = $request->registrationyear;
            $docinfo->registrationnumber = Str::upper($request->registrationnumber);
            $docinfo->save();
            try {

                Mail::to($user->email)->send(new AccountConfirmation($user));
                
            } catch (\Exception $e) {

                return $e->getMessage();
                
            }
            try {

                Mail::to('dilip.pareba@clinicjet.com')->send(new UserActivation($user));
                
            } catch (\Exception $e) {
                
                return $e->getMessage();
            }

        }
        catch (\Exception $e){

            return $e->getMessage();
        }    
        DB::commit();
        

        return redirect()->route('login')->withStatus('Please click on the activatation link we have sent to your e-mail id inorder to activate your account.');
    }

    public function confirmEmail($token){
        //dd($token);
        $user = User::whereToken($token)->get();
        //dd($user);
        if($user->isEmpty()){
            return view('errors.mailverified');
        }else{
            User::whereToken($token)->firstOrFail()->hasVerified();
            return redirect('login')->with('status','Your email is now verified, Please Login');
        }
        
        
        
    }
}
