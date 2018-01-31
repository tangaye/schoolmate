@extends('layouts.master')

@section('page-title', 'Edit Academic Year')

@section('user-logout')
  @component('components.user-logout')
      @slot('user_name')
          {{Auth::guard('admin')-> user()->user_name}}
      @endslot
      {{route('admin.logout')}}
  @endcomponent
@endsection


@section('sidebar-navigation')
<!-- Sidebar Menu -->
<ul class="sidebar-menu">
  <li class="header">ADMIN NAVIGATION</li>

  <li class="">
    <a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
    </a>
  </li>

  <!-- guardians -->
  <li class="treeview">
    <a href="#"><i class="fa fa-user"></i> <span>Guardians</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{route('guardians.home')}}"><i class="glyphicon glyphicon-th-list"></i> <span>Guardians</span></a></li>
      <li><a href="{{route('guardians.form')}}"><i class="fa fa-pencil"></i>New Guardian</a></li>
    </ul>
  </li>

  <!-- teachers -->
  <li class="treeview">
    <a href="#"><i class="glyphicon glyphicon-education"></i> <span>Teachers</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{route('teachers.home')}}"><i class="glyphicon glyphicon-th-list"></i> <span>Teachers</span></a></li>
      <li><a href="{{route('teachers.form')}}"><i class="fa fa-pencil"></i>New Teacher</a></li>
      <li><a href="{{route('admin-gradesTeacher.home')}}"><i class="glyphicon glyphicon-align-left""></i>Teacher Grades</a></li>
      <li><a href="{{route('admin-gradesTeacher.form')}}"><i class="fa fa-pencil"></i>New Teacher Grade</a></li>
      <li><a href="{{route('admin.ponsor.home')}}"><i class="glyphicon glyphicon-knight"></i>Sponsors</a></li>
    </ul>
  </li>


  <!-- Settings -->
  <li class="treeview active">
    <a href="#"><i class="fa fa-cogs"></i> <span>Settings</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="/institution"><i class="fa fa-edit"></i>Institution</a></li>
      <li class="active"><a href="/academics"><i class="fa fa-edit"></i>Academic</a></li>
      <li><a href="/subjects"><i class="fa fa-edit"></i>Subjects</a></li>
      <li><a href="/grades"><i class="fa fa-edit"></i>Grades</a></li>
      <li><a href="/divisions"><i class="fa fa-edit"></i>Divisions</a></li>
      <li><a href="/semesters"><i class="fa fa-edit"></i>Semesters</a></li>
      <li><a href="/terms"><i class="fa fa-edit"></i>Terms</a></li>
    </ul>
  </li>

  <!-- student -->
  <li class="treeview">
    <a href="#">
      <i class="fa fa-users"></i><span>Students</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{route('students.home')}}"><i class="glyphicon glyphicon-list-alt"></i>Student List</a></li>
      <li><a href="{{route('students.create')}}"><i class="fa fa-pencil"></i>Student Admission</a></li>
      <li><a href="{{route('enrollments.home')}}"><i class="glyphicon glyphicon-saved"></i>Student Enrollment</a></li>
    </ul>
  </li>

  <!-- attendence -->
    <li class="treeview">
    <a href="#">
      <i class="glyphicon glyphicon-stats"></i><span>Attendence</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{route('attendence')}}"><i class="glyphicon glyphicon-list-alt"></i>Manage Attendence</a></li>
      <li><a href="{{route('attendence.create')}}"><i class="fa fa-pencil"></i>New Attendence</a></li>      
    </ul>
  </li>

  <!-- users -->
  <li class="treeview">
    <a href="#">
      <i class="glyphicon glyphicon-user"></i><span>Users</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{route('users.home')}}"><i class="glyphicon glyphicon-list-alt"></i>User List</a></li>
      <li><a href="{{route('users.form')}}"><i class="fa fa-pencil"></i>New User</a></li>
      <li><a href="{{route('roles.home')}}"><i class="glyphicon glyphicon-tasks"></i>Roles</a></li>
      <li><a href="{{route('roles.form')}}"><i class="fa fa-pencil"></i>New Role</a></li>
    </ul>
  </li>


  <!-- score -->
  <li class="treeview">
    <a href="#">
      <i class="fa fa-fax"></i><span>Scores</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="/scores"><i class="glyphicon glyphicon-list-alt"></i>Score Tables</a></li>
      <li><a href="/scores/master"><i class="fa fa-pencil"></i>Enter Score</a></li>
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
      <li><a href="/scores/report/terms"><i class="fa fa-file-text-o"></i>Term Report</a></li>
      <li><a href="/scores/report/semesters"><i class="fa fa-file-text-o"></i>Semester Report</a></li>
      <li><a href="{{route('annual-scores')}}"><i class="fa fa-file-text-o"></i>Annual Report</a></li>
    </ul>
  </li>
  <!-- transcript -->
  <li>
    <a href="{{route('transcripts.home')}}"><i class="fa fa-file-text-o"></i> <span>Student Transcript</span>
    </a>
  </li>
