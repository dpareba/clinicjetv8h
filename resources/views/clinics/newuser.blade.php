@extends('layouts.app')
@section('title')
| First Time User
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">First Time User ?</div>
                <div class="panel-body">
                   <div class="row">
                         <div class="col-md-12">
                            <a href="{{route('clinics.create')}}" class="btn btn-success btn-block">Create a New Clinic</a>
                        </div>
                </div>                  
            </div>
        </div>
    </div>
</div>
</div>
@endsection
