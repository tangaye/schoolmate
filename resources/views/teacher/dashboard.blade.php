@extends('layouts.master')

@section('page-title', 'Home')

@section('page-header', 'Home')

@section('page-description', 'Teacher Control Panel')

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
          {{Auth::guard('teacher')-> user()->user_name}}
      @endslot
      {{route('teacher.logout')}}
  @endcomponent
@endsection


@section('sidebar-navigation')
<!-- Sidebar Menu -->
<ul class="sidebar-menu">
  <li class="header">TEACHER NAVIGATION</li>
  <li class="active">
    <a href="{{route('teacher.dashboard')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
    </a>
  </li>
  <li>
    <a href="{{route('teacher.manage-scores')}}"><i class="fa fa-pencil"></i> <span>Manage Scores</span></a>
  </li>
  <li>
    <a href="{{route('teacher.scores-home')}}"><i class="glyphicon glyphicon-th-list"></i> <span>Scores Table</span></a>
  </li>

  <li class="treeview">
    <a href="#">
      <i class="glyphicon glyphicon-stats"></i><span>Attendence</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{route('teacher-attendence')}}"><i class="glyphicon glyphicon-list-alt"></i>View Attendence</a></li>
      <li><a href="{{route('teacher-attendence.create')}}"><i class="fa fa-pencil"></i>New Attendence</a></li>      
    </ul>
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
      <li><a href="{{route('teacher.term-scores')}}"><i class="fa fa-file-text-o"></i>Term Report</a></li>
      <li><a href="{{route('teacher.semester-scores')}}"><i class="fa fa-file-text-o"></i>Semester Report</a></li>
      <li><a href="{{route('teacher.annual-scores')}}"><i class="fa fa-file-text-o"></i>Annual Report</a></li>
    </ul>
  </li>
</ul>
<!-- /.sidebar-menu -->
@endsection

@section('content')
  @include('layouts.partials.stats-bar')

  <div class="row">
    <section class="col-lg-8">
      <!-- calendar -->
      @component('components.calendar')
      @endcomponent
      <!-- /.calender -->
    </section>
    <!-- /.Left col -->
    <section class="col-lg-4">

      <div class="box box-widget widget-user-2">    
          <div class="widget-user-header bg-green">
            <h3 style="color: white;">
              @if($teacher->gender === "Male")
                Mr. {{$teacher->first_name}} {{$teacher->surname}}</h3>
              @else
                Mrs/Ms. {{$teacher->first_name}} {{$teacher->surname}}</h3>
              @endif
            <h5>{{$teacher->email}}</h5>
          </div>
          <div class="box-footer no-padding">
            <ul class="nav nav-stacked">
              <li>
                  <a href="javascript:void(0)">Username
                      <span class="pull-right badge bg-blue">
                          {{$teacher->user_name}}
                      </span>
                  </a>
              </li>
              <li>
                  <a href="javascript:void(0)">Phone
                      <span class="pull-right badge label-warning">
                          {{$teacher->phone}}
                      </span>
                  </a>
              </li>
             <li>
                @if($teacher->grade_sponsoring())
                   <a href="javascript:void(0)">Sponsoring 
                      <span class="pull-right badge bg-aqua">
                          {{$teacher->grade_sponsoring()}}
                      </span>
                  </a>
                @else
                   <a href="javascript:void(0)"> No sponsor grade this year.
                  </a>
                @endif
            </li>
            </ul>
          </div>
        </div>

        <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Grades and Subjects</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <table class="table table-responsive table-bordered table-condensed">
                <tbody>
                  @foreach($grades as $grade)
                    <tr>
                      <td>{{$grade->name}}</td>
                      <td>
                        @foreach(App\Repositories\TeachersRepository::teacher_grade_subjects($grade->id, $teacher->id) as $subject)
                          <span class="badge label-default">{{$subject}}</span>
                        @endforeach
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.Left col -->
  </div>
@endsection


@section('page-scripts')

<script src="{{ asset ("/bower_components/AdminLTE/plugins/moment/moment.js") }}"></script>
<script src="{{ asset ("/bower_components/AdminLTE/plugins/fullcalendar/fullcalendar.js") }}"></script>

  @if($flash = session('welcome'))
      <script type="text/javascript">
          var message = "Welcome <b>{{$flash}}</b>!";
          welcome(message);
      </script>
  @endif

  <script type="text/javascript">
    $(document).ready(function() {

      $('#calendar').fullCalendar({
        // put your options and callbacks here        
        height:450
      });

    });
  </script>
@endsection