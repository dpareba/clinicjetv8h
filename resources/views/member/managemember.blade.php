@extends('layouts.master')
@section('title')
	| Manage Member
@stop
@section('pageheading')
	All Members		
@stop
@section('subpageheading')
	View/Search for Members registered with Clinic
@stop
@section('content')
	{{-- {{$patients}} --}}
	<div class="row">
        <div class="col-xs-12">
 			<div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Registered Members</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Full Name</th>
                  <th>Primary Phone</th>
                  <th>Email</th>
                  <th>Delete</th>
                  <th>Role</th>
                </tr>
                </thead>
                <tbody>
                      @foreach ($users as $user)
                      @foreach($user->roles()->wherePivot('clinic_id',Session::get('clinicid'))->get() as $role)
                      {{$roles = $role->role}}
                      @endforeach
                      @if($roles!=="SuperAdmin")
             
                       <tr>
                          <td>{{$user->name}}</td>
                          <td>{{$user->phone}}</td>
                          <td>{{$user->email}}</td>
                          <td><a data-id="{{$user->id}}" data-toggle="modal" data-target="#delete" href="#"> Delete</a></td>
                          <td>{{$user->role_id}}</td>
                      </tr>
                      @endif
                      @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Full Name</th>
                  <th>Primary Phone</th>
                  <th>Email</th>
                  <th>Delete</th>
                  <th>Role</th>
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

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="favoritesModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" 
          data-dismiss="modal" 
          aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="favoritesModalLabel">Confirm Delete the member</h4>
      </div>
      <form action="{{route('delete')}}" method="POST">
      <input type="hidden" name="_token" value="{{csrf_token()}}">
      <div class="modal-body">
        <p>
          Please confirm you would like to Delete 
         </p>
      </div>
      <input type="hidden" id="userid" name="userid" value="">
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <span class="pull-right">
          <button type="submit" idSclass="btn btn-primary">Delete</button>
        </span>
      </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
$('#delete').on("show.bs.modal", function (e) { 
      $("#userid").val($(e.relatedTarget).data('id'));

  });

</script>
@stop