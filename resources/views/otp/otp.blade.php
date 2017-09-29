@extends('layouts.app')
@section('title')
    | Login
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">OTP Testing</div>
                <div class="panel-body">
                    @include('partials.flash', ['some' => 'data'])
                    <form data-parsley-validate class="form-horizontal" role="form" method="POST" action="{{ url('/otp') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('mobil') ? ' has-error' : '' }}">
                            <label for="mobil" class="col-md-4 control-label">Mobile No</label>

                            <div class="col-md-6">
                                <input id="mobil" type="mobil" class="form-control" name="mobil" value="{{ old('mobil') }}" event.preventDefault(); required data-parsley-required-message="*Your Mobile No is required!" autofocus placeholder="Enter Mobile Number">

                                @if ($errors->has('moil'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobil') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

{{--                         <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="otp" class="col-md-4 control-label">OTP</label>

                            <div class="col-md-6">
                                <input id="otp" type="text" class="form-control" name="otp" required data-parsley-required-message="*Please enter the OTP!" placeholder="Enter OTP">

                                @if ($errors->has('otp'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('otp') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    OTP
                                </button>
                           </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script type="text/javascript">

    </script>
@endsection
