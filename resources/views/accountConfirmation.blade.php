@component('mail::message')
# Welcome to ClinicJet.

Welcome to the ClinicJet family. Kindly verify your email-id.

@component('mail::button', ['url' => url('register/confirm/'.$user->token),'color'=>'green'])
VERIFY EMAIL
@endcomponent

Thanks,<br>
Team {{ config('app.name') }}
@endcomponent
