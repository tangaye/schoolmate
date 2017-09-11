@extends('layouts.master')

@section('page-title', 'Guardian Student Term Report')

@section('meta')
	<meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('page-css')
	<!-- Animate css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header', 'Guardian Student Semester Report')

@section('guardian-navigation')
<!-- Sidebar Menu -->
<ul class="sidebar-menu">
  <li class="header">MAIN NAVIGATION</li>
  <!-- Optionally, you can add icons to the links -->
  <li>
    <a href="/home"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
    </a>
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
      <li><a href="/guardian/students/term"><i class="fa fa-file-text-o"></i>Term Report</a></li>
      <li class="active"><a href="/guardian/students/semester"><i class="fa fa-file-text-o"></i>Semester Report</a></li>
      <li><a href="#"><i class="fa fa-file-text-o"></i>Annual Report</a></li>
    </ul>
  </li>
</ul>
<!-- /.sidebar-menu -->
@endsection


@section('content')


	<div class="row">
		<div class="col-md-12">

			<!-- div to display errors returned by server-->
            <div class="errors alert hidden">
            </div>
            <!-- end of errors div -->

         	<div class="panel">
         		<div class="panel-body">
         			<div class="form-group">
         				<div class="input-group">
                        	<span class="input-group-addon">Students</span>
                        	<select id="student" class="search-fields form-control" name="student_id" class="form-control">
                        		<option value="" selected="">Select Student(s)</option>
		                  		@foreach($guardians as $guardian)
					                @foreach($guardian->student as $student)
					                	<option value="{{$student->id}}">{{$student->first_name}} {{$student->surname}}</option>
					                @endforeach
					            @endforeach
                        	</select>

	                  		<span class="input-group-addon">Semesters</span>
	                  		<select class="search-fields form-control" name="semester_id" class="form-control" id="semester">
                      			@foreach($semesters as $semester)
		                  			<option value="{{$semester->id}}">{{$semester->name}}</option>
		                  		@endforeach
	         				</select>
	         			</div>
	         		</div>
	         		<div id="result"></div>
	         	</div>
         	</div>
	    </div>
	</div>

@endsection

@section('page-scripts')
	<script type="text/javascript">

		$(document).ready(function() {

			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});

			$('.search-fields').on('change', function(event) {
		      	event.preventDefault();

		      	/* Act on the event */
		        var student = $('#student').val();
		        var semester = $('#semester').val();

		        if (student != '' && semester != '') {
		          $.ajax({
		          	url:"/guardian/students/semester",
		            method:"POST",
		           	data:{"student_id":student, "semester_id":semester},
		           	success:function(data){
		            	$("#result").html(data);
		           	}
		          });
		        } else {
		          $("#result").html('');

		        }   

		    });
		});

	</script>
@endsection