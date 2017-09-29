<!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          @yield('pageheading')
          <small>@yield('subpageheading')</small>
        </h1>
        <ol class="breadcrumb">
          <li class="active"><i class="fa fa-id-card-o"></i> Clinic Name: </li>
          <li class="active">{{App\Clinic::where('id',Session::get('clinicid'))->first()->name }} (Id: {{App\Clinic::where('id',Session::get('clinicid'))->first()->cliniccode}} )</li> | 
          <a href="{{route('check')}}">Change Clinic</a>
        </ol>
      </section>