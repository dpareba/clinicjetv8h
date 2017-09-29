@extends('layouts.master')
@section('title')
	| All Patients
@stop
@section('pageheading')
	All Patients		
@stop
@section('subpageheading')
	View/Search for Patients registered with Clinic
@stop
@section('content')
	{{-- {{$patients}} --}}
	<div class="row">
        <div class="col-xs-12">
 			<div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Registered Patients</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Full Name</th>
                  <th>Primary Phone</th>
                  <th>Alternate Phone</th>
                  <th>Email</th>
                  <th>Patient Code</th>
                   <th>Registered On</th>
                </tr>
                </thead>
                <tbody id="getAllPatient">
                 
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
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
<script type="text/javascript">
    var token = '{{Session::token()}}';  
    var urlgetAllPatient = "{{URL::to('/getAllPatient')}}";  
    var url = '{{ route("patients.show", ":id") }}';
</script>
<script src="{{asset('src/js/getAllPatient.js')}}"></script>
@stop