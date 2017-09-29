@extends('layouts.app')
@section('title')
    | Login
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Joining Code</div>
                <div class="panel-body">
                    @include('partials.flash', ['some' => 'data'])
                    <form data-parsley-validate class="form-horizontal" role="form" method="POST" action="{{ url('/joincode') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('joincode') ? ' has-error' : '' }}">
                            <label for="joincode" class="col-md-4 control-label">Joining Code</label>
                            <div class="col-md-6">
                                <input id="joincode" type="joincode" class="form-control" name="joincode" value="{{ old('joincode') }}" event.preventDefault(); required data-parsley-required-message="*Your Joining Code is required!" autofocus placeholder="Enter Joining Code">
                                @if ($errors->has('joincode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('joincode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    submit
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
        $(document).ready(function(){
            $('#joincode').focus();
        });
    </script>
@endsection
