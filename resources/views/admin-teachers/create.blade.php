@extends('layouts.master')

@section('page-title', 'New Teacher')

@section('page-css')
<!-- Animate css -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />

<!-- date picker -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css") }}" rel="stylesheet" type="text/css" />
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
  <li class="treeview active">
    <a href="#"><i class="glyphicon glyphicon-education"></i> <span>Teachers</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{route('teachers.home')}}"><i class="glyphicon glyphicon-th-list"></i> <span>Teachers</span></a></li>
      <li class="active"><a href="{{route('teachers.form')}}"><i class="fa fa-pencil"></i>New Teacher</a></li>
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
    </ul>
  </li>

   <!-- users roles-->
  <li class="treeview">
    <a href="#">
      <i class="glyphicon glyphicon-user"></i><span>Users Roles</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{route('roles.home')}}"><i class="glyphicon glyphicon-list-alt"></i>Roles</a></li>
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
</ul>
@endsection

@section('content')
    <div class="row">
        <form role="form" method="POST" action="{{route('teachers.create')}}">
          {{ csrf_field() }}
          <div class="col-md-7">
              <div class="panel panel-default">
                  <!-- Default panel contents -->
                  <div class="panel-heading">
                    Teacher Details
                  </div>
                  <div class="panel-body">
                    <div class="row">
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }} col-md-12">
                            <label for="first_name" class="control-label">First Name</label>

                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" id="first_name" required autofocus>

                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                      <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }} col-md-12">
                            <label for="surname" class="control-label">Last Name</label>

                            <input id="surname" type="text" class="form-control" name="surname" value="{{ old('surname') }}" required autofocus>

                            @if ($errors->has('surname'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('surname') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
          
                    <div class="row">
                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }} col-md-6">
                            <label for="gender" class="control-label">Gender</label>

                            <select id="gender" type="text" class="form-control" name="gender" value="{{ old('gender') }}" required autofocus>
                                <option value="Female">Female</option>
                                <option value="Male">Male</option>
                            </select>

                            @if ($errors->has('gender'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }} col-md-6">
                            <label for="phone" class="control-label">Phone</label>
                            <input type="text" name="phone" class="form-control" data-inputmask='"mask": "(9999) 999-999"' value="{{ old('phone') }}" phone-mask required="">

                            @if ($errors->has('phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                      <div class="form-group{{ $errors->has('date_of_birth') ? ' has-error' : '' }} col-sm-12">
                          <label class="control-label">Date of Birth</label>
                          <input class="form-control date" id="date_of_birth" name="date_of_birth" required="required" value="{{ old('date_of_birth') }}">

                            @if ($errors->has('date_of_birth'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('date_of_birth') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }} col-md-12">
                            <label for="address" class="control-label">Address</label>

                            <input name="address" id="address" type="text" class="form-control"  value="{{ old('address') }}" required autofocus>

                            @if ($errors->has('address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group{{ $errors->has('qualification') ? ' has-error' : '' }} col-md-12">
                            <label class="control-label">Qualification</label>
                            <input type="text" name="qualification" placeholder="Ex. High School Diploma, BSc." class="form-control" value="{{ old('qualification') }}">

                            @if ($errors->has('qualification'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('qualification') }}</strong>
                                </span>
                            @endif
                        </div>                          
                    </div>
                  </div>
              </div>
          </div>
          <div class="col-md-5">
            <div class="panel panel-default">
              <div class="panel-heading">Teacher Account Details</div>
              <div class="panel-body">

                <div class="row">
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} col-md-12">
                        <label for="user_name" class="control-label">User Name</label>

                        <input id="user_name" type="text" class="form-control" name="user_name" value="{{ old('user_name') }}">

                        @if ($errors->has('user_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('user_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} col-md-12">
                        <label for="email" class="control-label">E-Mail Address</label>

                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row">
                  <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} col-md-12">
                      <label for="password" class="control-label">Password</label>

                      <input id="password" type="password" class="form-control" name="password" required>

                      @if ($errors->has('password'))
                          <span class="help-block">
                              <strong>{{ $errors->first('password') }}</strong>
                          </span>
                      @endif
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-12">
                      <label for="password-confirm" class="control-label">Confirm Password</label>

                      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                  </div>
                </div>                

                <div class="form-group">
                    <button type="submit" class="btn btn-primary pull-left">Save Teacher</button>
                    <a href="javascript:void(0)" onclick="history.back()" class="btn btn-default pull-right">Cancel</a>
                </div>
              </div>
            </div>
          </div>
        </form>
    </div>

@endsection


@section('page-scripts')
  <script src="{{ asset ("/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
  <script src="{{ asset ("/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js") }}"></script>

  <script type="text/javascript">
    //Date picker
    $('#date_of_birth').datepicker({
      autoclose: true
    });

    $("[phone-mask]").inputmask();
  </script>

  @if($flash = session('message'))
      <script type="text/javascript">
          var message = "Teacher <b>{{$flash}}</b> save!";
          notify(message);
      </script>
  @endif
@endsection
