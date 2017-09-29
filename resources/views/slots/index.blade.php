@extends('layouts.master')
@section('title')
| Today's Appointments
@stop
@section('pageheading')
Today's Tokens		
@stop
@section('subpageheading')
View/Search Patients with Token Numbers
@stop
{{-- @section('refresh')
  <meta http-equiv="Refresh" content="300">
@endsection --}}
@section('content')
<div class="row">
	<div class="col-md-12 col-xs-12">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
			<?php $isactive = 1; ?>
			@foreach ($slots as $slot)
				<?php $count = 1 ?>
				@foreach ($slot as $s)
					@if ($count == 1)
						<li class="{{$isactive==1?'active':''}}"><a href="#{{$s->user_id}}" data-toggle="tab">DR. {{$s->user->name}}</a></li>
					@endif
					<?php $count+=1; ?>
				@endforeach
				<?php $isactive+=1; ?>
			@endforeach
			</ul>
			<div class="tab-content">
				<?php $isactive = 1;?>
				@foreach ($slots as $slot)
				<?php $count = 1 ?>
					@foreach ($slot as $s)
						@if ($count == 1)
							<div class="{{$isactive==1?'active':''}} tab-pane" id="{{$s->user_id}}">
				            	<div class="box box-gray">
              						<div class="box-header with-border">
              						<h3 class="box-title">Today's Appointments -- Dr. {{$s->user->name}}</h3>
              							<div class="box-body">
              								<div class="table-responsive">
              									<table class="table no-margin text-center">
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
							@endif
            											<tr>
												            <td><span class="label label-success">{{$s->token}}</span></td>
												            <td>{{$s->patient->name}} {{$s->patient->midname}} {{$s->patient->surname}}</td>
															@if($s->arrivaltime==null)
												            <td t_alink="{{$s->id}}"><a href="#" onClick="getAToken('{{$s->id}}')"> Reporting Time </a></td>
												            @else
												            <td >{{substr($s->arrivaltime,-8)}}</td>
												            @endif
												            <td>{{substr($s->visitstart,-8)}}</td>
												            <td>{{substr($s->patient->visitend,-8)}}</td>
												            <td></td>
												            <td>{{$s->status}}</td>
												            <td>{{$s->patient->patcode}}</td>
            											</tr>
														<?php $count+=1; ?>
					@endforeach
					<?php $isactive+=1; ?>
            										</tbody>
            									</table>{{-- .table --}}
            								</div>{{-- .table-responsive --}}
            							</div>{{-- .box-body --}}
            						</div>{{-- .box-header with-border --}}
            					</div>{{-- .box box-info --}}
							</div>{{-- .tab-pane --}}
					@endforeach
			</div>
		</div>
	</div>
</div>
@stop
<script type="text/javascript">
    var token = '{{Session::token()}}';  
    var urlgetArrivalTime = "{{URL::to('/getArrivalTime')}}";  
</script>
