@extends('layouts.app')
@section('title')
| Register
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">New Receptionist Registration</div>
                <div class="panel-body">
                    @include('partials.flash', ['some' => 'data'])
                    <form data-parsley-validate class="form-horizontal" role="form" method="POST" action="{{ url('/newrecep') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>
                            <div class="col-md-6">
                                 <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" event.preventDefault(); required="" autofocus style="text-transform: uppercase;" data-parsley-required-message="*Name is required" placeholder="Full Name (Do Not Suffix Dr.)"> 
                                 @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required="" data-parsley-required-message="*A valid Email is required to register" placeholder="Email Address">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Contact Number</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" required=""  data-parsley-pattern="(7|8|9)\d{9}" class="form-control" name="phone" value="{{ old('phone') }}" data-parsley-required-message="*A valid phone is required to register" data-parsley-pattern-message="*Invalid Mobile Number" placeholder="Mobile Number" maxlength="10">
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('pan') ? ' has-error' : '' }}">
                            <label for="pan" class="col-md-4 control-label">PAN Number</label>
                            <div class="col-md-6">
                                <input id="pan" type="text"   data-parsley-pattern="/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/" style="text-transform: uppercase;" class="form-control" name="pan" value="{{ old('pan') }}" maxlength="10" data-parsley-pattern-message="*Invalid PAN Number" placeholder="PAN Number">
                                @if ($errors->has('pan'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pan') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('aadhar') ? ' has-error' : '' }}">
                            <label for="aadhar" class="col-md-4 control-label">Aadhar Number</label>
                            <div class="col-md-6">
                                <input id="aadhar" type="text"   data-parsley-pattern="/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/" style="text-transform: uppercase;" class="form-control" name="aadhar" value="{{ old('aadhar') }}" maxlength="12" data-parsley-pattern-message="*Invalid Aadhar Number" placeholder="Aadhar Number">
                                @if ($errors->has('aadhar'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('aadhar') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required="" minlength="6" data-parsley-required-message="*Please set your password" placeholder="Password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>  
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required="" data-parsley-equalto="#password" data-parsley-required-message="*Please confirm your password!" data-parsley-equalto-message="*This should match the password provided!" placeholder="Password Again">
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <input type="hidden" value="{{$jobtypeid}}" name="jobtypeid" id="jobtypeid"/>
                                <input type="hidden" value="{{$clinicid}}" name="clinicid" id="clinicid"/> 
                                <input type="hidden" value="{{$roleid}}" name="roleid" id="roleid"/>                           
                                <button type="submit" class="btn btn-primary">
                                    Register
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

