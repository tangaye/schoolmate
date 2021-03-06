@extends('layouts.master')

@section('page-title', 'Subjects')

@section('page-css')

<!-- swal alert css -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.css") }}" rel="stylesheet" type="text/css" />
<!-- Animate css -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
<link href="{{ asset("/bower_components/AdminLTE/plugins/select2/select2.min.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header', 'Subjects')

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
  <li class="active treeview">
    <a href="#"><i class="fa fa-cogs"></i> <span>Settings</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="/institution"><i class="fa fa-edit"></i>Institution</a></li>
      <li><a href="/academics"><i class="fa fa-edit"></i>Academic</a></li>
      <li class="active"><a href="/subjects"><i class="fa fa-edit"></i>Subjects</a></li>
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
      <li><a href="{{route('students.home')}}"><i class="glyphicon glyphicon-list-alt"></i>Student List</a></li>
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

	<!-- subject modal form start -->
	@include('admin.subjects.edit')
	<!-- subject modal form end -->

	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
	              <li class="active"><a href="#subject_details" data-toggle="tab">Details</a></li>
	              <li><a href="#new_subject" data-toggle="tab">Add Subject</a></li>
	            </ul>
	            <div class="tab-content">
	            	<div class="tab-pane active" id="subject_details">
	            		<table class="table table-responsive table-striped table-condensed table-bordered" id="subject-table">
							<thead>
								<tr>
									<th>Name</th>
									<th>Grade(s)</th>
									<th colspan="2">Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($subjects as $subject)
									<tr class="subject{{$subject->id}}">

										<td>{{$subject->name}}</td>

										<td>
											<!-- If a subject belongs to a class/grade or classes/grades list all the grades/classes
											that belongs to the subject -->
											@if(count($subject->grade))
												@foreach($subject->grade as $grade)
													<span class="badge label-primary">{{$grade->name}}</span>
												@endforeach
											@endif
										</td>

										<td>
											<a id="edit-subject" data-id="{{$subject->id}}" data-name="{{$subject->name}}" data-toggle="tooltip" title="Edit" href="#" role="button">
												<i class="glyphicon glyphicon-edit text-info"></i>
											</a>
										</td>
										<td>
											<a id="delete-subject" data-id="{{$subject->id}}" data-toggle="tooltip" title="Delete" href="#" role="button">
												<i class="glyphicon glyphicon-trash text-danger"></i>
											</a>
										</td>

									</tr>
								@endforeach
							</tbody>
						</table>
	            	</div>
	            	<div class="tab-pane" id="new_subject">
	                	@include('admin.subjects.partials.create')
		            </div>
	            </div>
			</div>
		</div>
	</div>

@endsection


