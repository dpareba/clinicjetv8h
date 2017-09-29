@extends('layouts.master')
@section('title')
	| Today's Appointments
@stop
@section('pageheading')
	Today's Appointments		
@stop
@section('subpageheading')
	View/Search for Patients with appointments today
@stop
{{-- @section('refresh')
  <meta http-equiv="Refresh" content="3">
@endsection --}}
@section('content')
	<div class="row">
    <div class="col-xs-12">
 			<div class="box box-primary">
        <div class="box-header"><h3 class="box-title">Registered Patients</h3></div>
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped text-center">
              <thead>
                <tr>
                  <th>Token Number</th>
                  <th>Patient Name</th>
                  <th>Reporting Time</th>
                  <th>Visit Start</th>
                  <th>Visit End</th>
                  <th>Time Taken</th>
                  <th>Status</th>
                  <th>Patient</th>
                </tr>
              </thead>
              <tbody>
                @if($slots)
                  @foreach ($slots as $slot)
                    <tr>
                        <td><span class="label label-success">{{$slot->token}}</span></td>
                        <td><a href="{{route('patients.show',$slot->patient->id)}}">{{$slot->patient->name}} {{$slot->patient->midname}} {{$slot->patient->surname}}</a></td>
                        <td >{{substr($slot->arrivaltime,-8)}}</td>
                        <td>{{substr($slot->patient->visitstart,-8)}}</td>
                        <td>{{substr($slot->patient->visitend,-8)}}</td>
                        <td></td>
                        <td>{{$slot->status}}</td>
                        <td>{{$slot->patient->patcode}}</td>
                    </tr>
                  @endforeach
                @endif
              </tbody>
              <tfoot>
                <tr>
                  <th>Full Name</th>
                  <th>Primary Phone</th>
                  <th>Alternate Phone</th>
                  <th>Email</th>
                  <th>Patient Code</th>
                  <th>Registered On</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
@stop