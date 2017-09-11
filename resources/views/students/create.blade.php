@extends('layouts.master')

@section('page-title', 'Create Student')

@section('meta')
	<meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('page-css')
<link href="{{ asset("/bower_components/AdminLTE/plugins/select2/select2.min.css") }}" rel="stylesheet" type="text/css" />

<!-- Animate css -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />

<!-- date picker -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header', 'Create Student')


@section('admin-navigation')
<!-- Sidebar Menu -->
<ul class="sidebar-menu">
  <li class="header">MAIN NAVIGATION</li>
  <!-- Optionally, you can add icons to the links -->
  <li class="">
    <a href="/home"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
    </a>
  </li>

  <!-- guardians -->
  <li><a href="/guardians"><i class="fa fa-user"></i> <span>Guardians</span></a></li>

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
      <li><a href="/students"><i class="glyphicon glyphicon-list-alt"></i>Student List</a></li>
      <li class="active"><a href="/students/create"><i class="fa fa-pencil"></i>Student Admission</a></li>
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
      <li><a href="/users"><i class="glyphicon glyphicon-list-alt"></i>User List</a></li>
      <li><a href="/register"><i class="fa fa-pencil"></i>Register User</a></li>
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

    @include ('layouts.errors')

	<div class="row">
		<div class="col-md-12">

			<div class="panel panel-default">
				<!-- Default panel contents -->
				<div class="panel-heading">
					<div class="container-fluid">
						<span class="panel-title">Enter Student Details</span>
						<!-- button that triggers modal -->
						<a role="button" href="/students" class="pull-right" title="students table">
							<span class="badge label-primary"><i class="glyphicon glyphicon-arrow-left"></i> </span>
						</a>
					</div>
					
				</div>
				<div class="panel-body">
                    <!-- start of form -->
					<form action="/students" method="POST" enctype="multipart/form-data">
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
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>		                                
                        </div>

                        <div class="row">
                            <div class="form-group{{ $errors->has('date_of_birth') ? ' has-error' : '' }} col-sm-6">
                            	<label for="datepicker" class="control-label">Date of Birth</label>
                            	<div class="input-group date">
                            		<span class="input-group-addon">
                            			<i class="fa fa-calendar-plus-o"></i>
                            		</span>
                            		<input class="form-control" id="datepicker" name="date_of_birth" required="required" value="{{ old('date_of_birth') }}">
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

                        <!-- contact information -->
                        <div class="form-group">
                    		<p>
                                <b>CONTACT DETAILS:</b>
                                <hr>
                            </p>
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
                            		<input id="phone" type="" name="phone" class="form-control" data-inputmask='"mask": "(9999) 999-999"' value="{{ old('phone') }}" data-mask>
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
                            		<input id="last_school" class="form-control" name="last_school" id="last_school" type="text" maxlength="100" value="{{ old('last_school') }}">
                            	</div>

                                @if ($errors->has('last_school'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_school') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('last_grade') ? ' has-error' : '' }} col-sm-6">
                            	<label for="last_grade" class="control-label">Last class</label>
								<select name="last_grade" id="last_grade" class="form-control" required="">
									@foreach($grades as $grade)
										<option value="{{$grade->id}}">{{$grade->name}}</option>
									@endforeach
								</select>
                            </div> 	
                            @if ($errors->has('last_grade'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('last_grade') }}</strong>
                                </span>
                            @endif
                        </div>

                        <!-- school information -->
                        <div class="form-group">
                    		<p>
                        		<b>School Information</b>
                        		<hr>
                        	</p>                        		
                    	</div>

                        <div class="row">
                        	<div class="form-group{{ $errors->has('student_type') ? ' has-error' : '' }} col-sm-6">
                        		<label id="type" class="control-label">Student Type</label>
                        		<select name="student_type" id="type" required="required" class="form-control">
									<option value="Old Student">Old Student</option>
									<option value="New Student">New Student</option>
								</select>

                                @if ($errors->has('student_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('student_type') }}</strong>
                                    </span>
                                @endif
                        	</div>

                            
                        	<div class="form-group{{ $errors->has('grade_id') ? ' has-error' : '' }} col-sm-6">
                        		<label id="grade" class="control-label">Class</label>
                        		<select name="grade_id" id="grade" class="form-control" required="">
									@foreach($grades as $grade)
										<option value="{{$grade->id}}">{{$grade->name}}</option>
									@endforeach
								</select>

                                @if ($errors->has('grade_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('grade_id') }}</strong>
                                    </span>
                                @endif
                        	</div>

                        </div>	

                        <!-- student photo -->
                        <div class="row">
                            <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }} photoWarning col-md-12">
                                <label class="control-label">Student Photo</label>
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
                        </div>

                        <!-- school information -->
                        <div class="form-group">
                            <p>
                                <b>Student Guardian</b>
                                <hr>
                            </p>                                
                        </div>
                        <div class="row">
                            <div class="form-group{{ $errors->has('guardian_id') ? ' has-error' : '' }} col-sm-12">
                                <label id="guardian" class="control-label">Guardian</label>
                                <select name="guardian_id" id="guardian" class="form-control guardians" style="width: 100%;" required="">
                                    <option>Select Guardian</option>
                                    @foreach($guardians as $guardian)
                                        <option value="{{$guardian->id}}">{{$guardian->first_name}} {{$guardian->surname}}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if ($errors->has('guardian_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('guardian_id') }}</strong>
                                </span>
                            @endif
                        </div>  
						<div class="row">
                            <div class="form-group col-md-12">
                                <input class="form-control btn btn-primary" type="submit" name="submit" value="Save">
                            </div>
                        </div>
					</form>
                    <!-- /. close of form -->
				</div>
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
        $('#datepicker').datepicker({
          autoclose: true
        });

        $("[data-mask]").inputmask();

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