@section('page-scripts')

	<script src="{{ asset ("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.min.js") }}"></script>

	<script src="{{ asset ("/bower_components/AdminLTE/plugins/select2/select2.full.min.js") }}"></script>

	

	<script type="text/javascript">

		//Initialize Select2 Elements
    	$(".select2").select2();
    	
		$(document).ready(function($) {
			
			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});

			//prepare add modal
			$(document).on('click', '#add-subject', function(event) {
				event.preventDefault();
				/* Act on the event */
				// hide all errors
				$('.name-error').addClass('hidden');
				$('.errors').addClass('hidden');

				// reset the form
				$("#add-form")[0].reset();

				// display the add modal
				$('#add-modal').modal({
					show: true,
					backdrop:'static',
					keyboard:false
				});
			});

			// retrieve subject details to edit
			$(document).on('click', '#edit-subject', function(event) {
				event.preventDefault();
				/* Act on the event */

				//set the name field with the subject name
				$('#edit-name').val($(this).data('name'));

				// set the hidden input field value with the subject id
				$('#edit-id').val($(this).data('id'));

				// subject to be edited id
				var id = $(this).attr('data-id');

				// display loader before ajax request
				$(document).ajaxStart(function() {
                	$(".overlay").css("display", "block");
              	});

              	$(document).ajaxStop(function() {
                	$(".overlay").css("display", "none");
              	});

				// an ajax call the get the division assigned to the subject to be edited
				$.get('/subjects/edit/'+id)
				.done(function (data) {
					// body...
					$("#grade-check").replaceWith(data);
					//Initialize Select2 Elements
    				$(".select2").select2();

				})
				.fail(function (data) {
					// body...
					console.log(data);
				});

				// hide all errors
				$('.name-error').addClass('hidden');
				$('.errors').addClass('hidden');


				// display the edit modal
				$('#edit-modal').modal({
					show: true,
					backdrop:'static',
					keyboard:false
				});
			});

			// editing a subject
			$(document).on('click', '#update-subject', function(event) {
				event.preventDefault();
				/* Act on the event */

				var id = $('#edit-id').val();
				var name = $('#edit-name').val();

				// check if name is null befor submiting to server
				if (name.length == 0 || name == null) {
					$('.name-error').removeClass('hidden');
					$('.name-error').show().html('Please check if the name field is fill in.'); 
				} else {
					$.ajax({
						url: '/subjects/update/'+id,
						type: 'PUT',
						data: $("#edit-form").serialize(),
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

			            } else {
			       
			            	// hide the bootstrap dialog
			            	$("#edit-form")[0].reset();
			            	$('#edit-modal').modal('hide');

			            	// prepare updated subject details to replace old one
			            	var row = '<tr class="subject'+data[0].id+'">';

			            	row += '<td>'+data[0].name+'</td>';

			            	row += '<td>';
				            	for(datum in data[0].grade){
				            		console.log(data[0].grade[datum].name);
				            		row += '<span class="badge label-primary">'+data[0].grade[datum].name+'</span> ';
				            	}
			            	row += '</td>';

			            	row += '<td><a id="edit-subject" data-id="'+data[0].id+'" data-name="'+data[0].name+'" data-toggle="tooltip" title="Edit" href="#" role="button"><i class="glyphicon glyphicon-edit text-info"></i></a></td>';

			            	row += '<td><a id="delete-subject" data-id="'+data[0].id+'" data-toggle="tooltip" title="Delete" href="#" role="button"><i class="glyphicon glyphicon-trash text-danger"></i></a></td>';

			            	row += '</tr>';

			            	// replace subject row with updated details of subject
			            	$(".subject" + data[0].id).replaceWith(row);


			            	// notify the record was updated
			            	var message = '<b>'+data[0].name+'</b>'+ ' updated!!';
			            	notify(message);
			            }
						
					})
					.fail(function(data) {
						$('.errors').removeClass('hidden');
						$('.errors').text('There was an error. Please try again, and if error persits contact administrator');
					});
				}	
			});

			// inserting subjects
			$(document).on('click', '#insert-subject', function(event) {
				event.preventDefault();
				/* Act on the event */
				var name = $('#name').val();

				if (name.length == 0 || name == null) {
					$('.name-error').removeClass('hidden');
					$('.name-error').show().html('Please check if the name field is fill in.'); 
				} else {
					$.post('/subjects', $( "#add-form" ).serialize())
					.done(function (data) {
						// body...
						$('.name-error').addClass('hidden');

						// if the validator bag returns error display error in modal
						if (data.errors) {
			        		$('.alert-danger').removeClass('hidden');
			    			var errors = '';
			                for(datum in data.errors){
			                    errors += data.errors[datum] + '<br>';
			                }
			                $('.errors').show().html(errors); //this is my div with 

			            } else {
			            	//clear errors
			            	$('.alert-danger').addClass('hidden');
			            	// reset the form
			            	$("#add-form")[0].reset();
			            	// resest select list
			            	$("#grade_id").select2('val', 'All');
			            	

			            	// prepare row of subject details to append to table
			            	var row = '<tr class="subject'+data[0].id+'">';

			            	row += '<td>'+data[0].name+'</td>';

			            	row += '<td>';
				            	for(datum in data[0].grade){
				            		console.log(data[0].grade[datum].name);
				            		row += '<span class="badge label-primary">'+data[0].grade[datum].name+'</span> ';
				            	}
			            	row += '</td>';

			            	row += '<td><a id="edit-subject" data-id="'+data[0].id+'" data-name="'+data[0].name+'" data-toggle="tooltip" title="Edit" href="#" role="button"><i class="glyphicon glyphicon-edit text-info"></i></a></td>';

			            	row += '<td><a id="delete-subject" data-id="'+data[0].id+'" data-toggle="tooltip" title="Delete" href="#" role="button"><i class="glyphicon glyphicon-trash text-danger"></i></a></td>';

			            	row += '</tr>';
					
							// append row of subject details to table
					        $("#subject-table").append(row);

					        // notify that the subject was created
					        var message = '<b>'+data[0].name+'</b>'+ ' save successfully!!';
				            notify(message);
			            }		 
					})
					.fail(function (data) {
						// body...
						$('#subject-modal').modal('hide');
			            	// display error

			        	$('.errors').removeClass('hidden');
			    		$('.errors').text('There was an error. Please try again, and if error persits contact administrator');
					});
				}
				
			});

			// deleting a subject
			$(document).on('click', '#delete-subject', function(event) {
				event.preventDefault();
				/* Act on the event */

				// id of the row to be deleted
				var id = $(this).attr('data-id');

			    // row to be deleted
			    var row = $(this).parent("td").parent("tr");

				var message = "If you continue you won't be able to retrieve this subject!";

				var route = "/subjects/delete/"+id;

				swal_delete(message, route, row);
				
			});	
		});
	</script>
@endsection