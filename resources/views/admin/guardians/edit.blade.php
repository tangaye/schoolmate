@extends('layouts.master')

@section('page-title', 'Edit User')

@section('page-header', 'Edit User')

@section('page-css')
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
  <li class="treeview active">
    <a href="#"><i class="fa fa-user"></i> <span>Guardians</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="active"><a href="{{route('guardians.home')}}"><i class="glyphicon glyphicon-th-list"></i> <span>Guardians</span></a></li>
      <li><a href="{{route('guardians.form')}}"><i class="glyphicon glyphicon-pencil"></i>New Guardian</a></li>
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
  <li class="treeview">
    <a href="#">
      <i class="fa fa-users"></i><span>Students</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{route('students.home')}}"><i class="glyphicon glyphicon-list-alt"></i>Student List</a></li>
      <li><a href="{{route('students.create')}}"><i class="glyphicon glyphicon-pencil"></i>Student Admission</a></li>
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
      <li><a href="{{route('attendence.create')}}"><i class="glyphicon glyphicon-pencil"></i>New Attendence</a></li>      
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
      <li><a href="{{route('users.form')}}"><i class="glyphicon glyphicon-pencil"></i>New User</a></li>
      <li><a href="{{route('roles.home')}}"><i class="glyphicon glyphicon-tasks"></i>Roles</a></li>
      <li><a href="{{route('roles.form')}}"><i class="glyphicon glyphicon-pencil"></i>New Role</a></li>
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
      <li><a href="/scores/master"><i class="glyphicon glyphicon-pencil"></i>Enter Score</a></li>
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
    <div class="col-md-4">
        <div class="box box-widget widget-user-2">    
          <div class="widget-user-header bg-yellow">
            <h3 style="color: white;">{{$guardian->first_name}} {{$guardian->surname}}</h3>
            <h5>{{$guardian->relationship}}</h5>
          </div>
          <div class="box-footer no-padding">
            <ul class="nav nav-stacked">
              <li>
                  <a href="javascript:void(0)">Phone
                      <span class="pull-right badge bg-blue">
                          {{$guardian->phone}}
                      </span>
                  </a>
              </li>
              <li>
                  <a href="javascript:void(0)">Address 
                      <span class="pull-right badge bg-aqua">
                          {{$guardian->address}}
                      </span>
                  </a>
              </li>
            </ul>
          </div>
        </div>

        <!-- STUDENTS ASSIGNED TO GUARDIAN -->
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">Guardian Student(s)</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body no-padding">
            <ul class="users-list clearfix">
              <ul class="users-list clearfix">
                  @foreach($guardian->student as $student)
                      <li>

                        @if($student->photo)
                            <img src="{{ asset("images/".$student->photo) }}" alt="Student photo"/>
                        @else
                            <img src="{{ asset("images/default.png") }}" alt="Student photo"/>
                        @endif
                        <a class="users-list-name" href="/students/edit/{{$student->id}}">{{$student->first_name}}</a>
                      </li>
                  @endforeach
              </ul>
            </ul>
            <!-- /.users-list -->
          </div>
        </div>
        <!--/.box -->
    </div>
		<div class="col-md-8">

      @include ('layouts.errors')
            
			<div class="panel panel-default">
				<!-- Default panel contents -->
				<div class="panel-heading">
          <span class="panel-title">Edit Guardian</span>
				</div>
        <form method="POST" action="/admin/guardians/update/{{$guardian->id}}">
          <div class="panel-body">
           {{ csrf_field() }}
            {{-- this is required for every update request --}}
            <input type="hidden" name="_method" value="PUT" />

            <div class="row">
                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }} col-md-12">
                    <label for="first_name" class="control-label">First Name</label>

                    <input type="text" class="form-control" name="first_name" value="{{$guardian->first_name}}" id="first_name" required autofocus>

                    @if ($errors->has('first_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="row">
              <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }} col-md-12">
                    <label for="surname" class="    control-label">Last Name</label>

                    <input id="surname" type="text" class="form-control" name="surname" value="{{$guardian->surname}}" required autofocus>

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

                    <select name="gender" class="form-control" required="">
                        @foreach($genders as $gender)
                            @if($gender === $guardian->gender)
                                <option value="{{$gender}}" selected="">{{$gender}}</option>
                            @else
                                <option value="{{$gender}}">{{$gender}}</option>
                            @endif
                        @endforeach
                    </select>

                    @if ($errors->has('gender'))
                        <span class="help-block">
                            <strong>{{ $errors->first('gender') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }} col-md-6">
                    <label for="phone" class="control-label">Phone Number</label>

                    <input type="text" class="form-control" name="phone" value="{{$guardian->phone}}" required autofocus>

                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
            </div>


            <div class="row">
                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }} col-md-12">
                    <label for="address" class="control-label">Address</label>

                    <input name="address" id="address" type="text" class="form-control"  value="{{$guardian->address}}" required autofocus>

                    @if ($errors->has('address'))
                        <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group{{ $errors->has('relationship') ? ' has-error' : '' }} col-md-12">
                    <label for="relationship" class="control-label">Relationship</label>
                    <select id="relationship" name="relationship" class="form-control">
                        @foreach($relationships as $relationship)
                            @if($relationship === $guardian->relationship)
                                <option value="{{$guardian->relationship}}" selected="">{{$guardian->relationship}}</option>
                            @else
                                <option value="{{$relationship}}">{{$relationship}}</option>
                            @endif
                        @endforeach
                    </select>

                    @if ($errors->has('relationship'))
                        <span class="help-block">
                            <strong>{{ $errors->first('relationship') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} col-md-6">
                    <label for="email" class="control-label">E-Mail Address</label>

                    <input id="email" type="email" class="form-control" name="email" value="{{$guardian->email}}">

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }} col-md-6">
                    <label for="user_name" class="control-label">User Name</label>

                    <input id="user_name" type="text" class="form-control" name="user_name" value="{{$guardian->user_name}}">

                    @if ($errors->has('user_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('user_name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="checkbox form-group col-md-12">
                    <label>
                        <input id="reset" type="checkbox" value="">
                        <b> Reset Password?<b>
                    </label>
                </div>
            </div>

            <div class="row resetpassword hidden">
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} col-md-6">
                    <label for="password" class="control-label">Password</label>

                    <input id="password" type="password" class="form-control password" name="password" value="{{old('password')}}">

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control password" name="password_confirmation">
                    </div>
                </div>

            </div>
          </div>
          <div class="panel-footer text-right">

            <button type="submit" class="btn btn-success">Update</button> &nbsp;
            <a href="{{route('guardians.home')}}" class="btn btn-default">Cancel</a>
          </div>
        </form>
			</div>
			<!-- /. close of panel div -->
		</div>
	</div>

@endsection


@section('page-scripts')

    <script type="text/javascript">

        $(document).ready(function($) {
            $('#reset').change(function() {
                if ($('#reset').is(':checked')) {
                    $(".resetpassword").removeClass('hidden');
                    $('.password').attr('required', true);
                    $(".resetpassword").show();
                } else {
                    $(".resetpassword").addClass('hidden');
                    $('.password').attr('required', false);
                    $(".resetpassword").hide();
                }
            });
        });
    </script>   
@endsection