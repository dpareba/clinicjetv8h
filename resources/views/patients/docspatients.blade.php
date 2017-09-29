@extends('layouts.master')
@section('title')
| My Patients
@stop
@section('pageheading')
My Patients		
@stop
@section('subpageheading')
View/Search for My Patients 
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
          <tbody id="getMyPatient" >
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
    var urlgetMyPatient = "{{URL::to('/getMyPatient')}}";  
    var url = '{{ route("patients.show", ":id") }}';
</script>
<script src="{{asset('src/js/getMyPatient.js')}}"></script>
@stop