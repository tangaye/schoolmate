@extends('layouts.master')

@section('page-title', 'Create Student')

@section('page-css')
<link href="{{ asset("/bower_components/AdminLTE/plugins/select2/select2.min.css") }}" rel="stylesheet" type="text/css" />

<!-- Animate css -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />

<!-- date picker -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header', 'Create Student')

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
      <li><a href="{{route('students.home')}}"><i class="glyphicon glyphicon-list-alt"></i>Student List</a></li>
      <li class="active"><a href="{{route('students.create')}}"><i class="glyphicon glyphicon-pencil"></i>Student Admission</a></li>
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

    @include ('layouts.errors')

	<div class="row">
		<div class="col-md-12">

			<div class="panel panel-default">
				<!-- Default panel contents -->
				<div class="panel-heading">
					<span class="panel-title">Enter Student Details</span>
				</div>
				
        <form action="/students" method="POST" enctype="multipart/form-data">
  				<div class="panel-body">
  						{{csrf_field()}}
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
                  		<input class="form-control" name="first_name" required="required" type="text" maxlength="45" value="{{ old('first_name') }}">
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
                  		<input class="form-control" name="middle_name" type="text" maxlength="45" value="{{ old('middle_name') }}">
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
                  		<input class="form-control" id="surname" name="surname" required="required" type="text" maxlength="45" value="{{ old('surname') }}">
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
                  	<label  class="control-label">Date of Birth</label>
                  	<div class="input-group date">
                  		<span class="input-group-addon">
                  			<i class="fa fa-calendar-plus-o"></i>
                  		</span>
                  		<input class="form-control datepicker" name="date_of_birth" required="required" value="{{ old('date_of_birth') }}">
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
                  		<option value="Female">Female</option>
                  		<option value="Male">Male</option>
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
                              <option value="{{$value}}">{{$name}}</option>
                          @endforeach
  		              </select>

                      @if ($errors->has('county'))
                          <span class="help-block">
                              <strong>{{ $errors->first('county') }}</strong>
                          </span>
                      @endif
                  </div>
                  

                  <div class="form-group{{ $errors->has('religion') ? ' has-error' : '' }} col-sm-6">
                  	<label for="religion" class="control-label">Religion</label>
                  	<select class="form-control" name="religion" id="religion">
                          @foreach($religions as $name => $value)
                              <option value="{{$value}}">{{$name}}</option>
                          @endforeach
                  	</select>
                      @if ($errors->has('religion'))
                          <span class="help-block">
                              <strong>{{ $errors->first('religion') }}</strong>
                          </span>
                      @endif
                  </div>
                  
              </div>

              <div class="row">
              	<div class="form-group{{ $errors->has('address') ? ' has-error' : '' }} col-sm-12 col-md-12 col-xs-12">
              		<label for="address" class="control-label">Address</label>
              		<div class="input-group">
                  		<span class="input-group-addon">
                  			<i class="fa fa-home"></i>
                  		</span>
                          <input id="address" value="{{old('address')}}" type="text" class="form-control" name="address" value="{{ old('address') }}">
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
              		<label for="phone" class="control-label">Phone</label>
              		<div class="input-group">
                  		<span class="input-group-addon">
                  			<i class="fa fa-phone"></i>
                  		</span>
                  		<input id="phone" type="" name="phone" class="form-control" data-inputmask='"mask": "(9999) 999-999"' value="{{ old('phone') }}" phone-mask>
                  	</div>
                      @if ($errors->has('phone'))
                          <span class="help-block">
                              <strong>{{ $errors->first('phone') }}</strong>
                          </span>
                      @endif
              	</div>
              	<div class="form-group{{ $errors->has('country') ? ' has-error' : '' }} col-sm-6">
              		<label for="country" class="control-label">Country</label>
              		<input type="text" id="country" name="country" value="{{old('country')}}" class="form-control" required="">

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
                  <input class="form-control" name="father_name" required="required" type="text" maxlength="255" value="{{ old('father_name') }}">
                    @if ($errors->has('father_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('father_name') }}</strong>
                        </span>
                    @endif                   
                </div>
                <div class="form-group{{ $errors->has('father_address') ? ' has-error' : '' }} col-sm-4">
                  <label for="" class="control-label">Father Address</label>
                  <input class="form-control" name="father_address" required="required" type="text" maxlength="255" value="{{ old('father_address') }}">
                    @if ($errors->has('father_address'))
                        <span class="help-block">
                            <strong>{{ $errors->first('father_address') }}</strong>
                        </span>
                    @endif                   
                </div>
                <div class="form-group{{ $errors->has('father_number') ? ' has-error' : '' }} col-sm-4">
                  <label for="" class="control-label">Father Contact #</label>
                  <input class="form-control" name="father_number" required="required" type="text" data-inputmask='"mask": "(9999) 999-999"' value="{{ old('father_number') }}" phone-mask>
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
                  <input class="form-control" name="mother_name" required="required" type="text" maxlength="255" value="{{ old('mother_name') }}">
                    @if ($errors->has('mother_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('mother_name') }}</strong>
                        </span>
                    @endif                   
                </div>
                <div class="form-group{{ $errors->has('mother_address') ? ' has-error' : '' }} col-sm-4">
                  <label for="" class="control-label">Mother Address</label>
                  <input class="form-control" name="mother_address" required="required" type="text" maxlength="255" value="{{ old('mother_address') }}">
                    @if ($errors->has('mother_address'))
                        <span class="help-block">
                            <strong>{{ $errors->first('mother_address') }}</strong>
                        </span>
                    @endif                   
                </div>
                <div class="form-group{{ $errors->has('mother_number') ? ' has-error' : '' }} col-sm-4">
                  <label for="" class="control-label">Mother Contact #</label>
                  <input class="form-control" name="mother_number" required="required" type="text" data-inputmask='"mask": "(9999) 999-999"' value="{{ old('mother_number') }}" phone-mask>
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
                  	<label for="last_school" class="control-label">Last School Attended</label>
                  	<div class="input-group">
                  		<span class="input-group-addon">
                  			<i class="fa fa-institution"></i>
                  		</span>
                  		<input  class="form-control" name="last_school" id="last_school" type="text" maxlength="255" value="{{ old('last_school') }}">
                  	</div>

                      @if ($errors->has('last_school'))
                          <span class="help-block">
                              <strong>{{ $errors->first('last_school') }}</strong>
                          </span>
                      @endif
                  </div>

                  <div class="form-group{{ $errors->has('last_school_address') ? ' has-error' : '' }} col-sm-6">
                    <label class="control-label">Last School Address</label>
                    <input class="form-control" name="last_school_address" id="last_school_address" type="text" maxlength="255" value="{{ old('last_school_address') }}">

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
                    <input  class="form-control" name="principal_name" id="principal_name" type="text" maxlength="255" required="" value="{{ old('principal_name') }}">

                      @if ($errors->has('principal_name'))
                          <span class="help-block">
                              <strong>{{ $errors->first('principal_name') }}</strong>
                          </span>
                      @endif
                  </div>

                  <div class="form-group{{ $errors->has('principal_number') ? ' has-error' : '' }} col-sm-6">
                    <label class="control-label">Principal Contact #</label>
                    <input class="form-control" name="principal_number" id="principal_number" data-inputmask='"mask": "(9999) 999-999"' phone-mask value="{{ old('principal_number') }}">

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
                      <label class="control-label">Student Photo</label>
                      <input type="file" class="form-control photo" name="photo" disabled="true">

                      @if ($errors->has('photo'))
                          <span class="help-block">
                              <strong>{{ $errors->first('photo') }}</strong>
                          </span>
                      @endif

                      <span class="help-block hidden photoWarningMsg">
                          <strong class="photoWarningMsg"></strong>
                      </span>
                      <span class="help-block">
                          <strong class="text-warning">Sorry the Student photo upload feature isn't fully available yet.</strong>
                      </span>
                  </div>

                  <div class="form-group{{ $errors->has('admission_date') ? ' has-error' : '' }} col-md-6">
                    <label class="control-label">Admission Date</label>
                    <div class="input-group date">
                      <span class="input-group-addon">
                        <i class="fa fa-calendar-plus-o"></i>
                      </span>
                      <input class="form-control datepicker" name="admission_date" required="required" value="{{ old('admission_date') }}">
                    </div>

                      @if ($errors->has('admission_date'))
                          <span class="help-block">
                              <strong>{{ $errors->first('admission_date') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <!-- student guardian -->
              <div class="row">
                  <div class="form-group{{ $errors->has('guardian_id') ? ' has-error' : '' }} col-sm-12">
                      <label id="guardian" class="control-label">Student Guardian</label>
                      <select name="guardian_id" id="guardian" class="form-control guardians" style="width: 100%;" required="">
                          <option value="" selected="">Select Guardian</option>
                          @foreach($guardians as $guardian)
                              <option value="{{$guardian->id}}">{{$guardian->first_name}} {{$guardian->surname}}</option>
                          @endforeach
                      </select>


                    @if ($errors->has('guardian_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('guardian_id') }}</strong>
                        </span>
                    @endif
                  </div>

              </div>  
  				</div>
          <div class="panel-footer text-right">
            <button type="submit" name="submit" class="btn btn-primary">Admit Student</button> &nbsp;
            <a href="{{route('students.home')}}" class="btn btn-default">Cancel</a>
          </div>
        </form>
			</div>
			<!-- /. close of panel div -->
		</div>
	</div>

@endsection


@section('page-scripts')
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/select2/select2.full.min.js") }}"></script>

    <script src="{{ asset ("/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js") }}"></script>

    <script type="text/javascript">
        //Initialize Select2 Elements
        $(".guardians").select2();

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

    @if($flash = session('message'))
        <script type="text/javascript">
            var message = "Student <b>{{$flash}}</b> save!";
            notify(message);
        </script>
    @endif
@endsection