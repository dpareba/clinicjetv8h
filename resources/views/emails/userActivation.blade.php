@component('mail::message')
# ClinicJet Doctor Signup

A Doctor with the following credentials signed up,

<b>Date/Time of account creation(yyyy-mm-dd):</b> {{$user->created_at}} <br>
<b>Doctor Name:</b> DR. {{$user->name}} <br>
<b>Doctor email id:</b> {{$user->email}} <br>
Doctor Phone Number: {{$user->phone}} <br>
Doctor Speciality: {{$user->doctorinfos->first()->speciality->speciality}} <br>
Medical Council: {{$user->doctorinfos->first()->medicalcouncil->name}} <br>
Registration Number: {{$user->doctorinfos->first()->registrationnumber}} <br>
Registration Year: {{$user->doctorinfos->first()->registrationyear->year}}

<div>If the above information is correct and authentic, please activate the user.</div><br>
<small><i style="color:red;">Please verify the information before activating the user.</i></small>

@component('mail::button', ['url' => url('useractivation/'.$user->isactivatedtoken),'color'=>'green'])
Activate User
@endcomponent

Thanks,<br>
Team {{ config('app.name') }}
@endcomponent
