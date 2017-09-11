@extends('layouts.master')

@section('page-title', 'Scores')

@section('meta')
	<meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('page-css')
	<!-- Animate css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header', 'Scores')

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
      <li><a href="/users"><i class="glyphicon glyphicon-list-alt"></i>User List</a></li>
      <li><a href="/register"><i class="fa fa-pencil"></i>Register User</a></li>
    </ul>
  </li>

  <!-- score -->
  <li class="active treeview">
    <a href="#">
      <i class="fa fa-fax"></i><span>Scores</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="/scores"><i class="glyphicon glyphicon-list-alt"></i>Score Tables</a></li>
      <li class="active"><a href="/scores/master"><i class="fa fa-pencil"></i>Enter Score</a></li>
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
		<div class="col-md-12">

			<!-- div to display errors returned by server-->
            <div class="errors alert hidden">
            </div>
            <!-- end of errors div -->

         	<div class="panel">
         		<div class="panel-body">
         			<div class="form-group">
         				<div class="input-group">

         					<span class="input-group-addon">Subject</span>
                  			<select name="subject_id" id="subject" class="form-control search-field">
                  				<option value="">Select Subject</option>
                  				@foreach($subjects as $subject)
		                  			<option value="{{$subject->id}}">{{$subject->name}}</option>
		                  		@endforeach
                  			</select>
                  
	                  		<span class="input-group-addon">Grades/Class</span>
		                  	<select disabled="true" name="grade_id" class="form-control search-field" id="grade">
		                  		<option value="">Select Grade/Class</option>
		                  		@foreach($grades as $grade)
		                  			<option value="{{$grade->id}}">{{$grade->name}}</option>
		                  		@endforeach
		                  	</select>

	                  		<span class="input-group-addon">Term</span>
	                  		<select disabled="true" name="term_id" class="form-control search-field" id="term">
	                  			<option value="">Select term</option>
                      			@foreach($terms as $term)
		                  			<option value="{{$term->id}}">{{$term->name}}</option>
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

	<script src="{{ asset ("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.min.js") }}"></script>

	<script type="text/javascript">

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		
		$('.search-field').on('change', function(event) {
	      	event.preventDefault();

	      	// hide all errors
	      	$('.errors').addClass('hidden');

	      	/* Act on the event */
	        var subject = $('#subject').val();
	        var grade = $('#grade').val();
	        var term = $('#term').val();

	        if (subject != "") {
	        	$("#term").removeAttr('disabled');
	        	$("#grade").removeAttr('disabled');
	        	$("#result").html('');
	        } else {
	        	$("#term").val("");
	        	$("#grade").val("");
	        	$("#term").attr('disabled','disabled');
	        	$("#grade").attr('disabled','disabled');
	        	$("#result").html('');
	        }
	        if (grade != "" && term != "") {
	        	$.ajax({
	            url:"/scores/master/create",
	            method:"GET",
	            data:{"subject_id":subject, "grade_id":grade, "term_id":term},
	            dataType:"text",
	            success:function(data){
	              $("#result").html(data);
	            },
	            error:function(){
	              $("#result").html('There was an error please contact administrator');
	            }
	          });
	        } else {
	        	$("#result").html('');
	        }
	    });

	    $(document).on('click', '.save-score', function(event) {
	    	event.preventDefault();
	    	/* Act on the event */

	    	var student = $(this).parents('tr').find(".student").val();
	        var grade = $(this).parents('tr').find(".grade").val();
	        var subject = $(this).parents('tr').find(".subject").val();
	        var score = $(this).parents('tr').find(".score").val();
	        var term = $(this).parents('tr').find(".term").val();

	    	var row = $(this).parent("td").parent("tr");

	    	if (score >= 59 && score <= 100) {
	    		$.ajax({
		    		url: '/scores',
		    		type: 'POST',
		    		dataType: 'json',
		    		data: {"student_id":student, "grade_id":grade, "subject_id":subject, "term_id":term, "score":score},
		    	})
		    	.done(function(data) {
		    		console.log("success");
		    		if (data.errors) {
		        		$('.errors').removeClass('hidden');
		        		$('.errors').addClass('alert-danger');
		    			var errors = '';
		                for(datum in data.errors){
		                    errors += data.errors[datum] + '<br>';
		                }
		                $('.errors').show().html(errors); 
		            } 
		            else if (data.duplicate){
		            	$('.errors').removeClass('hidden');
		            	$('.errors').addClass('alert-warning');
		            	$('.errors').show().html(data.duplicate); 
		            }
		            else if (data.success){
		            	// fading out the record that was inserted
	                	jQuery(row).fadeOut('slow');

	                	// notify user
	                	big_notify(data.success);
		            }
		    	})
		    	.fail(function() {
		    		console.log("error");
		    		$('.errors').removeClass('hidden');
					$('.errors').show().html('An error occur. Please try again. If problem persists contact administrator'); 
		    	});
	    	} else {
	    		$('.errors').removeClass('hidden');
		       	$('.errors').addClass('alert-warning');
		       	$('.errors').show().html('The score should be between 59 - 100.'); 
	    	}

	    	
	    });
	</script>
@endsection