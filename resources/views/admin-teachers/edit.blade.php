@extends('layouts.master')

@section('page-title', 'Edit Teacher')

@section('page-header', 'Edit Teacher')

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

  <!-- teachers -->
  <li class="treeview">
    <a href="#"><i class="fa fa-user"></i> <span>Guardians</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{route('teachers.home')}}"><i class="glyphicon glyphicon-th-list"></i> <span>Guardians</span></a></li>
      <li><a href="{{route('teachers.form')}}"><i class="fa fa-pencil"></i>New Guardian</a></li>
    </ul>
  </li>

  <!-- teachres -->
  <li class="treeview active">
    <a href="#"><i class="glyphicon glyphicon-education"></i> <span>Teachers</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="active"><a href="{{route('teachers.home')}}"><i class="glyphicon glyphicon-th-list"></i> <span>Teachers</span></a></li>
      <li><a href="{{route('teachers.form')}}"><i class="fa fa-pencil"></i>New Teacher</a></li>
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
      <li><a href="#"><i class="fa fa-file-text-o"></i>Annual Report</a></li>
    </ul>
  </li>
</ul>
@endsection


@section('content')

	<div class="row">
    <div class="col-md-4">
        <div class="box box-widget widget-user-2">    
          <div class="widget-user-header bg-yellow">
            <h3 style="color: white;">{{$teacher->first_name}} {{$teacher->surname}}</h3>
            <h5>{{$teacher->qualification}}</h5>
          </div>
          <div class="box-footer no-padding">
            <ul class="nav nav-stacked">
              <li>
                  <a href="javascript:void(0)">Phone
                      <span class="pull-right badge bg-blue">
                          {{$teacher->phone}}
                      </span>
                  </a>
              </li>
              <li>
                  <a href="javascript:void(0)">Address 
                      <span class="pull-right badge bg-aqua">
                          {{$teacher->address}}
                      </span>
                  </a>
              </li>
              <li>
                  <a href="javascript:void(0)">Email 
                      <span class="pull-right badge bg-green">
                          {{$teacher->email}}
                      </span>
                  </a>
              </li>
            </ul>
          </div>
        </div>

        <!-- STUDENTS ASSIGNED TO GUARDIAN -->
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">Teacher Class(es)</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body no-padding">
            <ul class="users-list clearfix">
              <ul class="users-list clearfix">
                  <li class="text-danger">COMMING SOON</li>
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
					<div class="container-fluid">
						<span class="panel-title">Edit Teacher</span>
						<!-- button that triggers modal -->
						<a role="button" class="pull-right" href="{{route('teachers.home')}}" title="teacher table">
							<span class="badge label-primary"><i class="glyphicon glyphicon-arrow-left"></i> </span>
						</a>
					</div>
					
				</div>
				<div class="panel-body">
					<form method="POST" action="/admin/teachers/update/{{$teacher->id}}">

              {{ csrf_field() }}
              {{-- this is required for every update request --}}
              <input type="hidden" name="_method" value="PUT" />

              <div class="row">
                  <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }} col-md-12">
                      <label for="first_name" class="control-label">First Name</label>

                      <input type="text" class="form-control" name="first_name" value="{{$teacher->first_name}}" id="first_name" required autofocus>

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

                      <input id="surname" type="text" class="form-control" name="surname" value="{{$teacher->surname}}" required autofocus>

                      @if ($errors->has('surname'))
                          <span class="help-block">
                              <strong>{{ $errors->first('surname') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="row">
                <div class="form-group{{ $errors->has('date_of_birth') ? ' has-error' : '' }} col-sm-12">
                  <label class="control-label">Date of Birth</label>
                  <input class="form-control date" name="date_of_birth" id="date_of_birth" value="{{$teacher->date_of_birth->format('m/d/Y')}}" required="">

                  @if ($errors->has('date_of_birth'))
                    <span class="help-block">
                      <strong>{{ $errors->first('date_of_birth') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="row">

                  <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }} col-md-6">
                      <label for="gender" class="control-label">Gender</label>

                      <select name="gender" class="form-control" required="">
                          @foreach($genders as $gender)
                            <option value="{{$gender}}" {{$gender === $teacher->gender ? 'selected=""': ''}}>{{$gender}}</option>
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

                      <input  data-inputmask='"mask": "(9999) 999-999"' phone-mask type="text" class="form-control" name="phone" value="{{$teacher->phone}}" required autofocus>

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

                      <input name="address" id="address" type="text" class="form-control"  value="{{$teacher->address}}" required autofocus>

                      @if ($errors->has('address'))
                          <span class="help-block">
                              <strong>{{ $errors->first('address') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="row">
                  <div class="form-group{{ $errors->has('qualification') ? ' has-error' : '' }} col-md-12">
                      <label for="relationship" class="control-label">Qualification</label>
                      <input type="text" name="qualification" class="form-control" value="{{$teacher->qualification}}">

                      @if ($errors->has('qualification'))
                          <span class="help-block">
                              <strong>{{ $errors->first('qualification') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="row">
                  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} col-md-6">
                      <label for="email" class="control-label">E-Mail Address</label>

                      <input id="email" type="email" class="form-control" name="email" value="{{$teacher->email}}">

                      @if ($errors->has('email'))
                          <span class="help-block">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                      @endif
                  </div>

                  <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }} col-md-6">
                      <label for="user_name" class="control-label">User Name</label>

                      <input id="user_name" type="text" class="form-control" name="user_name" value="{{$teacher->user_name}}">

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

              <div class="form-group">
                  <button type="submit" class="btn btn-info form-control">Update</button>
              </div>
          </form>
				</div>
			</div>
			<!-- /. close of panel div -->
		</div>
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