</ul>
@endsection


@section('content')
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-default ol-md-offset-2">
            <div class="panel-heading">
                <span class="panel-title">Update Academic Year</span>
            </div>

            <div class="panel-body">

              @if(session('error_message'))
                  <div class="alert alert-warning alert-dismissable">
                    <span class="glyphicon glyphicon-warning-sign"></span> &nbsp;
                    <strong>{{ session('error_message') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
              @endif

              <form class="form-horizontal" method="POST" action="/academics/update/{{$academic->id}}">

                {{ csrf_field() }}

                {{-- this is required for every update request --}}                       
                <input type="hidden" name="_method" value="PUT" />

                <!-- div to display errors returned by ajax request-->
                <div class="errors alert alert-danger hidden">
                </div>
                <!-- end of errors div -->

                <div class="hidden">
                    <input type="text" id="academic-id" class="hidden" disabled="true" value="{{$academic->id}}">
                </div>

                <div class="form-group{{ $errors->has('year_start') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Year Start</label>

                    <div class="col-md-8">

                      <div class="input-group date">
                        <input readonly="" id="edit-start" class="form-control edit-years" type="" value="{{$academic->year_start}}" name="year_start">
                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                      </div>
                      <ul>
                        <li class="edit-date-start-error text-danger hidden"></li>
                          {{--ajax error block--}}
                        <li class="edit-date-start-duplicate text-danger hidden"></li>
                      </ul>

                      @if ($errors->has('year_start'))
                          <span class="help-block">
                              <strong>{{ $errors->first('year_start') }}</strong>
                          </span>
                      @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('year_end') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Year End</label>

                    <div class="col-md-8">
                      <div class="input-group date">

                         <input readonly="" id="edit-end" class="form-control edit-years" name="year_end" required type="" value="{{$academic->year_end}}">

                        <span class="input-group-addon">
                          <i class="glyphicon glyphicon-calendar"></i>
                        </span>

                      </div>

                      <ul>
                        <li class="edit-date-end-error text-danger hidden"></li>
                          {{--ajax error block--}}
                        <li class="edit-date-end-duplicate text-danger hidden"></li>
                      </ul>

                      @if ($errors->has('year_end'))
                          <span class="help-block">
                              <strong>{{ $errors->first('year_end') }}</strong>
                          </span>
                      @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">Status</label>

                    <div class="col-md-8">
                      @foreach($statuses as $name => $value)
                        <label class="radio-inline">
                          <input type="radio" name="status" required="" {{$value == $academic->status ? 'checked' : ''}} value="{{$value}}">{{$name}}
                        </label>
                      @endforeach

                        @if ($errors->has('status'))
                            <span class="help-block">
                                <strong>{{ $errors->first('status') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                  <div class="col-md-4 col-md-offset-2">
                      <input type="submit" name="update" id="update-academic" class="btn btn-success" value="Update">  &nbsp;

                      <a class="btn btn-default" href="{{route('academics.home')}}">Cancel</a>
                  </div>
                </div>
              </form>
            </div>
        </div>
    </div>  
  </div>
@endsection