@extends('layouts.master')

@section('page-title', 'Grades Teacher Table')

@section('page-css')
    <!-- Animate css -->
    <link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
@endsection

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
  <li class="treeview">
    <a href="#"><i class="fa fa-cogs"></i> <span>Settings</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="/institution"><i class="fa fa-edit"></i>Institution</a></li>
      <li><a href="/academics"><i class="fa fa-edit"></i>Academic</a></li>
      <li><a href="/subjects"><i class="fa fa-edit"></i>Subjects</a></li>
      <li><a href="/grades"><i class="fa fa-edit"></i>Grades</a></li>
      <li><a href="/divisions"><i class="fa fa-edit"></i>Divisions</a></li>
      <li><a href="/semesters"><i class="fa fa-edit"></i>Semesters</a></li>
      <li><a href="/terms"><i class="fa fa-edit"></i>Terms</a></li>
    </ul>
  </li>

  <!-- student -->
  <li class="treeview active">
    <a href="#">
      <i class="fa fa-users"></i><span>Students</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{route('students.home')}}"><i class="glyphicon glyphicon-list-alt"></i>Student List</a></li>
      <li><a href="{{route('students.create')}}"><i class="fa fa-pencil"></i>Student Admission</a></li>
      <li class="active"><a href="{{route('enrollments.home')}}"><i class="glyphicon glyphicon-saved"></i>Student Enrollment</a></li>
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
                    <span class="panel-title">Update Student Enrollment (<b>{{$academic->year_start."/".$academic->year_end}}</b>)</span>
                </div>

                <div class="panel-body">
                  <form class="form-horizontal" method="POST" action="/enrollments/update/{{$student->enrollment_id}}">

                    {{ csrf_field() }}

                    {{-- this is required for every update request --}}                       
                    <input type="hidden" name="_method" value="PUT" />

                    <input type="" name="student_id" value="{{$student->id}}" class="hidden">

                    <input type="" name="academic_id" value="{{$student->academic_id}}" class="hidden">

                    <div class="form-group{{ $errors->has('student_id') ? ' has-error' : '' }}">
                        <label class="col-md-2 control-label">Student</label>

                        <div class="col-md-8">
                          <input readonly="" class="form-control" type="" value="{{$student->first_name." ".$student->middle_name." ".$student->surname}}">
                            @if ($errors->has('student_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('student_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('last_grade') ? ' has-error' : '' }}">
                        <label class="col-md-2 control-label">Last Grade</label>

                        <div class="col-md-8">
                          <select name="last_grade" id="last_grade" class="form-control" required="">
                            @foreach($grades as $grade)
                              <option value="{{$grade->id}}" {{$grade->id === $student->last_grade ? 'selected' : ''}}>{{$grade->name}}</option>
                            @endforeach
                          </select>

                            @if ($errors->has('last_grade'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('last_grade') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('current_grade') ? ' has-error' : '' }}">
                        <label class="col-md-2 control-label">Current Grade</label>

                        <div class="col-md-8">
                          <select name="current_grade"  class="form-control" required="">
                            @foreach($grades as $grade)
                              <option value="{{$grade->id}}" {{$grade->id === $student->current_grade ? 'selected' : ''}}>{{$grade->name}}</option>
                            @endforeach
                          </select>

                            @if ($errors->has('current_grade'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('current_grade') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('student_type') ? ' has-error' : '' }}">
                        <label class="col-md-2 control-label">Student Type</label>

                        <div class="col-md-8">
                          <select name="student_type" class="form-control" required="">
                            @foreach($types as $type)
                              <option value="{{$type}}" {{$type === $student->student_type ? 'selected' : ''}}>{{$type}}</option>
                            @endforeach
                          </select>

                            @if ($errors->has('student_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('student_type') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('enrollment_status') ? ' has-error' : '' }}">
                        <label class="col-md-2 control-label">Enrollment Status</label>

                        <div class="col-md-8">
                          <select name="enrollment_status" class="form-control" required="">
                            @foreach($statuses as $status)
                              <option value="{{$status}}" {{$status === $student->enrollment_status ? 'selected' : ''}}>{{$status}}</option>
                            @endforeach
                          </select>

                            @if ($errors->has('enrollment_status'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('enrollment_status') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-4 col-md-offset-2">
                          <input type="submit" name="update" class="btn btn-success" value="Update">  &nbsp;

                          <a class="btn btn-default" href="{{route('enrollments.home')}}">Cancel</a>
                      </div>
                    </div>
                  </form>
                </div>
            </div>
        </div>  
    </div>

@endsection