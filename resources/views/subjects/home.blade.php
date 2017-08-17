@extends('layouts.master')

@section('page-title', 'Subjects')

@section('meta')
	<meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('page-css')
<link href="{{ asset("/bower_components/AdminLTE/plugins/select2/select2.min.css") }}" rel="stylesheet" type="text/css" />
<!-- swal alert css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.css") }}" rel="stylesheet" type="text/css" />
<!-- Animate css -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header', 'Subjects')


@section('content')

	<!-- subject modal form start -->
	@include('subjects.create')
	<!-- subject modal form end -->

	<!-- subject modal form start -->
	@include('subjects.edit')
	<!-- subject modal form end -->

	<div class="row">
		<div class="col-md-12">

			<div class="panel panel-default">
				<!-- Default panel contents -->
				<div class="panel-heading">
					<div class="container-fluid">
						<span class="panel-title">Subjects</span>
						<!-- button that triggers modal -->
						<a role="button" class="pull-right" id="add-subject">
							<span class="badge label-primary"><i class="fa fa-pencil"></i> </span>
						</a>
					</div>
					
				</div>
				<div class="panel-body">
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
			</div>
			<!-- /. close of panel div -->
		</div>
	</div>

@endsection


@section('page-scripts')

	<script src="{{ asset ("/bower_components/AdminLTE/plugins/select2/select2.full.min.js") }}"></script>

	<script src="{{ asset ("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.min.js") }}"></script>

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

						// if the validator bag returns error display error in modal
						if (data.errors) {
			        		$('.errors').removeClass('hidden');
			    			var errors = '';
			                for(datum in data.errors){
			                    errors += data.errors[datum] + '<br>';
			                }
			                $('.errors').show().html(errors); //this is my div with 

			            } else {
			            	// reset the form
			            	$("#add-form")[0].reset();
			            	// hide the modal
			            	$('#add-modal').modal('hide');

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

				var message = "subject";

				var route = "/subjects/delete/"+id;

				swal_delete(message, route, row);
				
			});	
		});
	</script>
@endsection