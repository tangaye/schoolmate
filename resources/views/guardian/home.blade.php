@extends('layouts.master')

@section('page-title', 'Home')

@section('page-header', 'Home')

@section('page-description', 'Guardian Control Panel')

@section('page-css')

<!-- Animate css -->
  <link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('user-logout')
  @component('components.user-logout')
      @slot('user_name')
          {{Auth::guard('guardian')-> user()->user_name}}
      @endslot
      {{route('guardian.logout')}}
  @endcomponent
@endsection

@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home </a></li>
    <li class="active">Dashboard</li>
@endsection



@section('sidebar-navigation')
<!-- Sidebar Menu -->
<ul class="sidebar-menu">
  <li class="header">MAIN NAVIGATION</li>
  <li class="">
    <a href="{{route('guardian.dashboard')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
    </a>
  </li>
  <!-- reports -->
  <li class="treeview">
    <a href="#">
      <i class="fa fa-folder-open-o"></i>
      <span>Scores Reports</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="/guardian/students/term"><i class="fa fa-file-text-o"></i>Term Report</a></li>
      <li><a href="/guardian/students/semester"><i class="fa fa-file-text-o"></i>Semester Report</a></li>
      <li><a href="/guardian/students/annual"><i class="fa fa-file-text-o"></i>Annual Report</a></li>
    </ul>
  </li>
</ul>
<!-- /.sidebar-menu -->
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <span>GUARDIAN WARD Hello: </span>
          <strong>{{Auth::guard('guardian')->user()->first_name }} {{Auth::guard('guardian')->user()->surname }}</strong>
        </div>

        <div class="panel-body">
          <div class="row">
            @foreach($guardians as $guardian)
              @foreach($guardian->student as $student)
                  <div class="col-md-4">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user-2">
                      <!-- Add the bg color to the header using any of the bg-* classes -->
                      <div class="widget-user-header bg-aqua-active">
                        <div class="widget-user-image">
                          @if($student->photo)
                              <img src="{{ asset("images/".$student->photo) }}" class="img-circle" alt="Student photo"/>
                          @else
                              <img src="{{ asset("images/default.png") }}" class="img-circle" alt="Student photo"/>
                          @endif
                        </div>
                        <!-- /.widget-user-image -->
                        <h3 class="widget-user-username">{{$student->first_name}} {{$student->surname}}</h3>
                        <h5 class="widget-user-desc">
                          {{$student->grade->name}}
                          <span class="badge bg-green">{{$student->gender}}</span>
                        </h5>
                      </div>
                      <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                          <li><a href="javascript:void(0)">Age<span class="pull-right badge bg-yellow">{{$student->age()}}</span></a></li>

                          <li><a href="javascript:void(0)">Birth Date <span class="pull-right badge bg-aqua">{{$student->date_of_birth->toFormattedDateString()}}</span></a></li>
                          <li><a href="javascript:void(0)">Address<span class="pull-right badge bg-red">{{$student->address}}</span></a></li>
                        </ul>
                      </div>
                    </div>
                    <!-- /.widget-user -->
                  </div>
                  <!-- /.col -->
              @endforeach
            @endforeach
          </div>
        </div>
      </div>
    </div>  
  </div>
@endsection


@section('page-scripts')

  @if($flash = session('welcome'))
      <script type="text/javascript">
          var message = "Welcome <b>{{$flash}}</b>!";
          welcome(message);
      </script>
  @endif
@endsection