@extends('layouts.master')

@section('page-title', 'Edit Institution')

@section('page-css')
<!-- Animate css -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />

<!-- date picker -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header', 'Edit School Information')

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
  <li class="active treeview">
    <a href="#"><i class="fa fa-cogs"></i> <span>Settings</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="active"><a href="/institution"><i class="fa fa-edit"></i>Institution</a></li>
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
</ul>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">School Information</div>
                <div class="panel-body">
                    <form role="form"  method="POST" action="/institution/update/{{$institution->id}}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        {{-- this is required for every update request --}}                       
                        <input type="hidden" name="_method" value="PUT" />

                        <div class="row">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-12">
                                <label for="name" class="control-label">Name</label>

                                <input type="text" class="form-control" name="name" value="{{$institution->name}}" id="name" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group{{ $errors->has('date_established') ? ' has-error' : '' }} col-md-12">
                                <label for="date_established" class="control-label">Date Established</label>
                                <input id="date_established" type="text" class="form-control date" name="date_established" value="{{$institution->date_established->format('m/d/Y')}}" required autofocus>

                                @if ($errors->has('date_established'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date_established') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="row">

                            <div class="form-group{{ $errors->has('motto') ? ' has-error' : '' }} col-md-12">
                                <label for="motto" class="control-label">Motto</label>

                                <input type="text" class="form-control" name="motto" value="{{$institution->motto}}" required autofocus>

                                @if ($errors->has('motto'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('motto') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">

                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }} col-md-12">
                                <label for="phone" class="control-label">Phone Number</label>

                                <input data-inputmask='"mask": "(9999) 999-999"' data-mask id="phone" type="text" class="form-control" name="phone" value="{{$institution->phone}}" required autofocus>

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

                                <input name="address" id="address" type="text" class="form-control"  value="{{$institution->address}}" required autofocus>

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} col-md-12">
                                <label for="email" class="control-label">E-Mail Address</label>

                                <input id="email" type="email" class="form-control" name="email" value="{{$institution->email}}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }} col-md-12">
                                <label for="logo" class="control-label">Logo</label>

                                <input id="logo" type="file" class="form-control" name="logo" value="{{ old('email') }}" disabled="">
                                <span class="help-block">
                                    <strong class="text-warning">Sorry Institution logo upload feature isn't fully available yet.</strong>
                                </span>

                                @if ($errors->has('logo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('logo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success form-control">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header">
              <h3 class="widget-user-username">{{$institution->name}}</h3>
              <h5 class="widget-user-desc">{{$institution->address}}</h5>
            </div>
            <div class="widget-user-image">
                @if($institution->logo)
                    <img class="img-circle profile-user-img img-responsive" src="{{ asset("images/".$institution->logo) }}">
                @else
                    <img src="{{ asset("images/default-school.png") }}" class="img-circle" alt="User profile picture"/>
                @endif
            </div>
            <div class="box-footer bg-aqua-active">
              <div class="row">
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">{{$students_total}}</h5>
                    <span class="description-text">STUDENT</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">{{$teachers_total}}</h5>
                    <span class="description-text">TEACHERS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header">{{$institution->date_established->year}}</h5>
                    <span class="description-text">Year Est.</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <!-- /.col -->
    </div>

@endsection


@section('page-scripts')
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js") }}"></script>

    <script type="text/javascript">
        //Date picker
        $('#date_established').datepicker({
          autoclose: true
        });

        $("[data-mask]").inputmask();
    </script>

    @if($flash = session('message'))
        <script type="text/javascript">
            var message = "<b>{{$flash}}</b>!";
            notify(message);
        </script>
    @endif
@endsection
