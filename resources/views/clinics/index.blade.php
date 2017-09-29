@extends('layouts.app')
@section('title')
| Select Clinic
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Select Clinic</div>
                <div class="panel-body">
                   @include('partials.flash', ['some' => 'data'])
                   <form data-parsley-validate class="form-horizontal" role="form" method="POST" action="{{ route('dashboard') }}">
                        {{ csrf_field() }}
                         @if($clinics->count()>0)
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            
                            <label for="name" class="col-md-4 control-label">Select Clinic</label>
                            <div class="col-md-6">
                                <select name="name" id="name" class="js-example-basic-single form-control">
                                    @foreach ($clinics as $clinic)
                                    <option value="{{$clinic->id}}" >{{$clinic->name}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-success btn-block">
                                    Next >>
                                </button>

                                 @if($jobtype=="Doctor")
                                <br>
                                <div class="text-center">
                                    Want to Add a new Clinic? <a href="{{ route('clinics.create') }}"><strong>Add Another Clinic</strong></a>
                                </div>
                                @endif
                             </div>
                        </div>
                        @else
                            <div class="text-center">
                                You are not associated with any clinic!</strong></a>
                            </div>
                        @endif                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection