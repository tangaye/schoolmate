@extends('layouts.master')

@section('page-title', 'Score Tables')

@section('meta')
	<meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('page-css')
	<!-- Animate css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
	<!-- swal alert css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.css") }}" rel="stylesheet" type="text/css" />
	<!-- datatables -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header', 'Score Tables')

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
  <li class="active treeview">
    <a href="#">
      <i class="fa fa-fax"></i><span>Scores</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="active"><a href="/scores"><i class="glyphicon glyphicon-list-alt"></i>Score Tables</a></li>
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

	
	<!-- edit score modal form start -->
	@include('scores.edit')
	<!-- edit score modal form end -->

	<div class="row">
		<div class="col-md-12">

         	<div class="panel">
         		<div class="panel-body">
         			<div class="form-group">
         				<div class="input-group">
	                  		<span class="input-group-addon">Term</span>
	                  		<select name="term_id" class="form-control" id="term">
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


	<script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js") }}"></script>
	<script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>

	<script type="text/javascript">

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		
		$('#term').on('change', function(event) {
	      	event.preventDefault();

	      	// hide all errors
	      	$('.errors').addClass('hidden');

	        var term = $('#term').val();

	        if (term != "") {
	        	$.ajax({
		            url:"/scores/terms",
		            method:"GET",
		            data:{"term_id":term},
		            success:function(data){
		              $("#result").html(data);
		              $('#term-table').DataTable();
		            },
		            error:function(){
		              $("#result").html('There was an error please contact administrator');
		            }
		        });
	        } else {
	        	$("#result").html('');
	        }
	    });

	    // prepare edit modal
		$(document).on('click', '.edit-score', function(event) {
			event.preventDefault();
			/* Act on the event */
			// hide all errors

			// set the hidden score id
			$('#score-id').val($(this).data('id'));

			// set the hidden student id
			$('#student-id').val($(this).data('studentid'));

			// set the hidden subject id
			$('#subject-id').val($(this).data('subjectid'));

			// set the hidden grade/class id
			$('#grade-id').val($(this).data('gradeid'));

			// set the hidden student id
			$('#term-id').val($(this).data('termid'));

			//setting the student name
			$('#edit-name').val($(this).data('name'));

			// setting the subject name
			$('#edit-subject').val($(this).data('subject'));

			// setting the grade/class name
			$('#edit-grade').val($(this).data('grade'));

			// setting the student score
			$('#edit-score').val($(this).data('score'));

			// subject to be edited id
			var id = $(this).attr('data-id');

			$('.name-error').addClass('hidden');
			$('.errors').addClass('hidden');


			// display the add modal
			$('#edit-modal').modal({
				show: true,
				backdrop:'static',
				keyboard:false
			});
		});

		// update student score
		$(document).on('click', '#update-score', function(event) {
			event.preventDefault();
			/* Act on the event */

			// getting the score id to be updated
			var id = $('#score-id').val();
			var score = $("#edit-score").val();

			if (score >= 59 && score <= 100){
				$.ajax({
					url: '/scores/terms/update/'+id,
					type: 'PUT',
					data: $("#score-form").serialize(),
				})
				.done(function(data) {

					// if the validator bag returns error display error in modal
					if (data.errors) {
		        		$('.errors').removeClass('hidden');
		    			var errors = '';
		                for(datum in data.errors){
		                    errors += data.errors[datum] + '<br>';
		                }
		                $('.errors').show().html(errors); 

		            } else if (data.success){
		            	// reset the form
		            	$("#edit-modal").modal('hide');

		            	var score_id = data.score[0].id;
		            	var student_id = data.score[0].student_id;
		            	var subject_id = data.score[0].subject_id;
		            	var grade_id = data.score[0].grade_id;
		            	var term_id = data.score[0].term_id;

		            	var name  = data.score[0].student.first_name+" "+data.score[0].student.surname;
		            	var subject = data.score[0].subject.name;
		            	var grade = data.score[0].grade.name;
		            	var score = data.score[0].score;
		            	var term = data.score[0].term.name;

		            	// prepare row of grade details to append to table
		            	var row = '<tr class="score'+score_id+'">';

		            		row += '<td>'+name+'</td>';
		            		row += '<td>'+grade+'</td>';
		            		row += '<td>'+subject+'</td>';
		            		row += '<td>'+term+'</td>';
		            		if (score <= 69) {
		            			row += '<td style="color:red;">'+score+'</td>';
		            		} else {
		            			row += '<td>'+score+'</td>';
		            		}

		            		row += '<td><a class="edit-score" data-id="'+score_id+'" data-name="'+name+'" data-grade="'+grade+'" data-subject="'+subject+'" data-score="'+score+'" data-studentid="'+student_id+'" data-gradeid="'+grade_id+'" data-subjectid="'+subject_id+'" data-termid="'+term_id+'" data-toggle="tooltip" title="Edit" href="#" role="button"><i class="glyphicon glyphicon-edit text-info"></i></a>  &nbsp;';

		            		row += '<a class="delete-score" data-id="'+score_id+'" data-toggle="tooltip" title="Delete" href="#" role="button"><i class="glyphicon glyphicon-trash text-danger"></i></a></td>';

		            	row += '</tr>';
				
						// replace subject row with updated details of subject
				        $(".score" + score_id).replaceWith(row);

		            	// notify user
		            	big_notify(data.success);
		            } 
		        
				})
				.fail(function(data) {
					console.log("error");
					$('.errors').removeClass('hidden');
		    		$('.errors').text('There was an error. Please try again, and if error persits contact administrator');
				});
			} else {
				$('.errors').removeClass('hidden');
		       	$('.errors').addClass('alert-warning');
		       	$('.errors').show().html('The score should be between 59 - 100.'); 
			}
		});

		$(document).on('click', '.delete-score', function(event) {
			event.preventDefault();
			/* Act on the event */

			// id of the row to be deleted
			var id = $(this).attr('data-id');

		    // row to be deleted
		    var row = $(this).parent("td").parent("tr");

			var message = "score";

			var route = "/scores/terms/delete/"+id;

			swal_delete(message, route, row);
		});

	</script>
@endsection