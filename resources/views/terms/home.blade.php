@extends('layouts.master')

@section('page-title', 'Terms')

@section('page-css')
	<!-- Animate css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />

	<!-- swal alert css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header', 'Terms')

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
      <li><a href="/grades"><i class="fa fa-edit"></i>Grades</a></li>
      <li><a href="/divisions"><i class="fa fa-edit"></i>Divisions</a></li>
      <li><a href="/semesters"><i class="fa fa-edit"></i>Semesters</a></li>
      <li class="active"><a href="/terms"><i class="fa fa-edit"></i>Terms</a></li>
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
	@include('terms.edit')
	<!-- grades modal form end -->

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
	              <li class="active"><a href="#term_details" data-toggle="tab">Details</a></li>
	              <li><a href="#new_term" data-toggle="tab">Add Term</a></li>
	            </ul>
	            <div class="tab-content">
	            	<div class="tab-pane active" id="term_details">
	            		<!-- Table -->
						<table class="table table-bordered table-condensed table-striped" id="terms-table">
							<thead>
								<tr>
									<th>Name</th>
									<th>Semester</th>
									<th colspan="2">Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($terms as $term)
									<tr class="term{{$term->id}}">
										<td>{{$term->name}}</td>
										<td>{{$term->semester->name}}</td>
										<td>
											<a id="edit-term" data-id="{{$term->id}}" data-name="{{$term->name}}" data-toggle="tooltip" title="Edit" href="#" role="button">
												<i class="glyphicon glyphicon-edit text-info"></i>
											</a>
										</td>
										<td>
											<a id="delete-term" data-id="{{$term->id}}" data-toggle="tooltip" title="Delete" href="#" role="button">
												<i class="glyphicon glyphicon-trash text-danger"></i>
											</a>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
	            	</div>
	            	<div class="tab-pane" id="new_term">
	            		@include('terms.partials.create')
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

			// inserting semester
			$(document).on('click', '#insert-term', function(event) {
				event.preventDefault();
				/* Act on the event */
				var name = $('#name').val();
				var semester = $('#semester').val();

				if (name.length == 0 || name.length == null) {
					$('.name-error').removeClass('hidden');
					$('.name-error').show().html('Please enter term name.'); 
				} 
				if (semester == null){
					$('.semester-error').removeClass('hidden');
					$('.semester-error').show().html('Please select a semester the term is found in.');
				} else {
					$.post('/terms', $("#add-form").serialize())
					.done(function (data) {
						// body...

						// if the validator bag returns error display error in modal
						if (data.errors) {
			        		$('.alert-danger').removeClass('hidden');
			    			var errors = '';
			                for(datum in data.errors){
			                    errors += data.errors[datum] + '<br>';
			                }
			                $('.errors').show().html(errors); //this is my div with 

			            } else {
			            	// reset the form
			            	$("#add-form")[0].reset();
			            	$('.name-error').addClass('hidden');
			            	$('.alert-danger').addClass('hidden');

			            	// prepare row of term details to append to table
			            	var row = '<tr class="term'+data[0].id+'">';

			            	row += '<td>'+data[0].name+'</td>';

			            	row += '<td>'+data[0].semester.name+'</td>';

			            	row += '<td><a id="edit-term" data-id="'+data[0].id+'" data-name="'+data[0].name+'" data-toggle="tooltip" title="Edit" href="#" role="button"><i class="glyphicon glyphicon-edit text-info"></i></a></td>';

			            	row += '<td><a id="delete-term" data-id="'+data[0].id+'" data-toggle="tooltip" title="Delete" href="#" role="button"><i class="glyphicon glyphicon-trash text-danger"></i></a></td>';

			            	row += '</tr>';
					
							// append row of term details to table
					        $("#terms-table").append(row);

					        // notify that the term was created
					        var message = '<b>'+data[0].name+'</b>'+ ' save!!';
				            notify(message);
			            }		 
					})
					.fail(function (data) {
						// body...

			        	$('.errors').removeClass('hidden');
			    		$('.errors').text('There was an error. Please try again, and if error persits contact administrator');
					});
				}
				
			});

			// retrieve and preparing edit modal with terms and semester details
			$(document).on('click', '#edit-term', function(event) {
				event.preventDefault();
				/* Act on the event */

				//set the name field with the term name
				$('#edit-name').val($(this).data('name'));

				// set the hidden input field value with the term id
				$('#edit-id').val($(this).data('id'));

				// term to be edited id
				var id = $(this).attr('data-id');

				// hide all errors
				$('.name-error').addClass('hidden');
				$('.errors').addClass('hidden');

				// display loader before ajax request
				$(document).ajaxStart(function() {
                	$(".overlay").css("display", "block");
              	});

              	$(document).ajaxStop(function() {
                	$(".overlay").css("display", "none");
              	});

				// an ajax call the get the semester assigned to the term to be edited
				$.get('/terms/edit/'+id)
				.done(function (data) {
					// body...
					$("#semester-select").replaceWith(data);

				})
				.fail(function (data) {
					// body...
					$('.errors').removeClass('hidden');
					$('.errors').html('Sorry! The was a problem retrieving details of class please try again and if problem persists contact administrator.')
				});


				// display the edit modal
				$('#edit-modal').modal({
					show: true,
					backdrop:'static',
					keyboard:false
				});
			});

			// editing a ter,
			$(document).on('click', '#update-term', function(event) {
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
						url: '/terms/update/'+id,
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

			            	// prepare updated term details to replace old one
			            	var row = '<tr class="term'+data[0].id+'">';

			            	row += '<td>'+data[0].name+'</td>';

			            	row += '<td>'+data[0].semester.name+'</td>';

			            	row += '<td><a id="edit-term" data-id="'+data[0].id+'" data-name="'+data[0].name+'" data-toggle="tooltip" title="Edit" href="#" role="button"><i class="glyphicon glyphicon-edit text-info"></i></a></td>';

			            	row += '<td><a id="delete-term" data-id="'+data[0].id+'" data-toggle="tooltip" title="Delete" href="#" role="button"><i class="glyphicon glyphicon-trash text-danger"></i></a></td>';

			            	row += '</tr>';

			            	// replace term row with updated details of term
			            	$(".term" + data[0].id).replaceWith(row);


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

			// deleting a term
			$(document).on('click', '#delete-term', function(event) {
				event.preventDefault();
				/* Act on the event */

				// id of the row to be deleted
				var id = $(this).attr('data-id');

			    // row to be deleted
			    var row = $(this).parent("td").parent("tr");

				var message = "If you continue you won't be able to retrieve this term!";

				var route = "/terms/delete/"+id;

				swal_delete(message, route, row);
				
			});	
		});
	</script>
@endsection