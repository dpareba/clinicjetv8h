@extends('layouts.master')
@section('title')
| Create New Consult
@stop
@section('pageheading')
Create New Consult		
@stop
@section('subpageheading')
Add Consultation for Patient Visit
@stop
@section('stylesheets')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

 {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.css"> --}}
 @stop
@section('content')
<style>
	#report-images{
		width: 10px;
		height: 10px;
		border: 1px solid black;
		margin-bottom: 2px;
	}

	.medcolor{
		color: black;
	}
</style>

	<div class="row">
		<div class="col-md-12">
			<div class="box box-widget widget-user-2">
				<div class="widget-user-header bg-primary">
					<div class="widget-user-image">
						<img class="img-circle" src="/avatar/docs/default.jpg" alt="User Avatar">
					</div>
					<h3 class="widget-user-username">{{$patient->name}} {{$patient->midname}} {{$patient->surname}}</h3>
					<h5 class="widget-user-desc"><span class="badge bg-gray">Patient Record Created On: {{$patient->created_at->format('D, d F Y')}}</span>  | 
						@if ($patient->isapproxage)
							<span class="badge bg-gray">Approximate Patient Age: {{$patient->approxage}} Years</span>
						@else
							@if ($patient->dob != "1900-01-01 00:00:00")
								<span class="badge bg-gray">Patient Age: {{$patient->dob->diff(Carbon::now())->format('%y Years, %m Months and %d Days')}}</span>
							@else
								<span class="badge bg-maroon">Patient Age: Date of Birth Not Provided</span>
							@endif 
						@endif
	 				</h5>
				</div>
			</div>
			<h2 class="page-header"><small class="text-red">Known Allergies : {{$patient->allergies}}</small></h2>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs bg-gray">
					@if ($editconsult=="false")
						<li class="active"><a href="#new" data-toggle="tab">New</a></li>
					@else
						<li class="active"><a href="#new" data-toggle="tab">Edit</a></li>
					@endif
					<?php $countheader=1; ?>
					@foreach ($patient->visits as $visit)
						<li><a href="#new{{$countheader}}" data-toggle="tab">{{$visit->created_at->timezone('Asia/Kolkata')->toDayDateTimeString()}}</a></li>
						<?php $countheader+=1;?>
					@endforeach
						<li class="pull-right"><a href="#healthcharts" data-toggle="tab">View Health Charts</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="new">
						<div class="row">
							<div class="col-md-12">
								<div class="box box-solid box-primary">
									<div class="box-header with-border">
										<h3 class="box-title">New Consultation</h3>
										<div class="box-tools pull-right">
											<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
										</div>
									</div>
									@if ($editconsult=="false")
										<form data-parsley-validate id="consult" action="{{route('visits.storelocal')}}" method="POST" data-toggle="validator">
									@else	
										<form data-parsley-validate id="consult" action="{{route('visits.update',$repeatid)}}" method="POST" data-toggle="validator">
											<input type="hidden" name="_method" value="PUT">
									@endif
									<div class="box-body">
										{{csrf_field()}}
										<input type="hidden" name="patient_id" value="{{$patient->id}}">
										<input type="hidden" id="repeatid" value="{{$repeatid}}">
	{{--Row1--}}						<div class="row">
											<div class="col-md-6 col-xs-12">
												<div class="form-group {{ $errors->has('chiefcomplaints')?'has-error':''}}">
													<label class="control-label" for="chiefcomplaints">Chief Complaints</label>
													<a type="button" id="addcc" href="" style="color: gray;" data-toggle="modal" data-target="#ccModal"><i class="fa fa-plus"></i></a>
													<textarea event.preventDefault(); style="resize:none;text-transform: uppercase;" autofocus=""  name="chiefcomplaints" id="chiefcomplaints" class="form-control" cols="30" rows="3"  placeholder="Chief Complaints" required="">{{old('chiefcomplaints')}}</textarea>
													<span class="help-block">{{$errors->first('chiefcomplaints')}}</span>
												</div>
											</div>
											<div class="col-md-6 col-xs-12">
												<div class="form-group {{ $errors->has('patienthistory')?'has-error':''}}">
													<label class="control-label" for="patienthistory">History of Presenting Complaints</label>
													<textarea  event.preventDefault(); style="text-transform: uppercase;resize: none;" name="patienthistory" id="patienthistory" class="form-control" cols="30" rows="3" style="resize: none;" placeholder="Patient History" required="">{{old('patienthistory')}}</textarea>
													<span class="help-block">{{$errors->first('patienthistory')}}</span>
												</div>
											</div>
										</div>
	{{--Row2--}}						<div class="row">
											<div class="col-md-6 col-xs-12">
												<div class="form-group {{ $errors->has('examinationfindings')?'has-error':''}}">
													<label class="control-label" for="examinationfindings">Examination Findings</label>
													<div class="pull-right box-tools">
														<select class="input-xs"  style="height: 25px; line-height: 25px;" name="" id="templatename">
															<option value="None"  selected="">Select Template</option>
															@foreach ($templates as $t)
																<option value="{{$t->templatename}}">{{$t->templatename}}</option>
															@endforeach
														</select>
														<a href="" id="addef" data-toggle="modal" data-target="#efModal" class="btn btn-default btn-xs" type="button" >Add Template</a>
													</div>
													<textarea event.preventDefault(); style="text-transform: uppercase;resize: none;"  name="examinationfindings" id="examinationfindings" class="form-control" cols="30" rows="3" style="resize: none;" placeholder="Examination Findings" required="">{{old('examinationfindings')}}</textarea>
													<span class="help-block">{{$errors->first('examinationfindings')}}</span>
												</div>
											</div>
											<div class="col-md-6 col-xs-12">
												<div class="form-group {{ $errors->has('diagnosis')?'has-error':''}}">
													<label class="control-label" for="diagnosis">Diagnosis</label>
													<textarea event.preventDefault(); style="text-transform: uppercase; resize: none;"  name="diagnosis" id="diagnosis" class="form-control" cols="30" rows="3" placeholder="Diagnosis" required="">{{old('diagnosis')}}</textarea>
													<span class="help-block">{{$errors->first('diagnosis')}}</span>
												</div>
											</div>
										</div>
	{{--Row3--}}						<div class="row">
											<div class="col-md-6 col-xs-12">
												<div class="form-group {{ $errors->has('advise')?'has-error':''}}">
													<label class="control-label" for="advise">Advise</label>
													<textarea event.preventDefault(); style="text-transform: uppercase;resize: none;" name="advise" id="advise" class="form-control" cols="30" rows="3"  placeholder="Advise" required="">{{old('advise')}}</textarea>
													<span class="help-block">{{$errors->first('advise')}}</span>
												</div>
											</div>
											<div class="col-md-2 col-xs-12">
												<div class="form-group {{ $errors->has('followuptype')?'has-error':''}}">
													<label class="control-label" for="followuptype">Follow up</label>
													<select name="followuptype" id="followuptype" class="js-example-basic-single form-control">
														<option value="SOS">SOS</option>
														<option value="Days" >Days</option>
														<option value="Months" >Months</option>
													</select>
													<span class="help-block">{{$errors->first('followuptype')}}</span>
												</div>
											</div>
											<div class="col-md-1 col-xs-12">
												<div class="form-group  {{ $errors->has('numdays')?'has-error':''}}">
													<label class="control-label" id="numdayslabel" for="numdays"></label>
														<select name="numdays" id="numdays" class="js-example-basic-single form-control">
														</select>
														<span class="help-block">{{$errors->first('numdays')}}</span>
												</div>
											</div>
											<div class="col-md-3 col-xs-12">
												<div class="form-group ">
													<label class="control-label" id="nextvisitlabel" for="nextvisit">Follow up on(dd/mm/yyyy)</label>
													<input type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask name="nextvisit" id="nextvisit">
												</div>
											</div>
										</div>
										<hr>
	{{--Row4--}}						<div class="row">
											<div class="col-md-12 col-xs-12">
												<div class="form-group {{ $errors->has('pathology')?'has-error':''}}">
													<label class="control-label" for="pathology">Recommended Clinical Follow up</label>
													<div class="pull-right box-tools">
														<a type="button" id="addpath" class="btn btn-success btn-xs"  data-toggle="modal" data-target="#myPathModal">
														Add Investigation</a>
													</div>
													<select name="pathology[]" id="pathology" class="js-example-basic-multiple  form-control" multiple="multiple" >
													</select>
													<span class="help-block">{{$errors->first('pathology')}}</span>
												</div>
											</div>
										</div>
										<div class="bg-primary">
											<hr style="height: 1px;">
										</div>
	{{--Row5--}}						<div class="row">
											<div class="col-md-8 col-xs-12 ">
												<div class="form-group {{ $errors->has('systolic') || $errors->has('diastolic')?'has-error':''}}">
													<div style="text-align: center;">
														<label for="" >Blood Pressure (Systolic/Diastolic) in mmHg</label>
													</div>
													<div class="row">
														<div class="col-md-6 ">
															<input  data-parsley-type="digits" minlength="2" maxlength="3"  name="systolic" id="systolic" class="form-control" placeholder="Systolic (mmHg)"  style="text-align: center;">
														</div>
														<div class="col-md-6">
															<input data-parsley-type="digits" minlength="2" maxlength="3" class="form-control" name="diastolic" id="diastolic" placeholder="Diastolic (mmHg)"  style="text-align: center;">
														</div>
													</div>
													@if ($errors->has('systolic'))
														<span class="help-block">{{$errors->first('systolic')}}</span>
													@else
														<span class="help-block">{{$errors->first('diastolic')}}</span>
													@endif
												</div>
											</div>
											<div class="col-md-4 col-xs-12">
												<div class="form-group {{ $errors->has('randombs')?'has-error':''}}">
													<div style="text-align: center;">
														<label class="control-label" for="randombs">Random Blood Sugar</label>
													</div>
													<input  data-parsley-type="digits" value="{{old('randombs')}}"  class="form-control" id="randombs" name="randombs" placeholder="mg/dl" minlength="2" maxlength="3" style="text-align: center;" >
													<span class="help-block">{{$errors->first('randombs')}}</span>
												</div>
											</div>
										</div>
	{{--Row6--}}						<div class="row">
											<div class="col-md-4 col-xs-12">
												<div class="form-group {{ $errors->has('pulse')?'has-error':''}}">
													<div style="text-align: center;">
														<label class="control-label" for="pulse">Pulse Rate</label>
													</div>
													<input  data-parsley-type="digits" value="{{old('pulse')}}"  class="form-control" id="pulse" name="pulse" placeholder="beats per minute" minlength="2" maxlength="3" style="text-align: center;" >
													
													<span class="help-block">{{$errors->first('pulse')}}</span>
												</div>
											</div>
											<div class="col-md-4 col-xs-12">
												<div class="form-group {{ $errors->has('resprate')?'has-error':''}}">
													<div style="text-align: center;">
														<label class="control-label" for="resprate">Respiratory Rate</label>
													</div>
													<input  data-parsley-type="digits" value="{{old('resprate')}}"  class="form-control" id="resprate" name="resprate" placeholder="breaths per minute" minlength="2" maxlength="2" style="text-align: center;" >
													<span class="help-block">{{$errors->first('resprate')}}</span>
												</div>
											</div>
											<div class="col-md-4 col-xs-12">
												<div class="form-group {{ $errors->has('spo')?'has-error':''}}">
													<div style="text-align: center;">
														<label class="control-label" for="spo">SPO2 (%)</label>
													</div>
													<input  data-parsley-type="digits" value="{{old('spo')}}"  class="form-control" id="spo" name="spo" placeholder="%" minlength="2" maxlength="3" style="text-align: center;" >
													
													<span class="help-block">{{$errors->first('spo')}}</span>
												</div>
											</div>
										</div>
	{{--Row7--}}						<div class="row">
											<div class="col-md-2 col-xs-12">
												<div class="form-group {{ $errors->has('weight')?'has-error':''}}">
													<div style="text-align: center;">
														<label class="control-label" for="weight">Weight (in kgs)</label>
													</div>
													<input  data-parsley-type="digits" value="{{old('weight')}}"  class="form-control" id="weight" name="weight" placeholder="Weight in kgs" minlength="2" maxlength="3" style="text-align: center;" >
													<span class="help-block">{{$errors->first('weight')}}</span>
												</div>
											</div>
											<div class="col-md-2 col-xs-12">
												<div class="form-group {{ $errors->has('htfeet')?'has-error':''}}">
													<div style="text-align: center;">
														<label class="control-label" for="htfeet">Height (in feet)</label>
													</div>
													<input  data-parsley-type="digits" value="{{old('htfeet')}}"  class="form-control" id="htfeet" name="htfeet" placeholder="Height in feet" minlength="1" maxlength="1" style="text-align: center;" >
													<span class="help-block">{{$errors->first('htfeet')}}</span>
												</div>
											</div>
											<div class="col-md-2 col-xs-12">
												<div class="form-group {{ $errors->has('htinches')?'has-error':''}}">
													<div style="text-align: center;">
														<label class="control-label" for="htinches">Height (in inches)</label>
													</div>
													<input  data-parsley-type="digits" value="{{old('htinches')}}"  class="form-control" id="htinches" name="htinches" placeholder="Height in inches" minlength="1" maxlength="2" style="text-align: center;" >
													<span class="help-block">{{$errors->first('htinches')}}</span>
												</div>
											</div>
											<div class="col-md-2 col-xs-12">
												<div class="form-group {{ $errors->has('height')?'has-error':''}}">
													<div style="text-align: center;">
														<label class="control-label" for="height">Height (in cms)</label>
													</div>
													<input readonly="" data-parsley-type="digits" value="{{old('height')}}"  class="form-control" id="height" name="height" placeholder="Height in centimeters" minlength="3" maxlength="3" style="text-align: center;" >
													<span class="help-block">{{$errors->first('height')}}</span>
												</div>
											</div>
											<div class="col-md-4 col-xs-12">
												<div class="form-group {{ $errors->has('bmi')?'has-error':''}}">
													<div style="text-align: center;">
														<label class="control-label" for="bmi">BMI</label>
													</div>
													<input readonly=""  data-parsley-pattern="^[0-9]{2}\.[0-9]{1}$" value="{{old('bmi')}}"  class="form-control" id="bmi" name="bmi" placeholder="BMI"  style="text-align: center;" >
													<span class="help-block">{{$errors->first('bmi')}}</span>
												</div>
											</div>
										</div>
										<div class="bg-primary">
											<hr style="height: 1px;">
										</div>
	{{--Row8--}}						<div class="row">
			{{--Col 8 start--}}		 		<div class="col-md-12">
			{{--small box start--}}				<div class="small-box bg-gray">
			{{--inner Start--}}						<div class="inner">
		{{--Row8.1--}}									<div class="row">
															<div class="col-md-6 col-xs-12">
																<div class="form-group {{ $errors->has('medname')?'has-error':''}}">
																	<label for="medname" id="medname" class="control-label medcolor" >Brand Name</label>
																	<div class="pull-right box-tools">
																		<a type="button" id="addmed" class="btn btn-sm" style="color: gray;" data-toggle="modal" data-target="#myModal">
																		<i class="fa fa-plus"></i></a>
																		<a type="button" id="clear" class="btn btn btn-sm" style="color: gray;">
																		<i class="fa fa-times"></i></a>
																	</div>
																	<select name="medname" id="medname" class="medname form-control" >
																	</select>
																	<i id="messagebox" class="help-block" style="color: red;"></i>
																</div>
															</div>{{-- .col-md-6 --}}
															<div class="col-md-3 col-xs-12">
																<div class="form-group {{ $errors->has('doseduration')?'has-error':''}}">
																	<label class="control-label medcolor" for="doseduration">Dose Duration</label>
																	<select name="doseduration" id="doseduration" class="js-example-basic-single form-control">
																		<option value="days" selected="">Days</option>
																			<option value="weeks" selected="">Weeks</option>
																			<option value="months" >Months</option>
																			<option value="years" >Years</option>
																			<option value="sos" >SOS</option>
																			<option value="lifetime" >Lifetime</option>
																		</select>
																		<span class="help-block">{{$errors->first('doseduration')}}</span>
																</div>
															</div>
															<div class="col-md-1 col-xs-12">
																<div class="form-group dosedurationdays {{ $errors->has('dosedurationdays')?'has-error':''}}">
																	<label class="control-label medcolor" id="dosedurationdayslabel" for="dosedurationdays">Days</label>
																		<select name="dosedurationdays" id="dosedurationdays" class="js-example-basic-single form-control">
																		</select>
																		<span class="help-block">{{$errors->first('dosedurationdays')}}</span>
																</div>
															</div>
														</div>{{-- .row --}}
		{{--Row8.2--}}									<div class="row">
															<div class="col-md-2 col-xs-12">
																<div class="form-group dosetime {{ $errors->has('dosetime')?'has-error':''}}">
																	<label class="control-label medcolor" for="dosetime">Dose Time</label>
																	<select name="dosetime" id="dosetime" class="js-example-basic-single form-control">
																		<option value="bf" selected="selected">Before Food</option>
																		<option value="af" >After Food</option>
																		<option value="wf" >With Food</option>
																		<option value="oth" >Other</option>
																	</select>
																	<span class="help-block">{{$errors->first('dosetime')}}</span>
																</div>
															</div>
															<div class="col-md-4 col-xs-12">
																<div class="form-group dosetimespecial {{ $errors->has('dosetimespecial')?'has-error':''}}">
																	<label class="control-label medcolor" for="dosetimespecial">Dose Time (Special Instructions)</label>
																	<input type="text" name="dosetimespecial" id="dosetimespecial" class="form-control" style="text-transform: capitalize;">
																	<span class="help-block">{{$errors->first('dosetimespecial')}}</span>
																</div>
															</div>
															<div class="col-md-3 col-xs-12">
																<div class="form-group {{ $errors->has('doseregime1')?'has-error':''}}">
																	<label class="control-label medcolor" for="doseregime1">Dose Regime</label>
																	<select name="doseregime1" id="doseregime1" class="js-example-basic-single form-control">
																		<option value="M-A-N">M-A-N</option>
																		<option value="SOS" >SOS</option>
																		<option value="Other" >Other</option>
																	</select>
																	<span class="help-block">{{$errors->first('doseregime1')}}</span>
																</div>
															</div>
															<div class="col-md-1 col-xs-12">
																<div class="form-group dosemorning {{ $errors->has('dosemorning')?'has-error':''}}">
																	<label class="control-label medcolor" id="dosemorninglabel" for="dosemorning">Morning</label>
																	<select  name="dosemorning" id="dosemorning" class="js-example-basic-single form-control">
																	</select>
																	<span class="help-block">{{$errors->first('dosemorning')}}</span>
																</div>
															</div>
															<div class="col-md-1 col-xs-12">
																<div class="form-group doseafternoon {{ $errors->has('doseafternoon')?'has-error':''}}">
																	<label class="control-label medcolor" id="doseafternoonlabel" for="doseafternoon">Afternoon</label>
																	<select name="doseafternoon" id="doseafternoon" class="js-example-basic-single form-control">
																	</select>
																	<span class="help-block">{{$errors->first('doseafternoon')}}</span>
																</div>
															</div>
															<div class="col-md-1 col-xs-12">
																<div class="form-group dosenight {{ $errors->has('dosenight')?'has-error':''}}">
																	<label class="control-label medcolor" id="dosenightlabel" for="dosenight">Night</label>
																	<select name="dosenight" id="dosenight" class="js-example-basic-single form-control">
																		{{-- appending values between 1 and 31 using jquery --}}
																	</select>
																	<span class="help-block">{{$errors->first('dosenight')}}</span>
																</div>
															</div>
														</div>{{-- .row --}}
		{{--Row8.3--}}									<div class="row">
															<div class="col-md-6 col-md-offset-6 col-xs-12">
																<div class="form-group doseregimespecial {{ $errors->has('doseregimespecial')?'has-error':''}}">
																	<label class="control-label medcolor" for="doseregimespeciallabel">Dose Regime (Special Instructions)</label>
																	<div class="input-group">
																		<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
																		<textarea   name="doseregimespecial" id="doseregimespecial" class="form-control" cols="30" rows="2" style="resize: none;text-transform: uppercase;" placeholder="Special Instruction for Dose Regime"></textarea>
																	</div>
																	<span class="help-block">{{$errors->first('doseregimespecial')}}</span>
																</div>
															</div>
														</div>
		{{--Row8.4--}}									<div class="row">
															<div class="col-md-12 col-xs-12">
																<div class="form-group {{ $errors->has('remarks')?'has-error':''}}">
																	<label class="control-label medcolor" for="remarks">Remarks</label>
																	<div class="input-group">
																		<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
																		<textarea  autofocus=""  name="remarks" id="remarks" class="form-control" cols="30" rows="2" style="resize: none;text-transform: uppercase;" placeholder="Doctor's Remarks"></textarea>
																	</div>
																	<span class="help-block">{{$errors->first('remarks')}}</span>
																</div>
															</div>
														</div>
			{{--inner End--}}						</div>
			{{--small box End--}}				</div>
			{{--Col 8 End--}}				</div>
										</div>
	{{--Row9--}}						<div class="row">
											<div class="col-md-4 col-md-offset-4">
												<a id="bbb" class="btn btn-primary btn-block">Add Prescription</a>
											</div>
										</div>
										<hr>
	{{--Row10--}}						<div class="row">
											<div class="col-md-12">
												<div class="box box-gray">
													<div class="box-header">
													</div>
													<div class="box-body">
														<ul class="todo-list" id="scriplist"></ul>
													</div>
												</div>
											</div>
										</div>
			{{--box-body--}}		</div>
									<div class="box-footer clearfix">
										@if ($editconsult=="false")
											<button type="submit" class="btn btn-success pull-right"><i class="fa fa-check-square-o"></i> Save Consultation</button>
										@else
											<button type="submit" class="btn btn-warning pull-right"><i class="fa fa-check-square-o"></i> Edit and Save Consultation</button>
										@endif
										<a href="{{route('patients.show',$patient->id)}}" class="btn btn-danger pull-right" style="margin-right: 5px;"><i class="fa fa-times"></i> Cancel</a>
									</div>
								</form>
							</div> {{--Box solid--}}
						</div>
					</div>
				</div>
					<?php $countbody=1; ?>
					@foreach ($patient->visits as $visit)
					<div class="tab-pane" id="new{{$countbody}}">
						<div class="row">
							<div class="col-md-12">
								<div class="box box-solid box-primary">
									<div class="box-header with-border">
										<h4 class="box-title">
											{{$visit->created_at->timezone('Asia/Kolkata')->toDayDateTimeString()}}
										</h4>
									</div>
									<div class="box-body">
										<div class="row">
											<div class="col-md-12">
												<a href="{{URL::route('patients.createconsult',['id'=>$patient->id,'repeatvisitid'=>$visit->id,'editconsult'=>'false'])}}"  class="btn btn-xs btn-warning">Repeat All</a> <span class="text-red"><i>Using this feature would refresh and reset all values added in the new consultation</i></span>
											</div>
										</div>
										<br>
										@if (Auth::user()->id == $visit->user_id)
											@if ($visit->created_at->diffInHours(Carbon::now()) <= 36)
												<div class="row">
													<div class="col-md-12">
														<a href="{{URL::route('patients.createconsult',['id'=>$patient->id,'repeatvisitid'=>$visit->id,'editconsult'=>'true'])}}" class="btn btn-xs btn-success">Edit Consultation</a>
													</div>
												</div>
											@endif
										@endif
										<span class="badge bg-gray pull-right">Consultant: DR. {{$visit->user->name}}</span>
										<dl>
											<dt>Chief Complaints</dt>
												<dd >{{$visit->chiefcomplaints}}</dd>
											<dt>Examination Findings</dt>
												<dd>{{$visit->examinationfindings}}</dd>
											<dt>History</dt>
												<dd>{{$visit->patienthistory}}</dd>
											<dt>Diagnosis</dt>
												<dd>{{$visit->diagnosis}}</dd>
											<dt>Advise</dt>
												<dd>{{$visit->advise}}</dd>
											<dt>Follow Up Date</dt>
											@if ($visit->isSOS)
												<dd>On SOS or With Reports</dd>
											@else
												<dd>{{$visit->nextvisit->format('d/m/Y')}}</dd>
											@endif
										</dl>
										@if (count($visit->prescriptions)>0)
											<div class="col-md-12">
												<div class="box">
													<div class="box-header with-border">
														<h3 class="box-title">Prescription</h3>
													</div>
													<div class="box-body">
														<table class="table table-bordered text-center">
															<tr>
																<th>Brand Name</th>
																<th>Regime</th>
																<th>Timing</th>
																<th>Duration</th>
																<th>Remarks</th>
															</tr>
															@foreach ($visit->prescriptions as $p)
															<tr>
																<td><b>{{$p->medicinename}}</b><br>
																@if ($p->medicinecomposition!='')
																	<small><i>({{$p->medicinecomposition}})</i></small>
																@endif
																</td>
																<td>{{$p->doseregime}}</td>
																<td>{{$p->dosetimings}}</td>
																<td>{{$p->doseduration}}</td>
																<td><small><i>{{$p->remarks}}</i></small></td>
															</tr>
															@endforeach
														</table>
													</div>
												</div>
											</div>
										@endif
										@if ($visit->systolic != "" && $visit->diastolic !="")
											<div>
												<strong>BP </strong>{{$visit->systolic}}/{{$visit->diastolic}} mm Hg
											</div>	
										@endif
										@if ($visit->randombs != "" )
											<div>
												<strong>Random Blood Sugar </strong>{{$visit->randombs}} mg/dl
											</div>	
										@endif
										@if ($visit->pulse != "" )
											<div>
												<strong>Pulse </strong>{{$visit->pulse}} beats per minute
											</div>	
										@endif
										@if ($visit->resprate != "" )
											<div>
												<strong>Respiratory Rate </strong>{{$visit->resprate}} breaths per minute
											</div>	
										@endif
										@if ($visit->spo != "" )
											<div>
												<strong>SPO2 </strong>{{$visit->spo}} %
											</div>	
										@endif
										@if ($visit->weight != "" )
											<div>
												<strong>Weight </strong>{{$visit->weight}} kgs
											</div>	
										@endif
										@if ($visit->height != "" )
											<div>
												<strong>Height </strong>{{$visit->height}} cms
											</div>	
										@endif
										@if ($visit->bmi != "" )
											<div>
												<strong>BMI </strong>{{$visit->bmi}}
											</div>	
										@endif
										@if (($visit->systolic != "" && $visit->diastolic !="") || ($visit->randombs != "" || $visit->pulse != "" || $visit->resprate != "" || $visit->spo != "" || $visit->weight != "" || $visit->height != "" || $visit->bmi != ""))
											<br>
										@endif
										<dl>
											<dt>Recommended Clinical Followup</dt>
											<ul>
											@foreach ($visit->pathologies as $pathology)
												<li>{{$pathology->name}}</li>
											@endforeach
											</ul>
										</dl>
										@if (Auth::user()->id == $visit->user_id)
											<div class="box-footer clearfix">
												<a href="{{route('print.visits',['id'=>$visit->id,'printall'=>'true'])}}" class="btn btn btn-success "  target="_blank"><i class="fa fa-print" aria-hidden="true"></i> Print All</a>
												<a href="{{route('print.visits',['id'=>$visit->id,'printall'=>'false'])}}" class="btn btn btn-warning "  target="_blank"><i class="fa fa-print" aria-hidden="true"></i> Print (Diagnosis & Advise)</a>
											</div>{{-- expr --}}
										@endif
									</div>{{-- .box-body --}}
								</div>{{-- .box --}}
							</div>
						</div>
					</div>
					<?php $countbody+=1;?>
					@endforeach {{-- endforeachloop --}}
					<div class="tab-pane" id="healthcharts">
						<div class="row">
							<div class="col-md-12">
								<div class="box box-solid box-primary">
									<div class="box-header with-border">
										<h4 class="box-title">
											Health Charts
										</h4>
									</div>
									<div class="box-body">
										<div class="row">
											<div class="col-md-12">
												{!! $bpchart->render() !!}
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												{!! $randombschart->render() !!}
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												{!! $pulsechart->render() !!}
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												{!! $respratechart->render() !!}
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												{!! $spochart->render() !!}
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												{!! $weightchart->render() !!}
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												{!! $heightchart->render() !!}
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												{!! $bmichart->render() !!}
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> {{--Health Charts--}}
				</div>{{--tab-content--}}
			</div>
		</div>
	</div> {{--Main Row--}}
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<a href="{{route('patients.show',$patient->id)}}" class="btn btn-primary btn-block"><< Back</a>
		</div>
	</div>


		<div class="example-modal" >
			<div class="modal modal-primary" id="myModal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Add Medicine</h4>
						</div>
						<form data-parsley-validate class="formmed" action="#"  enctype="multipart/form-data" method="POST">
						<div class="modal-body">
								{{csrf_field()}}
							<div id="medname-error-label" class="form-group ">
								<label class="control-label" for="medname">Add Medicine</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-plus-square"></i></span>
									<input event.preventDefault(); autofocus="" style="text-transform: capitalize;" type="text" name="medname" id="medname" class="form-control">
								</div>
								<span id="medname-error1" class="help-block"></span>
							</div>
							<div  class="form-group ">
								<label class="control-label" for="medicomp">Medicine Composition</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-plus-square"></i></span>
									<input event.preventDefault(); autofocus="" type="text" name="medicomp" style="text-transform: capitalize;" id="medicomp" class="form-control">
								</div>
								<span  class="help-block"></span>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
							<button type="submit" id="addmedicine" class="btn btn-primary">Save changes</button>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="example-modal">
			<div class="modal modal-primary" id="myPathModal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Add New Investigation</h4>
						</div>
						<form data-parsley-validate class="formpath" action="#" method=""  enctype="multipart/form-data" >
						<div class="modal-body">
							{{csrf_field()}}
							<div id="pathname-error-label" class="form-group ">
								<label class="control-label" for="pathname">Add Investigation</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-plus-square"></i></span>
									<input event.preventDefault(); autofocus="" type="text" name="pathname" style="text-transform: capitalize;" id="pathname" class="form-control">
								</div>
								<span id="pathname-error" class="help-block"></span>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
							<button type="submit" id="addpathology" class="btn btn-outline">Save changes</button>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>


		<div class="example-modal">
			<div class="modal modal-primary" id="ccModal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Add Chief Investigation Template</h4>
						</div>
						<form data-parsley-validate class="formcc" action="#" method=""  enctype="multipart/form-data" >
						<div class="modal-body">
							{{csrf_field()}}
							<div id="templatename-error-label" class="form-group ">
								<label class="control-label" for="templatename">Chief Complaint Template Name</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-plus-square"></i></span>
									<input event.preventDefault(); autofocus="" type="text" name="templatename" style="text-transform: uppercase;" id="templatename" class="form-control">
								</div>
								<span id="templatename-error" class="help-block"></span>
							</div>
							<div id="template-error-label" class="form-group ">
								<label class="control-label" for="template">Chief Complaint Template</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-plus-square"></i></span>
									<textarea event.preventDefault(); class="form-control" style="text-transform: uppercase;" id="template" name="template" id="template" cols="30" rows="5"></textarea>
								</div>
									<span id="template-error" class="help-block"></span>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
							<button type="submit" id="addcctemplate" class="btn btn-outline">Save changes</button>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="example-modal">
			<div class="modal modal-primary" id="efModal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Add Examination Findings Template</h4>
						</div>
						<form data-parsley-validate class="formef" action="#" method=""  enctype="multipart/form-data" >
						<div class="modal-body">
							{{csrf_field()}}
							<div id="templatenameef-error-label" class="form-group ">
								<label class="control-label" for="templatenameef">Examination Findings Template Name</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-plus-square"></i></span>
									<input event.preventDefault(); autofocus="" type="text" name="templatenameef" style="text-transform: uppercase;" id="templatenameef" class="form-control">
								</div>
								<span id="templatenameef-error" class="help-block"></span>
							</div>
							<div id="templateef-error-label" class="form-group ">
								<label class="control-label" for="templateef">Examination Findings Template</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-plus-square"></i></span>
									<textarea event.preventDefault(); class="form-control" style="resize: none; text-transform: uppercase;" id="templateef" name="templateef" id="templateef" cols="30" rows="5"></textarea>

								</div>
								<span id="templateef-error" class="help-block"></span>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
							<button type="submit" id="addeftemplate" class="btn btn-outline">Save changes</button>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>

@stop
<script type="text/javascript">
    var token = '{{Session::token()}}';  
    var urlPathology = "{{URL::route('pathologies.index')}}";  
	var urlMedicine = "{{URL::route('medicines.index',Auth::user()->id)}}";
</script>
<script src="{{asset('src/js/visit.js')}}"></script>
