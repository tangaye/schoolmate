@extends('layouts.master')

@section('page-title', 'Semester Report')

@section('page-header', 'Semester Report')

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
  <li class="active treeview">
    <a href="#">
      <i class="fa fa-folder-open-o"></i>
      <span>Scores Reports</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="/scores/report/terms"><i class="fa fa-file-text-o"></i><span>Term Report</span></a></li>
      <li class="active"><a href="/scores/report/semesters"><i class="fa fa-file-text-o"></i><span>Semester Report</span></a></li>
      <li><a href="{{route('annual-scores')}}"><i class="fa fa-file-text-o"></i><span>Annual Report</span></a></li>
    </ul>
  </li>
</ul>
@endsection


@section('content')


	<div class="row">
		<div class="col-md-12">

         	<div class="panel">
         		<div class="panel-body">
         			<div class="form-group">
         				<div class="input-group">
                	<span class="input-group-addon">Student Code</span>
                	<input class="form-control" type="text" maxlength="4" name="student_code" id="code" placeholder="Enter student code">

            		<span class="input-group-addon">Semester</span>
            		<select name="semester_id" class="form-control" id="semester">
              			@foreach($semesters as $semester)
              			<option value="{{$semester->id}}">{{$semester->name}}</option>
              		@endforeach
	         				</select>
	         			</div>
	         		</div>
	         		<div id="result">
                <div id="loading" class="text-center" style="display: none;">
                  <img src="{{ asset("images/Loading_icon.gif") }}" alt="loader">
                </div>   
              </div>
              <div>
                <button class="btn btn-primary print-btn" onclick="printReport('result')">
                 <i class="fa fa-print"></i> Print
                </button>
              </div>
	         	</div>
         	</div>
	    </div>
	</div>

@endsection

@section('page-scripts')
	<script type="text/javascript">

    function printReport (section){
        var printContent = document.getElementById(section);
        var WinPrint = window.open();

        WinPrint.document.write('<link rel="stylesheet" type="text/css" href="{{ asset("/css/app.css") }}">');
        WinPrint.document.write('<link rel="stylesheet" type="text/css" href="{{ asset("/css/media-print.css") }}" media="print">');
        WinPrint.document.write(printContent.innerHTML);
        WinPrint.document.write('<footer>Courtesy of <b>School</b>Mate</footer>');
        WinPrint.document.close();
        WinPrint.setTimeout(function(){
          WinPrint.focus();
          WinPrint.print();
          WinPrint.close();
        }, 1000);
    }


		$(document).ready(function() {

			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});
			
			$("#code").keyup(function(event){
				event.preventDefault();

          $(document).ajaxStart(function() {
            $("#loading").show();
          });

          $(document).ajaxStop(function() {
            $("#loading").hide();
          });

		        var code = $('#code').val();
		        var semester = $('#semester').val();

		        if (code != '' && code.length === 4) {
		          $.ajax({
		          	url:"/scores/report/semesters",
		            method:"POST",
		           	data:{"student_code":code, "semester_id":semester},
                success:function(data){
                  $("#result").html(data);
                },
                error:function() {
                  $('#result').html('There was an error. Please try again, if problem persits please contact adminstrator');
                }
		          });
		        } else {
		          $("#result").html('');

		        }   
		    });  

			$('#semester').on('change', function(event) {
		      	event.preventDefault();

            $(document).ajaxStart(function() {
              $("#loading").show();
            });

            $(document).ajaxStop(function() {
              $("#loading").hide();
            });

		      	/* Act on the event */
		        var code = $('#code').val();
		        var semester = $('#semester').val();

		        if (code != '' && code.length === 4) {
		          $.ajax({
		          	url:"/scores/report/semesters",
		            method:"POST",
		           	data:{"student_code":code, "semester_id":semester},
                success:function(data){
                  $("#result").html(data);
                },
                error:function() {
                  $('#result').html('There was an error. Please try again, if problem persits please contact adminstrator');
                }
		          });
		        } else {
		          $("#result").html('');

		        }   

		    });
		});

	</script>
@endsection