@extends('layouts.master')

@section('page-title', 'New Role')


@section('page-header', 'New Role')

@section('user-logout')
  @component('components.user-logout')
      @slot('user_name')
          {{Auth::guard('admin')-> user()->user_name}}
      @endslot
      {{route('admin.logout')}}
  @endcomponent
@endsection


@section('page-css')
  <link href="{{ asset("/bower_components/AdminLTE/plugins/select2/select2.min.css") }}" rel="stylesheet" type="text/css" />
	<!-- Animate css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
	<!-- swal alert css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.css") }}" rel="stylesheet" type="text/css" />
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
  
  <!-- teacher -->
  <li class="treeview">
    <a href="#"><i class="glyphicon glyphicon-education"></i> <span>Teachers</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{route('teachers.home')}}"><i class="glyphicon glyphicon-th-list"></i> <span>Teachers</span></a></li>
      <li><a href="{{route('teachers.form')}}"><i class="fa fa-pencil"></i>New Teacher</a></li>
      <li><a href="{{route('admin-gradesTeacher.home')}}"><i class="glyphicon glyphicon-asterisk"></i>Teacher Grades</a></li>
        <li><a href="{{route('admin-gradesTeacher.form')}}"><i class="fa fa-pencil"></i>New Teacher Grade</a></li>
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
  <li class="treeview">
    <a href="#">
      <i class="fa fa-users"></i><span>Students</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="/students"><i class="glyphicon glyphicon-list-alt"></i>Student List</a></li>
      <li><a href="/students/create"><i class="fa fa-pencil"></i>Student Admission</a></li>
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
  <li class="treeview active">
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
      <li class="active"><a href="{{route('roles.form')}}"><i class="fa fa-pencil"></i>New Role</a></li>
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
</ul>
@endsection

@section('content')
  
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
          <div class="container-fluid">
            <span> Enter New Role</span>
            <a href="" onclick="history.back()" class="btn btn-primary pull-right btn-sm">
              <i class="glyphicon glyphicon-arrow-left"></i>
              Back
            </a>
          </div>
       </div>

				<div class="panel-body">
					<!-- Table -->
					<form class="form-horizontal" method="POST" action="{{ route('roles.create') }}">
              {{ csrf_field() }}

              <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                  <label for="name" class="col-md-2 control-label">Name</label>

                  <div class="col-md-8">
                      <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                      @if ($errors->has('name'))
                          <span class="help-block">
                              <strong>{{ $errors->first('name') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                  <label for="name" class="col-md-2 control-label">Description</label>

                  <div class="col-md-8">
                      <textarea class="form-control" name="description">{{ old('description') }}</textarea>

                      @if ($errors->has('description'))
                          <span class="help-block">
                              <strong>{{ $errors->first('description') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="form-group{{ $errors->has('permissions') ? ' has-error' : '' }}">
                  <label class="col-md-2 control-label">Permissions</label>

                  <div class="col-md-8">
                    <table class="table-responsive">
                      @foreach($permissions as $key => $value)
                        <tr>
                          <div class="col-md-4" style="padding-left: 0">
                            <label class="checkbox-inline">
                              <input type="checkbox" name="permissions[{{$key}}]" value="{{$value}}">{{$key}}
                            </label>
                          </div>
                        </tr>
                      @endforeach
                    </table>


                      @if ($errors->has('permissions'))
                          <span class="help-block">
                              <strong>{{ $errors->first('permissions') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="form-group">
                  <div class="col-md-4 col-md-offset-2">
                      <button type="submit" class="btn btn-primary">
                          Create
                      </button>
                  </div>
              </div>
          </form>
				</div>
			</div>
		</div>	
	</div>

@endsection

@section('page-scripts')

  <script src="{{ asset ("/bower_components/AdminLTE/plugins/select2/select2.full.min.js") }}"></script>

	<script src="{{ asset ("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.min.js") }}"></script>

  <script type="text/javascript">
    //Initialize Select2 Elements
      $(".permissions").select2();
  </script>

	@if($flash = session('message'))
      <script type="text/javascript">
          var message = "Role <b>{{$flash}}</b> save!";
          notify(message);
      </script>
  @endif


@endsection