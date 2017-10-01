@component('mail::message')
# ClinicJet Doctor Signup

A Doctor with the following credentials have signed up,

Doctor Name : {{$user->name}} <br>
Doctor email id: {{$user->email}} <br>
Doctor Phone Number: {{$user->phone}} <br>
Date/Time of account creation(yyyy-mm-dd): {{$user->created_at}} <br>

@component('mail::button', ['url' => 'http://www.clinicjet.com','color'=>'green'])
Confirm Doctor
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
