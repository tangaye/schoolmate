@extends('layouts.master')

@section('page-title', 'Home')

@section('page-header', 'Home')

@section('page-description', 'Users Control Panel')

@section('page-css')
<!-- Animate css -->
  <link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />

  <!-- full calender css -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/fullcalendar/fullcalendar.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home </a></li>
    <li class="active">Dashboard</li>
@endsection

@section('user-logout')
  @component('components.user-logout')
      @slot('user_name')
          {{Auth::guard('web')-> user()->user_name}}
      @endslot
      {{route('user.logout')}}
  @endcomponent
@endsection


@section('sidebar-navigation')
<!-- Sidebar Menu -->
<ul class="sidebar-menu">
  <li class="header">USER NAVIGATION</li>

  <li class="active">
    <a href="{{route('user.dashboard')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
    </a>
  </li>

  <!-- guardians -->
  @if($user->canAccessGuardians())
    <li class="treeview">
      <a href="#"><i class="fa fa-user"></i> <span>Guardians</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @can('view-guardian')
          <li><a href="{{route('users.guardians')}}"><i class="glyphicon glyphicon-th-list"></i> <span>Guardians</span></a></li>
        @endcan
        @can('create-guardian')
          <li><a href="{{route('users.guardians.create')}}"><i class="fa fa-pencil"></i>New Guardian</a></li>
        @endcan
      </ul>
    </li>
  @endif

  <!-- student -->
  @if($user->canAccessStudents())
    <li class="treeview">
      <a href="#">
        <i class="fa fa-users"></i><span>Students</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        @can('view-student')
          <li><a href="{{route('users.students')}}"><i class="glyphicon glyphicon-list-alt"></i>Student List</a></li>
        @endcan
        @can('create-student')
          <li><a href="{{route('users.students.create')}}"><i class="fa fa-pencil"></i>Student Admission</a></li>
        @endcan
      </ul>
    </li>
  @endif

  @if($user->canAccessScores())
    <li class="">
      <a href="{{route('users.scores')}}"><i class="glyphicon glyphicon-list-alt"></i> <span>Score Tables</span></a>
    </li>
  @endif
</ul>
@endsection

@section('content')
    @include('layouts.partials.stats-bar')

    <div class="row">
      <section class="col-lg-7 connectedSortable">
        <!-- calendar -->
        @component('components.calendar')
        @endcomponent
        <!-- /.calender -->

        <!-- grades stat bar chart -->
        @component('components.grades-population-barchart')
        @endcomponent
        <!-- /.grades stats bar chart -->
      </section>
      <!-- /.Left col -->
      <section class="col-lg-5 connectedSortable">
        <div class="box box-widget widget-user-2">    
          <div class="widget-user-header bg-aqua-active">
            <h3 style="color: white;">{{$user->name}}</h3>
            <h5>{{$user->role->name}}</h5>
          </div>
          <div class="box-footer no-padding">
            <ul class="nav nav-stacked">
              <li>
                  <a href="javascript:void(0)">Phone
                      <span class="pull-right badge bg-blue">
                          {{$user->phone}}
                      </span>
                  </a>
              </li>
              <li>
                  <a href="javascript:void(0)">Address 
                      <span class="pull-right badge bg-aqua">
                          {{$user->address}}
                      </span>
                  </a>
              </li>
              <li>
                  <a href="javascript:void(0)">Email 
                      <span class="pull-right badge bg-aqua">
                          {{$user->email}}
                      </span>
                  </a>
              </li>
            </ul>
          </div>
        </div>
        <!-- permissions box-->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Permissions</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            @foreach($user->role->permissions as $key => $value)
              <label class="badge label-default">{{$key}}</label>
            @endforeach
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.permissions box -->
        <!-- Student gender chart -->
        @component('components.gender-chart')
        @endcomponent
        <!-- /.Close of Student gender chart -->
      </section>
      <!-- /.Left col -->
    </div>
@endsection


@section('page-scripts')

 <script src="{{ asset ("/bower_components/AdminLTE/plugins/moment/moment.js") }}"></script>
  <script src="{{ asset ("/bower_components/AdminLTE/plugins/chartjs/Chart.min.js") }}"></script>
  <script src="{{ asset ("/bower_components/AdminLTE/plugins/fullcalendar/fullcalendar.js") }}"></script>
  <script type="text/javascript" src="{{ asset ("/js/charts.js") }}"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#calendar').fullCalendar({
            // put your options and callbacks here
             height:400
        });
    });
  </script>

  @if($flash = session('welcome'))
      <script type="text/javascript">
          var message = "Welcome <b>{{$flash}}</b>!";
          welcome(message);
      </script>
  @endif
@endsection