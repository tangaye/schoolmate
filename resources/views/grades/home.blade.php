@extends('layouts.master')

@section('page-title', 'Grade')


@section('page-css')
	<!-- Animate css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />

	<!-- swal alert css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header', 'Grade')

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
      <li><a href="/institution"><i class="fa fa-edit"></i>Institution</a></li>
      <li><a href="/academics"><i class="fa fa-edit"></i>Academic</a></li>
      <li><a href="/subjects"><i class="fa fa-edit"></i>Subjects</a></li>
      <li class="active"><a href="/grades"><i class="fa fa-edit"></i>Grades</a></li>
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

	<!-- grades modal form start -->
	@include('grades.edit')
	<!-- grades modal form end -->

	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
	              <li class="active"><a href="#grade_details" data-toggle="tab">Details</a></li>
	              <li><a href="#new_grade" data-toggle="tab">New Grade</a></li>
	            </ul>
	            <div class="tab-content">
	            	<div class="tab-pane active" id="grade_details">
		            	<!-- Table -->
						<table class="table table-bordered table-condensed table-striped" id="grades-table">
							<thead>
								<tr>
									<th>Name</th>
									<th>Divison</th>
									<th colspan="2">Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($grades as $grade)
									<tr class="grade{{$grade->id}}">
										<td>{{$grade->name}}</td>
										<td>{{$grade->division->name}}</td>
										<td>
											<a id="edit-grade" data-id="{{$grade->id}}" data-name="{{$grade->name}}" data-toggle="tooltip" title="Edit" href="#" role="button">
												<i class="glyphicon glyphicon-edit text-info"></i>
											</a>
										</td>
										<td>
											<a id="delete-grade" data-id="{{$grade->id}}" data-toggle="tooltip" title="Delete" href="#" role="button">
												<i class="glyphicon glyphicon-trash text-danger"></i>
											</a>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
		            </div>
		            <div class="tab-pane" id="new_grade">
	            		@include('grades.partials.create')
	            	</div>
	            </div>
	            
	            
			</div>
		</div>	
	</div>

@endsection

@section('page-scripts')

	<script src="{{ asset ("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.min.js") }}"></script>
	<script type="text/javascript">
		$(document).ready(function($) {

			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});

			// inserting class/grade
			$(document).on('click', '#insert-grade', function(event) {
				event.preventDefault();
				/* Act on the event */
				var name = $('#name').val();
				var division = $('#division').val();

				if (name.length == 0 || name.length == null) {
					$('.name-error').removeClass('hidden');
					$('.name-error').show().html('Please enter a class/grade name.'); 
				}
				if (division == null){
					$('.division-error').removeClass('hidden');
					$('.division-error').show().html('Please select a division the subject is taught in.');
				} else {
					//$('.name-error').addClass('hidden');
					$.post('/grades', $("#add-form").serialize())
					.done(function (data) {
						// body...

						// if the validator bag returns error display error in modal
						if (data.errors) {
			        		$('.alert-danger').removeClass('hidden');

			    			var errors = '';
			                for(datum in data.errors){
			                    errors += data.errors[datum] + '<br>';
			                }
			                $('.errors').show().html(errors); 

			            } else {
			            	// reset the form
			            	$("#add-form")[0].reset();
			            	$('.name-error').addClass('hidden');
			            	$('.alert-danger').addClass('hidden');

			            	// prepare row of grade details to append to table
			            	var row = '<tr class="grade'+data[0].id+'">';

			            	row += '<td>'+data[0].name+'</td>';

			            	row += '<td>'+data[0].division.name+'</td>';

			            	row += '<td><a id="edit-grade" data-id="'+data[0].id+'" data-name="'+data[0].name+'" data-toggle="tooltip" title="Edit" href="#" role="button"><i class="glyphicon glyphicon-edit text-info"></i></a></td>';

			            	row += '<td><a id="delete-grade" data-id="'+data[0].id+'" data-toggle="tooltip" title="Delete" href="#" role="button"><i class="glyphicon glyphicon-trash text-danger"></i></a></td>';

			            	row += '</tr>';
					
							// append row of grade details to table
					        $("#grades-table").append(row);

					        // notify that the grade was created
					        var message = '<b>'+data[0].name+'</b>'+ ' save!!';
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


			// prepare edit modal
			$(document).on('click', '#edit-grade', function(event) {
				event.preventDefault();
				/* Act on the event */
				// hide all errors

				//set the name field with the subject name
				$('#edit-name').val($(this).data('name'));

				// set the hidden input field value with the grade id
				$('#edit-id').val($(this).data('id'));

				// subject to be edited id
				var id = $(this).attr('data-id');

				$('.name-error').addClass('hidden');
				$('.errors').addClass('hidden');

				// display loader before ajax request
				$(document).ajaxStart(function() {
                	$(".overlay").css("display", "block");
              	});

              	$(document).ajaxStop(function() {
                	$(".overlay").css("display", "none");
              	});

				// an ajax call the get the division assigned to the class/grade to be edited
				$.get('/grades/edit/'+id)
				.done(function (data) {
					// body...
					$(".division-select").replaceWith(data);

				})
				.fail(function (data) {
					// body...
					$('.errors').removeClass('hidden');
					$('.errors').html('Sorry! The was a problem retrieving details of class please try again and if problem persists contact administrator.')
				});

				// display the add modal
				$('#edit-modal').modal({
					show: true,
					backdrop:'static',
					keyboard:false
				});
			});

			// editing a class/grade
			$(document).on('click', '#update-grade', function(event) {
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
						url: '/grades/update/'+id,
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
			       			
			       			console.log(data);
			            	// hide the bootstrap dialog
			            	$("#edit-form")[0].reset();

			            	$('#edit-modal').modal('hide');

			            	// prepare updated subject details to replace old one
			            	var row = '<tr class="grade'+data[0].id+'">';

			            	row += '<td>'+data[0].name+'</td>';

			            	row += '<td>'+data[0].division.name+'</td>';

			            	row += '<td><a id="edit-grade" data-id="'+data[0].id+'" data-name="'+data[0].name+'" data-toggle="tooltip" title="Edit" href="#" role="button"><i class="glyphicon glyphicon-edit text-info"></i></a></td>';

			            	row += '<td><a id="delete-grade" data-id="'+data[0].id+'" data-toggle="tooltip" title="Delete" href="#" role="button"><i class="glyphicon glyphicon-trash text-danger"></i></a></td>';

			            	row += '</tr>';

			            	// replace subject row with updated details of subject
			            	$(".grade" + data[0].id).replaceWith(row);


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

			// deleting a class/grade
			$(document).on('click', '#delete-grade', function(event) {
				event.preventDefault();
				/* Act on the event */

				// id of the row to be deleted
				var id = $(this).attr('data-id');

			    // row to be deleted
			    var row = $(this).parent("td").parent("tr");

				var message = "If you continue you won't be able to retreive this grade!";

				var route = "/grades/delete/"+id;

				swal_delete(message, route, row);
				
			});	

		});
	</script>
@endsection