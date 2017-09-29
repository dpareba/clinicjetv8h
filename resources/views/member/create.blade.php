@extends('layouts.master')
@section('title')
| Add new Member
@stop
@section('pageheading')
New Member     
@stop
@section('subpageheading')
View/Search for My Patients 
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Join New Member</div>
                <div class="panel-body">
                    @include('partials.flash', ['some' => 'data'])
                     <div id="jid" class="form-group{{ $errors->has('jobtype') ? ' has-error' : '' }}">
                            <label for="jobtype" class="col-md-4 control-label">Joining As</label>
                            <div class="col-md-6">
                                <select required="" data-parsley-required-message="*Kindly Select Member Type" name="jobtype" id="jobtype" class="js-example-basic-single form-control">
                                    @foreach ($jobtypes as $jobtype)
                                        <option value="{{$jobtype->id}}" {{$jobtype->Jobtype == 'Doctor' ? 'selected="selected"' : ''}}>{{$jobtype->jobtype}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('jobtype'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('jobtype') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('codenumber') ? ' has-error' : '' }}">
                            <label for="codenumber" class="col-md-4 control-label">Code Number</label>
                            <div class="col-md-6">
                                <input id="codenumber" readonly type="text" class="form-control" name="codenumber" value="" event.preventDefault();>
                                @if ($errors->has('codenumber'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('codenumber') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>                        
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button id="genkey" type="" class="btn btn-primary">
                                    Generate Key
                                </button>
                            </div>
                        </div>
                        <div class="col-md-8 col-md-offset-4">
                                <strong>Add Existing Member</strong>
                        </div>
                    {{-- <form data-parsley-validate class="form-horizontal" role="form" method="POST" action=""> --}}
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Email</label>
                            <div class="col-md-6">
                                <input id="email"  type="text" class="form-control" name="email" value="">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>        
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button data-toggle="modal" data-target="#addmember" type=" " class="btn btn-primary">
                                    submit
                                </button>
                            </div>
                        </div>

                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addmember" tabindex="-1" role="dialog" aria-labelledby="favoritesModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" 
          data-dismiss="modal" 
          aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="favoritesModalLabel">Confirm joining the member</h4>
      </div>
      <form action="{{route('attachmember')}}" method="POST">
      <input type="hidden" name="_token" value="{{csrf_token()}}">
      <div class="modal-body">
          <table class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Full Name</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Registered On</th>
            </tr>
            </thead>
            <tbody id="getMember">
             
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <span class="pull-right">
          <button type="submit" idSclass="btn btn-primary">Confirm</button>
        </span>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#joincode').focus();
        });
        var token = '{{Session::token()}}';  
        var urlgenKey = "{{URL::to('/getCodeNumber')}}";  
        var urlgetmember = "{{URL::to('/getMember')}}"; 
    </script>
    <script src="{{asset('src/js/getMember.js')}}"></script>
@endsection
