@component('mail::message')
# ClinicJet Doctor Signup

A Doctor with the following credentials signed up,

Doctor Name : {{$user->name}} <br>
Doctor email id: {{$user->email}} <br>
Doctor Phone Number: {{$user->phone}} <br>
Date/Time of account creation(yyyy-mm-dd): {{$user->created_at}} <br>
Registration Number: {{$user->doctorinfos->first()->registrationnumber}}

<small><i>If the information seems correct and authentic, please activate the user.</i></small>

@component('mail::button', ['url' => url('useractivation/'.$user->isactivatedtoken),'color'=>'green'])
Activate User
@endcomponent

Thanks,<br>
Team {{ config('app.name') }}
@endcomponent
