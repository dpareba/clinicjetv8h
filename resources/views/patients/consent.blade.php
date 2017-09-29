@extends('layouts.master')
@section('title')
	| Patient Conesnt
@stop
@section('pageheading')
	SMS consent 		
@stop
@section('subpageheading')
	Add patient to doctor
@stop
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Send consent OTP</div>
          <div class="panel-body">
            @include('partials.flash', ['some' => 'data'])
            <div id="jid" class="form-group{{ $errors->has('otp') ? ' has-error' : '' }}">
              <div class="col-md-6">
                <div class="form-group">
                  <div class="col-md-8 col-md-offset-4">
                    <button id="otp" type="" class="btn btn-primary">Generate OTP</button>
                  </div>
                </div>
                <form action="{{route('consent')}}" method="POST">
                <div class="col-md-8 col-md-offset-4">
                  <strong>Enter the consent OTP</strong>
                </div>
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('otp') ? ' has-error' : '' }}">
                  <label for="otp" class="col-md-4 control-label">Enter OTP</label>
                  <div class="col-md-6">
                    <input id="consent"  type="text" class="form-control" name="consent" value="">
                    @if ($errors->has('consent'))
                        <span class="help-block">
                            <strong>{{ $errors->first('consent') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>
                <input type="hidden" id="patientid" name="patientid" value="{{$patient}}">
                <input type="hidden" id="userid" name="userid" value="{{$userid}}">
                <input type="hidden" id="event" name="event" value="{{$event}}">
                <div class="form-group">
                  <div class="col-md-8 col-md-offset-4">
                    <button type="submit " class="btn btn-primary">Submit</button>
                  </div>
                </div>
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  
@stop
@section('js')
    <script type="text/javascript">
        var token = '{{Session::token()}}';  
        var urlotp = "{{URL::to('/getOTP')}}";  
    </script>
@endsection