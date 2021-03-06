@extends('layouts.master')

@section('page-title', 'Edit Student')

@section('page-header', 'Edit Student')

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
  <li class="treeview">
    <a href="#"><i class="fa fa-user"></i> <span>Guardians</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{route('guardians.home')}}"><i class="glyphicon glyphicon-th-list"></i> <span>Guardians</span></a></li>
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
  <li class="active treeview">
    <a href="#">
      <i class="fa fa-users"></i><span>Students</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="active"><a href="{{route('students.home')}}"><i class="glyphicon glyphicon-list-alt"></i>Student List</a></li>
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

    <div class="col-md-3">
      <!-- Profile Image -->
      <div class="box box-primary">
          <div class="box-body box-profile">
              @if($student->photo)
                  <img src="{{ asset("images/".$student->photo) }}" class="profile-user-img img-responsive img-circle" alt="User profile picture"/>
              @else
                  <img src="{{ asset("images/default.png") }}" class="profile-user-img img-responsive img-circle" alt="User profile picture"/>
              @endif

              <h3 class="profile-username text-center">{{$student->full_name}}</h3>

              
              <ul class="list-group list-group-unbordered">
                  <li class="list-group-item">
                    <b>Age</b> <a class="pull-right">{{$student->age()}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Date Of Birth</b> <a class="pull-right">{{$student->date_of_birth->toFormattedDateString()}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Code</b> <a class="pull-right">{{$student->student_code}}</a>
                  </li>
              </ul>
          </div>
          <!-- /.box-body -->
      </div>
      <!-- /.box -->

      <!-- About Me Box -->
      <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Enrollment Details</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            @if($student->enrollments->where('academic_id', $current_academic->id)->count() > 0)
              @foreach($student->enrollments->where('academic_id', $current_academic->id) as $enrollment)

                <strong>Status</strong>

                <p class="text-muted">
                  @if($enrollment->enrollment_status == "Enrolled")
                    <span class="label label-success">{{$enrollment->enrollment_status}}</span>
                  @elseif($enrollment->enrollment_status == "Pending")
                    <span class="label label-info">{{$enrollment->enrollment_status}}</span>
                  @elseif($enrollment->enrollment_status == "Expelled")
                    <span class="label label-danger">{{$enrollment->enrollment_status}}</span>
                  @elseif($enrollment->enrollment_status == "Suspended")
                    <span class="label label-warning">{{$enrollment->enrollment_status}}</span>
                  @elseif($enrollment->enrollment_status == "Dropped")
                    <span class="label label-default">{{$enrollment->enrollment_status}}</span>
                  @endif
                </p>

                <hr style="margin-top: 0px; margin-bottom: 0px;">

                <strong> Last Grade</strong>

                <p class="text-muted">{{$enrollment->past_grade->name}}</p>

                <hr style="margin-top: 0px; margin-bottom: 0px;">

                <strong>Current Grade</strong>

                <p class="text-muted">{{$enrollment->present_grade->name}}</p>

                <hr style="margin-top: 0px; margin-bottom: 0px;">

                <strong>Student Type</strong>

                <p class="text-muted">{{$enrollment->student_type}}</p>
              @endforeach
            @else
              <p>Student is not enrolled for the current academic year.<p>
            @endif
          </div>
          <!-- /.box-body -->
      </div>
      <!-- /.box -->

      <!-- Widget: Student guardian -->
      <div class="box box-widget widget-user-2">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        @if($student->guardian)
            <div class="widget-user-header bg-yellow">
              <h3><a style="color: white;" href="/admin/guardians/edit/{{$student->guardian->id}}">{{$student->guardian->first_name}} {{$student->guardian->surname}}</a></h3>
              <h5>{{$student->guardian->relationship}}</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li>
                    <a href="javascript:void(0)">Phone
                        <span class="pull-right badge bg-blue">
                            {{$student->guardian->phone}}
                        </span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">Address 
                        <span class="pull-right badge bg-aqua">
                            {{$student->guardian->address}}
                        </span>
                    </a>
                </li>
              </ul>
            </div>
        @endif
      </div>
      <!-- /.widget-user -->
    </div>

		<div class="col-md-9">

			<div class="panel panel-default">

				<!-- Default panel contents -->
				<div class="panel-heading">
					<span class="panel-title">Edit Student</span>
				</div>

        <form method="POST" action="/students/update/{{$student->id}}" enctype="multipart/form-data">
  				<div class="panel-body">

  					{{csrf_field()}}

            {{-- this is required for every update request --}}                       
            <input type="hidden" name="_method" value="PUT" />
               
            <!-- personal information -->  
          	<div class="form-group">
          		<p>
                <b>PERSONAL INFOMATION:</b>
                <hr>
              </p>
          	</div>

            <div class="row">
                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }} col-sm-4">
                    <label for="" class="control-label">First Name</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        <input class="form-control" name="first_name" required="required" type="text" maxlength="45" value="{{$student->first_name}}">
                    </div>
                    @if ($errors->has('first_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </span>
                    @endif                   
                </div>
                <div class="form-group{{ $errors->has('middle_name') ? ' has-error' : '' }} col-sm-4">
                    <label for="" class="control-label">Middle Name</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        <input class="form-control" name="middle_name" type="text" maxlength="45" value="{{$student->middle_name}}">
                    </div>  
                    @if ($errors->has('middle_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </span>
                    @endif   
                </div>
                <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }} col-sm-4">
                    <label for="surname" class="control-label">Surname</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        <input class="form-control" id="surname" name="surname" required="required" type="text" maxlength="45" value="{{$student->surname}}">
                    </div>

                    @if ($errors->has('surname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('surname') }}</strong>
                        </span>
                    @endif
                </div>                                      
            </div>

            <div class="row">
                <div class="form-group{{ $errors->has('date_of_birth') ? ' has-error' : '' }} col-sm-6">
                    <label class="control-label">Date of Birth</label>
                    <div class="input-group date">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar-plus-o"></i>
                        </span>
                        <input class="form-control datepicker" name="date_of_birth" required="required" value="{{$student->date_of_birth->format('m/d/Y')}}">
                    </div>

                    @if ($errors->has('date_of_birth'))
                        <span class="help-block">
                            <strong>{{ $errors->first('date_of_birth') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }} col-sm-6">
                    <label for="" class="control-label">Gender</label>
                    <select name="gender" class="form-control" required="">
                        @foreach($genders as $gender)
                            <option value="{{$gender}}" {{$student->gender === $gender ? 'selected' : ''}}>{{$gender}}</option>
                        @endforeach
                    </select>
                </div>
                @if ($errors->has('gender'))
                    <span class="help-block">
                        <strong>{{ $errors->first('gender') }}</strong>
                    </span>
                @endif
            </div>

            <div class="row"> 
                <div class="form-group{{ $errors->has('county') ? ' has-error' : '' }} col-sm-6">
                    <label for="county">County</label>
                    <select name="county" id="county" class="form-control">
                        @foreach($counties as $name => $value)
                            <option value="{{$value}}" {{$student->county === $value ? 'selected' : ''}}>{{$name}}</option>
                        @endforeach
                    </select>
                </div>
                 @if ($errors->has('county'))
                    <span class="help-block">
                        <strong>{{ $errors->first('county') }}</strong>
                    </span>
                @endif

                <div class="form-group{{ $errors->has('religion') ? ' has-error' : '' }} col-sm-6">
                    <label for="religion" class="control-label">Religion</label>
                    <select class="form-control" name="religion" id="religion">
                        @foreach($religions as $name => $value)
                            <option value="{{$value}}" {{$student->religion === $value ? 'selected' : ''}}>{{$name}}</option>
                        @endforeach
                    </select>
                </div>
                @if ($errors->has('religion'))
                    <span class="help-block">
                        <strong>{{ $errors->first('religion') }}</strong>
                    </span>
                @endif
            </div>

            <div class="row">
                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }} col-sm-12 col-md-12 col-xs-12">
                    <label for="address" class="control-label">Address</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-home"></i>
                        </span>
                        <input id="address" type="text" class="form-control" name="address" value="{{$student->address}}">
                    </div>
                    @if ($errors->has('address'))
                        <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }} col-sm-6">
                    <label class="control-label">Phone</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-phone"></i>
                        </span>
                        <input type="" name="phone" class="form-control" data-inputmask='"mask": "(9999) 999-999"' value="{{$student->phone}}" phone-mask>
                    </div>
                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }} col-sm-6">
                    <label for="country" class="control-label">Country</label>
                    <input type="text" id="country" name="country" value="{{$student->country}}" class="form-control" required="">

                    @if ($errors->has('country'))
                        <span class="help-block">
                            <strong>{{ $errors->first('country') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <!-- family information -->
            <div class="form-group">
              <p>
                <b>PARENTS INFORMATION</b>
                <hr>
              </p>                            
            </div>

            <div class="row">
              <div class="form-group{{ $errors->has('father_name') ? ' has-error' : '' }} col-sm-4">
                <label for="" class="control-label">Father Name</label>
                <input class="form-control" name="father_name" required="required" type="text" maxlength="255" value="{{$student->father_name}}">
                  @if ($errors->has('father_name'))
                      <span class="help-block">
                          <strong>{{ $errors->first('father_name') }}</strong>
                      </span>
                  @endif                   
              </div>
              <div class="form-group{{ $errors->has('father_address') ? ' has-error' : '' }} col-sm-4">
                <label for="" class="control-label">Father Address</label>
                <input class="form-control" name="father_address" required="required" type="text" maxlength="255" value="{{$student->father_address }}">
                  @if ($errors->has('father_address'))
                      <span class="help-block">
                          <strong>{{ $errors->first('father_address') }}</strong>
                      </span>
                  @endif                   
              </div>
              <div class="form-group{{ $errors->has('father_number') ? ' has-error' : '' }} col-sm-4">
                <label for="" class="control-label">Father Contact #</label>
                <input class="form-control" name="father_number" required="required" type="text" data-inputmask='"mask": "(9999) 999-999"' value="{{$student->father_number }}" phone-mask>
                  @if ($errors->has('father_number'))
                      <span class="help-block">
                          <strong>{{ $errors->first('father_number') }}</strong>
                      </span>
                  @endif                   
              </div>
            </div>

            <div class="row">
              <div class="form-group{{ $errors->has('mother_name') ? ' has-error' : '' }} col-sm-4">
                <label for="" class="control-label">Mother Name</label>
                <input class="form-control" name="mother_name" required="required" type="text" maxlength="255" value="{{$student->mother_name}}">
                  @if ($errors->has('mother_name'))
                      <span class="help-block">
                          <strong>{{ $errors->first('mother_name') }}</strong>
                      </span>
                  @endif                   
              </div>
              <div class="form-group{{ $errors->has('mother_address') ? ' has-error' : '' }} col-sm-4">
                <label for="" class="control-label">Mother Address</label>
                <input class="form-control" name="mother_address" required="required" type="text" maxlength="255" value="{{$student->mother_address }}">
                  @if ($errors->has('mother_address'))
                      <span class="help-block">
                          <strong>{{ $errors->first('mother_address') }}</strong>
                      </span>
                  @endif                   
              </div>
              <div class="form-group{{ $errors->has('mother_number') ? ' has-error' : '' }} col-sm-4">
                <label for="" class="control-label">Mother Contact #</label>
                <input class="form-control" name="mother_number" required="required" type="text" data-inputmask='"mask": "(9999) 999-999"' value="{{$student->mother_number }}" phone-mask>
                  @if ($errors->has('mother_number'))
                      <span class="help-block">
                          <strong>{{ $errors->first('mother_number') }}</strong>
                      </span>
                  @endif                   
              </div>
            </div>

            <!-- previous qualification section -->
            <div class="form-group">
                <p>
                    <b>PREVIOUS QUALIFICATION:</b>
                    <hr>
                </p>    
            </div>

            <div class="row">
                <div class="form-group{{ $errors->has('last_school') ? ' has-error' : '' }} col-sm-6">
                    <label for="last_school" class="control-label">Last school attended</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-institution"></i>
                        </span>
                        <input id="last_school" class="form-control" name="last_school" id="last_school" type="text" maxlength="255" value="{{$student->last_school}}">
                    </div>

                    @if ($errors->has('last_school'))
                        <span class="help-block">
                            <strong>{{ $errors->first('last_school') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('last_school_address') ? ' has-error' : '' }} col-sm-6">
                  <label class="control-label">Last School Address</label>
                  <input class="form-control" name="last_school_address" id="last_school_address" type="text" maxlength="255" value="{{$student->last_school_address}}">

                    @if ($errors->has('last_school_address'))
                        <span class="help-block">
                            <strong>{{ $errors->first('last_school_address') }}</strong>
                        </span>
                    @endif
                </div>                   
            </div>

            <div class="row">
              <div class="form-group{{ $errors->has('principal_name') ? ' has-error' : '' }} col-sm-6">
                <label class="control-label">Principal Name</label>
                <input  class="form-control" name="principal_name" id="principal_name" type="text" maxlength="255" required="" value="{{$student->principal_name}}">

                  @if ($errors->has('principal_name'))
                      <span class="help-block">
                          <strong>{{ $errors->first('principal_name') }}</strong>
                      </span>
                  @endif
              </div>

              <div class="form-group{{ $errors->has('principal_number') ? ' has-error' : '' }} col-sm-6">
                <label class="control-label">Principal Contact #</label>
                <input class="form-control" name="principal_number" id="principal_number" data-inputmask='"mask": "(9999) 999-999"' phone-mask value="{{$student->principal_number}}">

                  @if ($errors->has('principal_number'))
                      <span class="help-block">
                          <strong>{{ $errors->first('principal_number') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

            <div class="form-group">
              <p>
                <b></b>
                <hr>
              </p>                                
            </div>

            <!-- student photo -->
            <div class="row">
                <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }} photoWarning col-md-6">
                    <label class="control-label">Update Student Photo</label>
                    <input type="file" class="form-control photo" name="photo">

                    @if ($errors->has('photo'))
                        <span class="help-block">
                            <strong>{{ $errors->first('photo') }}</strong>
                        </span>
                    @endif

                    <span class="help-block hidden photoWarningMsg">
                        <strong class="photoWarningMsg"></strong>
                    </span>
                </div>

                <div class="form-group{{ $errors->has('admission_date') ? ' has-error' : '' }} col-md-6">
                  <label class="control-label">Admission Date</label>
                  <div class="input-group date">
                    <span class="input-group-addon">
                      <i class="fa fa-calendar-plus-o"></i>
                    </span>
                    <input class="form-control datepicker" name="admission_date" required="required" value="{{$student->admission_date->format('m/d/Y')}}">
                  </div>

                    @if ($errors->has('admission_date'))
                        <span class="help-block">
                            <strong>{{ $errors->first('admission_date') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="row">
                <div class="form-group{{ $errors->has('guardian_id') ? ' has-error' : '' }} col-sm-12">
                    <label id="guardian" class="control-label">Guardian</label>
                    <select name="guardian_id" id="guardian" class="form-control guardians" style="width: 100%;" required="">
                        <option value="">None Selected(Please Select Guardian)</option>
                        @foreach($guardians as $guardian)
                            <option value="{{$guardian->id}}" {{$guardian->id == $student->guardian->id ? 'selected' : ''}}>{{$guardian->first_name}} {{$guardian->surname}}</option>
                        @endforeach
                    </select>
                </div>

                @if ($errors->has('guardian_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('guardian_id') }}</strong>
                    </span>
                @endif
            </div>  					
  				</div>
          <div class="panel-footer text-right">
            <button type="submit" name="update" class="btn btn-success">Update</button> &nbsp;
            <a href="{{route('students.home')}}" class="btn btn-default">Cancel</a>
          </div>
        </form>
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
        $('.datepicker').datepicker({
          autoclose: true
        });

        $("[phone-mask]").inputmask();

        // check if student picture is greater than 2mb
        // If it is avoid upload of such large file by 
        // removing the image choosen by the user
        // and display an warning message
        $('.photo').on('change', function(event) {
            event.preventDefault();
            /* Act on the event */

            var PhotoSize = this.files[0].size/1024/1024// in MB

            if (PhotoSize > 2) {
                $('.photoWarning').addClass('has-warning');
                $('.photoWarningMsg').removeClass('hidden');
                $('.photoWarningMsg').html('Please choose an image less than 2mb.');
                $('.photo').val(null);
               // $(file).val(''); //for clearing with Jquery
            } else {
                $('.photoWarning').removeClass('has-warning');
                $('.photoWarningMsg').addClass('hidden');
                $('.photoWarningMsg').html(null);
            }
        });
    </script>
@endsection