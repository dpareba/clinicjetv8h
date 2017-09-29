<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="/avatar/docs/{{Auth::user()->avatar}}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        
        <p>{{Auth::user()->jobtype->jobtype!="Receptionist"?"DR.":''}} {{ Auth::user()->name }}</p>

        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
          </button>
        </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      @if ((!Auth::user()->isRemoteDoc))
      <li class="treeview {{(Request::is('patients/create')||Request::is('patients'))?'active':''||Request::is('slots')?'active':''||Request::is('slots.appointmentstoday')?'active':''||Request::is('patients.docspatients')?'active':''}}">
        <a href="#">
          <i class="fa fa-stethoscope"></i> <span>My Clinic Patients</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
         
          @can('nonmedical',Auth::user())
             <li class="{{Request::is('patients')?'active':''}}"><a href="{{ route('patients.index') }}"><i class="fa fa-circle-o text-yellow"></i> View All Patients</a></li>
             <li class="{{Request::is('patients/create')?'active':''}}"><a href="{{route('patients.create')}}"><i class="fa fa-circle-o text-green"></i> Add New Patient</a></li>
             <li class="{{Request::is('slots')?'active':''}}"><a href="{{route('slots.index')}}"><i class="fa fa-circle-o text-aqua"></i> View Appointments</a></li>
          @else
              <li class="{{Request::is('slots.appointmentstoday')?'active':''}}"><a href="{{route('slots.appointmentstoday')}}"><i class="fa fa-circle-o text-aqua"></i> View Appointments</a></li>

              <li ><a href="{{route('patients.create')}}"><i class="fa fa-circle-o text-green"></i> Add New Patient</a></li>              

              <li><a href="{{url('patients.docspatients')}}" ><i class="fa fa-circle-o text-yellow"></i> View My Patients</a></li>

              <li><a href="{{route('patients.index')}}" ><i class="fa fa-circle-o text-yellow"></i> View All Patients</a></li>
         @can('superadmin',Auth::user())    

              <li ><a href="{{url('addnew')}}"><i class="fa fa-circle-o text-green"></i> Add a New Member</a></li>  

              <li ><a href="{{url('managemember')}}"><i class="fa fa-circle-o text-green"></i>Manage Member</a></li>       
          @endcan
          @endcan
         
        </ul>
      </li>
      @endif
        <li class="{{Request::is('profile')?'active':''}}">
          <a href="{{route('profile')}}">
            <i class="fa fa-user-circle"></i> <span>Profile</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-blue">Pro</small>
            </span>
          </a>
        </li>
        @cannot('nonmedical',Auth::user())
        <li class="{{Request::is('videocall/initiate')?'active':''}}">
          <a href="{{route('videocall.initiate')}}" target="_blank">
            <i class="fa fa-video-camera"></i> <span>Video Call</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-maroon">Video</small>
            </span>
          </a>
        </li>
        @endcan
          @cannot('nonmedical',Auth::user())
          <li class="{{Request::is('print')?'active':''}}">
            <a href="{{route('print.index')}}">
              <i class="fa fa-wrench"></i> <span>Print Settings</span>
              <span class="pull-right-container">
                <small class="label pull-right bg-navy">Settings</small>
              </span>
            </a>
          </li>
          @endcan
      </ul>
    </section>
    <!-- /.sidebar -->

  </aside>