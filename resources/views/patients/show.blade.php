@extends('layouts.master')
@section('title')
| View Patient
@stop
@section('pageheading')
View Patient Details		
@stop
@section('subpageheading')
View/Edit Patients Details
@stop
@section('content')
  <div class="row">
    <!-- /.col -->
    <div class="col-md-12">
      <div class="row">
        @can('nonmedical',Auth::user())
          <div class="col-md-4">
              <form action="{{route('slots.assigntoken')}}" method="POST">
                {{csrf_field()}}
                 <input type="hidden" name="patient_id" value="{{$patient->id}}">
                 <button type="submit" class="btn btn-success btn-block">Assign Token</button>
              </form>
           
          </div>
          <div class="col-md-4">
            <a href="{{route('patients.edit',$patient->id)}}" class="btn btn-warning btn-block">Edit Patient Details</a>
          </div>
          <div class="col-md-4">
            <a href="{{route('patients.index')}}" class="btn btn-block btn-danger">Cancel</a>
          </div>
      @else
          <div class="col-md-3">
            <form action="{{route('showVisits')}}" method="POST">
              {{csrf_field()}}
              <input type="hidden" name="patient_id" value="{{$patient->id}}">
              <button type="submit" class="btn btn-primary btn-block">View Patient Visits</button>
            </form>
          </div>
          <div class="col-md-3">
            <a href="{{URL::route('patients.createconsult',['id'=>$patient->id,'repeatvisitid'=>'0','editconsult'=>'false'])}}" class="btn btn-success btn-block">New Patient Consultation</a>
          </div>
          <div class="col-md-3">
            <a href="{{route('patients.edit',$patient->id)}}" class="btn btn-warning btn-block">Edit Patient Details</a>
          </div>
          <div class="col-md-3">
            <a href="{{route('patients.index')}}" class="btn btn-block btn-danger">Cancel</a>
          </div>
        @endcan      
      </div>
      <br>
      <!-- Widget: user widget style 1 -->
      <div class="box box-widget widget-user">
          <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-primary">
          <h3 class="widget-user-username">{{$patient->name}} {{$patient->midname}} {{$patient->surname}}</h3>
          <h5 class="widget-user-desc">Registered:{{date('M j, Y',strtotime($patient->created_at))}}</h5>
        </div>
        <div class="widget-user-image">
          <img class="img-circle" src="{{asset('avatar/docs/default.jpg')}}" alt="User Avatar">
        </div>
        <div class="box-footer no-padding">
          <ul class="nav nav-stacked">
            <li><a href="#"><b>Patient Details</b><span class="pull-right badge bg-default"></span></a></li>
            <li><a href="#">Patient Code <span class="pull-right badge bg-default">{{$patient->patcode}}</span></a></li>
            @if ($patient->isapproxage)
              <li><a href="#">Approximate Patient Age<span class="pull-right badge bg-default">{{$patient->approxage}} Years</span></a></li>
            @else
              @if ($patient->dob == "1900-01-01 00:00:00")
                <li><a href="#">Patient Age<span class="pull-right badge bg-maroon">Date of Birth Not Provided</span></a></li>
              @else
                <li><a href="#">Patient Age<span class="pull-right badge bg-default">{{$patient->dob->diff(\Carbon\Carbon::now())->format('%y Years, %m Months and %d Days')}}</span></a></li>
              @endif
            @endif
              <li><a href="#">Gender <span class="pull-right badge bg-default">{{$patient->gender}}</span></a></li>
              <li><a href="#">Blood Group <span class="pull-right badge bg-default">{{$patient->bloodgroup}}</span></a></li>
              <li><a href="#">Primary Phone <span class="pull-right badge bg-default">{{$patient->phoneprimary}}</span></a></li>
              <li><a href="#">Alternate Phone <span class="pull-right badge bg-default">{{$patient->phonealternate}}</span></a></li>
              <li><a href="#">E-Mail <span class="pull-right badge bg-default">{{$patient->email}}</span></a></li>
          </ul>
        </div>
        <div class="box-footer">
          <div class="row">
            <div class="col-sm-12 border-right">
              <div class="description-block">
                <h5 class="description-header">Postal Address</h5>
                <span class="description-text">{{$patient->address}}</span>
              </div>
            </div>
          </div>
          <div>
            <hr>
          </div>
          <div class="row">
            <div class="col-sm-12 border-right">
              <div class="description-block">
                <h5 class="description-header">Known Allergies</h5>
                <span class="description-text">{{$patient->allergies}}</span>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
@stop