@extends('layouts.master')

@section('page-title', 'Academics')

@section('page-css')
<!-- date picker -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.css") }}" rel="stylesheet" type="text/css" />
<!-- swal alert css -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.css") }}" rel="stylesheet" type="text/css" />
<!-- Animate css -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('user-logout')
  @component('components.user-logout')
      @slot('user_name')
          {{Auth::guard('admin')-> user()->user_name}}
      @endslot
      {{route('admin.logout')}}
  @endcomponent
@endsection


@section('page-header', 'Academics Details')

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
      <li class="active"><a href="/academics"><i class="fa fa-edit"></i>Academic</a></li>
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
      <li><a href="{{route('roles.create')}}"><i class="fa fa-pencil"></i>New Role</a></li>
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

	@include('academics.edit')
    <div class="row">
    	<!-- Custom Tabs -->
    	<div class="col-md-9 col-md-offset-1">
	        <div class="nav-tabs-custom">
		        <ul class="nav nav-tabs">
	              <li class="active"><a href="#tab_details" data-toggle="tab">Details</a></li>
	              <li><a href="#tab_settings" data-toggle="tab">Settings</a></li>
	            </ul>
	            <div class="tab-content">
		            <div class="tab-pane active" id="tab_details">
		                <!-- Table -->
	                	<table class="table table-bordered">
	                		<thead>
	                			<tr>
	                				<th>Date Start</th>
	                				<th>Date End</th>
	                				<th>Status</th>
	                				<th colspan="2">Actions</th>
	                			</tr>
	                		</thead>
	                		<tbody>
	                			@foreach($academics as $academic)
	                				<tr class="academic{{$academic->id}}">
	                					<td>{{$academic->date_start->toFormattedDateString()}}</td>
	                					<td>{{$academic->date_end->toFormattedDateString()}}</td>
	                					@if($academic->status)
	                						<td><span class="label label-info">Active</span></td>
	                					@else
	                						<td><span class="label label-warning">Inactive</span></td>
	                					@endif
	                					<td>
	                						<a href="javascript:void(0)" id="edit-academic" data-toggle="tooltip" title="Edit" data-id="{{$academic->id}}" data-start="{{$academic->date_start->format('Y/m/d')}}" data-end="{{$academic->date_end->format('Y/m/d')}}">
	                							<i class="glyphicon glyphicon-edit text-info" ></i>
	                						</a>
	                					</td>

	                					<td><a href="" id="delete-academic" data-id="{{$academic->id}}" data-toggle="tooltip" title="Delete"><i class="glyphicon glyphicon-trash text-danger"></i></a></td>
	                				</tr>
	                			@endforeach
	                		</tbody>
	                	</table>
		            </div>
		             <!-- /.tab-pane -->
		            <div class="tab-pane" id="tab_settings">
	                	@include('academics.create')
		            </div>
		            <!-- /.tab-pane -->
	            </div>
	            <!-- /.tab-content -->
		    </div>
		    <!-- nav-tabs-custom -->
	    </div>
    </div>

@endsection


