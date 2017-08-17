@extends('layouts.master')

@section('page-title', 'Semesters')

@section('meta')
	<meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('page-css')
	<!-- Animate css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />

	<!-- swal alert css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header', 'Semesters')


@section('content')

	<!-- grades modal form start -->
	@include('semesters.edit')
	<!-- grades modal form end -->

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="box box-default collapsed-box">
				<div class="box-header with-border">
	              	<h3 class="box-title">Semesters</h3>

		            <div class="box-tools pull-right">
		            	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		            </div>
		        </div>

	            <div class="box-body container-fluid text-center">
	            	<form action="" method="POST" class="form-inline" role="form" id="semesters-form">
						<p class="name-error text-danger hidden"></p>
						<div class="form-group">
							<div class="input-group margin">
								<input type="text" name="name" id="name" class="form-control" placeholder="Enter semester name">
				                <span class="input-group-btn">
				                    <button type="submit" id="add-semester" class="btn btn-info btn-flat form-control">Save</button>
				                </span>
				             </div>
						</div>
					</form>
				</div>

				<div class="panel-body">
					<!-- Table -->
					<table class="table table-bordered table-condensed table-striped" id="semester-table">
						<thead>
							<tr>
								<th>Name</th>
								<th colspan="2">Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($semesters as $semester)
								<tr class="semester{{$semester->id}}">
									<td>{{$semester->name}}</td>
									<td>
										<a id="edit-semester" data-id="{{$semester->id}}" data-name="{{$semester->name}}" data-toggle="tooltip" title="Edit" href="#" role="button">
											<i class="glyphicon glyphicon-edit text-info"></i>
										</a>
									</td>
									<td>
										<a id="delete-semester" data-id="{{$semester->id}}" data-toggle="tooltip" title="Delete" href="#" role="button">
											<i class="glyphicon glyphicon-trash text-danger"></i>
										</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
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
			$(document).on('click', '#add-semester', function(event) {
				event.preventDefault();
				/* Act on the event */
				var name = $('#name').val();

				if (name.length == 0 || name == null) {
					$('.name-error').removeClass('hidden');
					$('.name-error').show().html('Please enter semester name.'); 
				} else {
					$.post('/semesters', $("#semesters-form").serialize())
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
			            	$("#semesters-form")[0].reset();

			            	// prepare row of division details to append to table
			            	var row = '<tr class="semester'+data.id+'">';

			            	row += '<td>'+data.name+'</td>';

			            	row += '<td><a id="edit-semester" data-id="'+data.id+'" data-name="'+data.name+'" data-toggle="tooltip" title="Edit" href="#" role="button"><i class="glyphicon glyphicon-edit text-info"></i></a></td>';

			            	row += '<td><a id="delete-semester" data-id="'+data.id+'" data-toggle="tooltip" title="Delete" href="#" role="button"><i class="glyphicon glyphicon-trash text-danger"></i></a></td>';

			            	row += '</tr>';
					
							// append row of division details to table
					        $("#semester-table").append(row);

					        // notify that the subject was created
					        var message = '<b>'+data.name+'</b>'+ ' save!!';
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

			// retrieve and preparing edit modal with semester details
			$(document).on('click', '#edit-semester', function(event) {
				event.preventDefault();
				/* Act on the event */

				//set the name field with the semester name
				$('#edit-name').val($(this).data('name'));

				// set the hidden input field value with the semester id
				$('#edit-id').val($(this).data('id'));


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

			// editing a semester
			$(document).on('click', '#update-semester', function(event) {
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
						url: '/semesters/update/'+id,
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

			            	// prepare row of division details to append to table
			            	var row = '<tr class="semester'+data.id+'">';

			            	row += '<td>'+data.name+'</td>';

			            	row += '<td><a id="edit-semester" data-id="'+data.id+'" data-name="'+data.name+'" data-toggle="tooltip" title="Edit" href="#" role="button"><i class="glyphicon glyphicon-edit text-info"></i></a></td>';

			            	row += '<td><a id="delete-semester" data-id="'+data.id+'" data-toggle="tooltip" title="Delete" href="#" role="button"><i class="glyphicon glyphicon-trash text-danger"></i></a></td>';

			            	row += '</tr>';

			            	// replace semester row with updated details of semesters
			            	$(".semester" + data.id).replaceWith(row);


			            	// notify the record was updated
			            	var message = '<b>'+data.name+'</b>'+ ' updated!!';
			            	notify(message);
			            }
						
					})
					.fail(function(data) {
						$('.errors').removeClass('hidden');
						$('.errors').text('There was an error. Please try again, and if error persits contact administrator');
					});
				}	
			});

			// deleting a division
			$(document).on('click', '#delete-semester', function(event) {
				event.preventDefault();
				/* Act on the event */

				// id of the row to be deleted
				var id = $(this).attr('data-id');

			    // row to be deleted
			    var row = $(this).parent("td").parent("tr");

				var message = "semester";

				var route = "/semesters/delete/"+id;

				swal_delete(message, route, row);
				
			});	
		});
	</script>
@endsection