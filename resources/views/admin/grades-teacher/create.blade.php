@extends('layouts.master')

@section('page-title', 'Creat Grades Teacher')

@section('page-css')
	<!-- Animate css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
	<!-- swal alert css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.css") }}" rel="stylesheet" type="text/css" />
	<!-- datatables -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css") }}" rel="stylesheet" type="text/css" />
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

  <!-- teachres -->
  <li class="treeview active">
    <a href="#"><i class="glyphicon glyphicon-education"></i> <span>Teachers</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{route('teachers.home')}}"><i class="glyphicon glyphicon-th-list"></i> <span>Teachers</span></a></li>
      <li><a href="{{route('teachers.form')}}"><i class="fa fa-pencil"></i>New Teacher</a></li>
      <li><a href="{{route('admin-gradesTeacher.home')}}"><i class="glyphicon glyphicon-asterisk"></i>Teacher Grades</a></li>
      <li class="active"><a href="{{route('admin-gradesTeacher.form')}}"><i class="fa fa-pencil"></i>New Teacher Grade</a></li>
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
		<div class="col-md-10 col-md-offset-1">

			@include('layouts.custom-errors')

			<div class="panel panel-default">
				<div class="panel-heading">
          <div class="container-fluid">
            <span class="panel-title">Assigned Subjects and Grades to Teacher</span>

            <a class="btn btn-primary pull-right btn-sm" title="Back" data-toggle="title" onclick="history.back()" href="javascript:void(0)">
              <i class="glyphicon glyphicon-arrow-left"></i> Back
            </a>
          </div>
        </div>

				<div class="panel-body">
					<!-- Table -->
					<form class="form-horizontal" method="POST" action="{{ route('admin-gradesTeacher.submit') }}">

			              {{ csrf_field() }}

			              <div class="form-group{{ $errors->has('teacher_id') ? ' has-error' : '' }}">
			                  <label for="teacher_id" class="col-md-2 control-label">Teacher</label>

			                  <div class="col-md-8">
			                  	<select name="teacher_id" id="teacher_id" class="form-control" value="{{ old('teacher_id') }}" required="">
			                  		@foreach($teachers as $teacher)
			                  			<option value="{{$teacher->id}}">{{$teacher->first_name}} {{$teacher->surname}}</option>
			                  		@endforeach
			                  	</select>

			                      @if ($errors->has('name'))
			                          <span class="help-block">
			                              <strong>{{ $errors->first('name') }}</strong>
			                          </span>
			                      @endif
			                  </div>
			              </div>

			              <div class="form-group{{ $errors->has('grade_id') ? ' has-error' : '' }} gradeWarning">
			                  <label for="name" class="col-md-2 control-label">Grades/Classes</label>

			                  <div class="col-md-8">
			                  	<select name="grade_id" id="grade_id" class="form-control" required="">
			                  		<option selected="" value="">Select Grade</option>
			                  		@foreach($grades as $grade)
			                  			<option value="{{$grade->id}}">{{$grade->name}}</option>
			                  		@endforeach
			                  	</select>

			                      @if ($errors->has('grade_id'))
			                          <span class="help-block">
			                              <strong>{{ $errors->first('grade_id') }}</strong>
			                          </span>
			                      @endif

			                       <span class="help-block hidden gradeWarningMsg">
				                        <strong class="gradeWarningMsg"></strong>
				                    </span>
			                  </div>
			              </div>

			              <div class="form-group{{ $errors->has('subject_id') ? ' has-error' : '' }}">
			                  <label class="col-md-2 control-label">Subjects</label>

			                  <div class="col-md-8">
			               		<select disabled="" name="subject_id" id="subject_id" class="form-control" required=""></select>
			                      @if ($errors->has('subject_id'))
			                          <span class="help-block">
			                              <strong>{{ $errors->first('subject_id') }}</strong>
			                          </span>
			                      @endif
			                  </div>
			              </div>

			            <div class="form-group">
			                  <div class="col-md-4 col-md-offset-2">
			                      <button disabled="" type="submit" class="btn btn-primary btn-assign">
			                          Assign
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

<script type="text/javascript">
	$(document).on('change', '#grade_id', function(event) {
		event.preventDefault();
		
		 var id = $('#grade_id').val();
		 if (id != "") {

	        $.get('/grades/grade-subjects/'+id)
	        .done(function (data) {
	        	if (data.length == 0) {
	        		$('.gradeWarning').addClass('has-warning');
	                $('.gradeWarningMsg').removeClass('hidden');
	                $('.gradeWarningMsg').html('No subjects found for the grade selected.');

	                $("#subject_id").val(null);
	                $("#subject_id").attr('disabled', true);
	                $(".btn-assign").attr('disabled', true);
	        		console.log('No data');
	        	} else {
	        		$('.gradeWarning').removeClass('has-warning');
	                $('.gradeWarningMsg').addClass('hidden');
	                $('.gradeWarningMsg').html(null);

	        		$('select[name="subject_id"]').empty();
		          	$.each(data, function(key, value) {
		            	$('select[name="subject_id"]').append('<option value="'+ key +'">'+ value +'</option>');
		          	});
		          	$("#subject_id").removeAttr('disabled');
		          	$(".btn-assign").removeAttr('disabled');
	        		console.log('Data found');
	        	}
	        })
	        .fail(function (data) {
	          // body...
	          	$('.gradeWarning').addClass('has-warning');
	            $('.gradeWarningMsg').removeClass('hidden');
	            $('.gradeWarningMsg').html('There was an error please contact administrator');
	          	$("#subject_id").attr('disabled',true);
	          	$(".btn-assign").attr('disabled', true);
	        });

	      } else {
	      	$("#subject_id").val(null);
	        $("#subject_id").attr('disabled', true);
	        $(".btn-assign").attr('disabled', true);
	      }
	});
</script>
@if($flash = session('message'))
    <script type="text/javascript">
        var message = "{!!html_entity_decode($flash)!!}";
        notify(message);
    </script>
@endif
@endsection