@section('page-scripts')
	
	<script src="{{ asset ("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.min.js") }}"></script>
    
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js") }}"></script>

    <script src="{{ asset ("/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js") }}"></script>

    <script type="text/javascript">

   		$(document).ready(function() {

   			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});

        	$.fn.datepicker.defaults.autoclose = true;

   			// validate date start field
			$('.date-start').on('change', function(event) {
				event.preventDefault();
				/* Act on the event */

	        	var currentDate = new Date();
	            var recieveDateStart = this.value;
	            var dateStart = new Date(recieveDateStart);
	            var start = dateStart.getFullYear();

	            // checks if the date being set is less than the current date
	            if (dateStart < currentDate) {
	            	// remove the hidden class on the error block
	            	$('.date-start-error').removeClass('hidden');
	            	// display error message
					$('.date-start-error').show().html('Date Start cannot be in the past. Current date is: <b class="text-muted">'+ currentDate.toDateString() +'</b>');
	            } 
	            else {
	            	// hide the date start error
	            	$('.date-start-error').addClass('hidden');

	            	/**
	            	* If all the above passes, lastly check if the date start
	            	* year currently exists in the database. This is to avoid
	            	* two academic term having the same start year.
	            	**/
	            	$.ajax({
		            	url: '/academics/start/'+start,
		            	type: 'GET',
		            	dataType: 'JSON'
		            })
		            .done(function(data) {
		            	if (data.exists) {
		            		// remove the hidden class on the error block
		            		$('.date-start-duplicate').removeClass('hidden');
		            		// display error message
							$('.date-start-duplicate').show().html(data.exists);
							// remove the date picker function on the date end field
							$('.date').removeAttr('data-provide');
		            	} else {
		            		// remove the hidden class on the error block
		            		$('.date-start-duplicate').addClass('hidden');	

		            		// activate datepicker function on the date-end field
			            	$('.date').attr('data-provide', 'datepicker');
			            	// remove the disable attribute on the date end field
			            	$('.date-end').removeAttr('disabled');
		            	}
		            })
		            .fail(function() {
		            	console.log("error");
		            });
	            }    	            
	        });		

			// validate date end field
	        $('.date-end').on('change', function(event) {
	        	event.preventDefault();
				/* Act on the event */

	        	var currentDate = new Date();
	            var recieveDateStart = $('.date-start').val();
	            var recieveDateEnd = this.value;

	            // convert to dateTime instance
	            var dateStart = new Date(recieveDateStart);
	            var dateEnd = new Date(recieveDateEnd);
	            var end = dateEnd.getFullYear();

	             // the date end cannot be the same as the the current year
	            if (dateEnd.getFullYear() == dateStart.getFullYear()){
	            	// remove the hidden class on the error block
	            	$('.date-end-error').removeClass('hidden');
	            	// display the error message
					$('.date-end-error').show().html('The Date End <b>year</b> cannot be the same as the Date Start Year'); 
	            }
        		// the date end value cannot not be in the past
	            else if (dateEnd.getFullYear() < dateStart.getFullYear()) {
	            	// remove the hidden class on the error block
	            	$('.date-end-error').removeClass('hidden');
	            	// display the error message
					$('.date-end-error').show().html('The Date End <b>year</b> cannot be in past or less than Date Start year'); 
	            } 
	            // the date end value cannot be 2 years greater than the date start value
	            // Ex. dateStart = 2017 ----- date end = 2019 (this shouldn't be)
 	            else if (dateEnd.getFullYear() - dateStart.getFullYear() >= 2) {
	            	// remove the hidden class on the error block
	            	$('.date-end-error').removeClass('hidden');
	            	// display the error message
					$('.date-end-error').show().html('The Date End <b>year</b> cannot be set two(2) or more years apart from the Date Start <b>year</b>'); 
					//disable all other fields
					$('.btn-submit').attr('disabled', 'true');
	            } else {

	            	// hide date end attribute
					$('.date-end-error').addClass('hidden');

					/**
	            	* If all the above passes, lastly check if the date end
	            	* year currently exists in the database. This is to avoid
	            	* two academic term having the same end year.
	            	**/
	            	$.ajax({
		            	url: '/academics/end/'+end,
		            	type: 'GET',
		            	dataType: 'JSON'
		            })
		            .done(function(data) {
		            	if (data.exists) {
		            		// remove the hidden class on the error block
		            		$('.date-end-duplicate').removeClass('hidden');
		            		// display error message
							$('.date-end-duplicate').show().html(data.exists);
		            	} else {
		            		// remove the hidden class on the error block
		            		$('.date-end-duplicate').addClass('hidden');

							//remove the disable attribut from on the status option
							$('.status').removeAttr('disabled');
							// remove disable attribute from on save btn
			            	$('.btn-submit').removeAttr('disabled');
		            		
		            	}
		            })
		            .fail(function() {
		            	console.log("error");
		            });     
	            }
	        });

	        
	    	 
	        // retrieve subject details to edit
			$(document).on('click', '#edit-academic', function(event) {
				event.preventDefault();
				/* Act on the event */

				//set the year start field with the year start value
				$('#edit-start').val($(this).data('start'));

				//set the year end field with the year end value
				$('#edit-end').val($(this).data('end'));

				// set the hidden input field value with the academic id
				$('#academic-id').val($(this).data('id'));

				// subject to be edited id
				var id = $(this).attr('data-id');

				// an ajax call the get the status assigned
				$.get('/academics/edit/'+id)
				.done(function (data) {
					// body...
					$("#status-check").replaceWith(data);
				})
				.fail(function (data) {
					// body...
					console.log(data);
				});

				// display the edit modal
				$('#academic-modal').modal({
					show: true,
					backdrop:'static',
					keyboard:false
				});	

				$(document).on('change', '.edit-dates', function(event) {
					event.preventDefault();
					/* Act on the event */

					var recieveEditDateStart = $('#edit-start').val();
	        		var recieveEditDateEnd = $('#edit-end').val();

	        		var currentDate = new Date();
	        		var editDateStart = new Date(recieveEditDateStart);
	        		var editDateEnd = new Date(recieveEditDateEnd);
		            var editStartYear = editDateStart.getFullYear();
		            var editEndYear = editDateEnd.getFullYear();

			
		            // checks if the date being set is less than the current date
		            if (editDateStart < currentDate) {
		            	// remove the hidden class on the error block
		            	$('.edit-date-start-error').removeClass('hidden');
		            	// display error message
						$('.edit-date-start-error').show().html('Date Start cannot be in the past. Current date is: <b class="text-muted">'+ currentDate.toDateString() +'</b>');
						$('#update-academic').attr('disabled', 'true');
		            } 

		            else {
		            	// hide the date start error
		            	$('.edit-date-start-error').addClass('hidden');

		            	/**
		            	* If all the above passes, lastly check if the date start
		            	* year currently exists in the database. This is to avoid
		            	* two academic term having the same start year.
		            	**/
		            	$.ajax({
			            	url: '/academics/edit-start/'+id+'/'+editStartYear,
			            	type: 'GET',
			            	dataType: 'JSON'
			            })
			            .done(function(data) {
			            	if (data.exists) {
			            		// remove the hidden class on the error block
			            		$('.edit-date-start-duplicate').removeClass('hidden');
			            		// display error message
								$('.edit-date-start-duplicate').show().html(data.exists);
								$('#update-academic').attr('disabled', 'true');
								
			            	} else {
			            		// remove the hidden class on the error block
			            		$('.edit-date-start-duplicate').addClass('hidden');	
			            	}
			            })
			            .fail(function() {
			            	$('.errors').removeClass('hidden');
							$('.errors').text('There was an error. Please try again, and if error persits contact administrator');
			            });
		            }    	

		            var noDateError = true;

		            // the date end cannot be the same as the the current year
		            if (editDateEnd.getFullYear() == editDateStart.getFullYear()){

		            	noDateError = false;

		            	// remove the hidden class on the error block
		            	$('.edit-date-end-error').removeClass('hidden');
		            	// display the error message
						$('.edit-date-end-error').show().html('The Date End <b>year</b> cannot be the same as the Date Start Year'); 
						$('#update-academic').attr('disabled', 'true');
		            }
	        		// the date end value cannot not be in the past
		            else if (editDateEnd.getFullYear() < editDateStart.getFullYear()) {
		            	noDateError = false;

		            	// remove the hidden class on the error block
		            	$('.edit-date-end-error').removeClass('hidden');
		            	// display the error message
						$('.edit-date-end-error').show().html('The Date End <b>year</b> cannot be in past or less than Date Start year'); 

						$('#update-academic').attr('disabled', 'true');
		            } 
		            // the date end value cannot be 2 years greater than the date start value
		            // Ex. dateStart = 2017 ----- date end = 2019 (this shouldn't be)
	 	            else if (editDateEnd.getFullYear() - editDateStart.getFullYear() >= 2) {
	 	            	noDateError = false;
	 	            	
		            	// remove the hidden class on the error block
		            	$('.edit-date-end-error').removeClass('hidden');
		            	// display the error message
						$('.edit-date-end-error').show().html('The Date End <b>year</b> cannot be set two(2) or more years apart from the Date Start <b>year</b>'); 

						$('#update-academic').attr('disabled', 'true');
		            } 
		            else if(noDateError) {

		            	// hide date end attribute
						$('.edit-date-end-error').addClass('hidden');

						/**
		            	* If all the above passes, lastly check if the date end
		            	* year currently exists in the database. This is to avoid
		            	* two academic term having the same end year.
		            	**/

		            	$.ajax({
				            	url: '/academics/edit-end/'+id+'/'+editEndYear,
				            	type: 'GET',
				            	dataType: 'JSON'
			            })
			            .done(function(data) {
			            	if (data.exists) {
			            		// remove the hidden class on the error block
			            		$('.edit-date-end-duplicate').removeClass('hidden');
			            		// display error message
								$('.edit-date-end-duplicate').show().html(data.exists);
								$('#update-academic').attr('disabled', 'true');
			            	} else {
			            		// remove the hidden class on the error block
			            		$('.edit-date-end-duplicate').addClass('hidden');
			            		$('#update-academic').removeAttr('disabled');
			            		
			            	}
			            })
			            .fail(function() {
			            	$('.errors').removeClass('hidden');
							$('.errors').text('There was an error. Please try again, and if error persits contact administrator');
			            });   
		            }

				});
			});

			// editing an academic term
			$(document).on('click', '#update-academic', function(event) {
				event.preventDefault();
				/* Act on the event */

				var id = $('#academic-id').val();
				var startDate = $('#edit-start').val();
				var endDate = $('#edit-end').val();


				// check if name is null befor submiting to server
				if (startDate === "") {
					$('.edit-date-start-error').removeClass('hidden');
					$('.edit-date-start-error').show().html('Please select a date.'); 
				}
				else if (endDate === "") {
					$('.edit-date-end-error').removeClass('hidden');
					$('.edit-date-end-error').show().html('Please select a date.'); 
				} else {

					$.ajax({
						url: '/academics/update/'+id,
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
			            	$('#academic-modal').modal('hide');

			            	// prepare updated subject details to replace old one
			            	var row = '<tr class="academic'+data.id+'">';

			            	row += '<td>'+data.date_start+'</td>';
			            	row += '<td>'+data.date_end+'</td>';

			            	if (data.status == 1) {
			            		row += '<td><span class="label label-info">Active</span></td>';
			            	} else if (data.status == 0) {
			            		row += '<td><span class="label label-warning">Inactive</span></td>';
			            	}


			            	row += '<td><a id="edit-academic" data-id="'+data.id+'" data-start="'+data.format_start+'" data-end="'+data.format_start+'" data-toggle="tooltip" title="Edit" href="#" role="button"><i class="glyphicon glyphicon-edit text-info"></i></a></td>';

			            	row += '<td><a id="delete-subject" data-id="'+data.id+'" data-toggle="tooltip" title="Delete" href="#" role="button"><i class="glyphicon glyphicon-trash text-danger"></i></a></td>';

			            	row += '</tr>';

			            	// replace subject row with updated details of subject
			            	$(".academic" + data.id).replaceWith(row);


			            	// notify the record was updated
			            	var message = '<b>'+data.date_start+'</b>'+ ' updated!!';
			            	notify(message);
			            }
						
					})
					.fail(function(data) {
						$('.errors').removeClass('hidden');
						$('.errors').text('There was an error. Please try again, and if error persits contact administrator');
					});
				}	
			});

			// deleting a subject
			$(document).on('click', '#delete-academic', function(event) {
				event.preventDefault();
				/* Act on the event */

				// id of the row to be deleted
				var id = $(this).attr('data-id');

			    // row to be deleted
			    var row = $(this).parent("td").parent("tr");

				var message = "academic";

				var route = "/academics/delete/"+id;

				swal_delete(message, route, row);
				
			});	
   		});
    </script>

    @if($flash = session('message'))
        <script type="text/javascript">
            var message = "Academic year: <b>{{$flash}}</b> save!";
            notify(message);
        </script>
    @endif
@endsection
