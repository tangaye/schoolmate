@extends('layouts.master')

@section('page-title', 'Division')

@section('meta')
	<meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('page-css')
	<!-- Animate css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />

	<!-- swal alert css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header', 'Division')


@section('content')

	<!-- division modal form start use for editing division-->
	@include('divisions.edit')
	<!-- division modal form end -->

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="box box-default collapsed-box">
				<div class="box-header with-border">
	              	<h3 class="box-title">Divisions</h3>

		            <div class="box-tools pull-right">
		            	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		            </div>
		        </div>

	            <div class="box-body container-fluid text-center">
					<form action="" method="POST" class="form-inline" role="form" id="divisions-form">
						<p class="name-error text-danger hidden"></p>
						<div class="form-group">
							<div class="input-group margin">
								<input type="text" name="name" id="name" class="form-control" placeholder="Enter division name">
				                <span class="input-group-btn">
				                    <button type="submit" id="add-semester" class="btn btn-info btn-flat form-control">Save</button>
				                </span>
				             </div>
						</div>
						<button type="submit" id="add-division" class="btn btn-success form-control">Save</button>
					</form>
				</div>

				<div class="panel-body">
					<!-- Table -->
					<table class="table table-bordered table-condensed table-striped" id="division-table">
						<thead>
							<tr>
								<th>Name</th>
								<th colspan="2">Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($divisions as $division)
								<tr class="division{{$division->id}}">
									<td>{{$division->name}}</td>
									<td>
										<a id="edit-division" data-id="{{$division->id}}" data-name="{{$division->name}}" data-toggle="tooltip" title="Edit" href="#" role="button">
											<i class="glyphicon glyphicon-edit text-info"></i>
										</a>
									</td>
									<td>
										<a id="delete-division" data-id="{{$division->id}}" data-toggle="tooltip" title="Delete" href="#" role="button">
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

			// retrieve division details to edit
			$(document).on('click', '#edit-division', function(event) {
				event.preventDefault();
				/* Act on the event */

				//set the name field with the subject name
				$('#edit-name').val($(this).data('name'));

				// set the hidden input field value with the subject id
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

			// editing a division
			$(document).on('click', '#update-division', function(event) {
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
						url: '/divisions/update/'+id,
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
			            	var row = '<tr class="division'+data.id+'">';

			            	row += '<td>'+data.name+'</td>';

			            	row += '<td><a id="edit-division" data-id="'+data.id+'" data-name="'+data.name+'" data-toggle="tooltip" title="Edit" href="#" role="button"><i class="glyphicon glyphicon-edit text-info"></i></a></td>';

			            	row += '<td><a id="delete-division" data-id="'+data.id+'" data-toggle="tooltip" title="Delete" href="#" role="button"><i class="glyphicon glyphicon-trash text-danger"></i></a></td>';

			            	row += '</tr>';

			            	// replace subject row with updated details of subject
			            	$(".division" + data.id).replaceWith(row);


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

			// inserting division
			$(document).on('click', '#add-division', function(event) {
				event.preventDefault();
				/* Act on the event */
				var name = $('#name').val();

				if (name.length == 0 || name == null) {
					$('.name-error').removeClass('hidden');
					$('.name-error').show().html('Please check if the name field is fill in.'); 
				} else {
					$.post('/divisions', $("#divisions-form").serialize())
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
			            	$("#divisions-form")[0].reset();

			            	// prepare row of division details to append to table
			            	var row = '<tr class="division'+data.id+'">';

			            	row += '<td>'+data.name+'</td>';

			            	row += '<td><a id="edit-division" data-id="'+data.id+'" data-name="'+data.name+'" data-toggle="tooltip" title="Edit" href="#" role="button"><i class="glyphicon glyphicon-edit text-info"></i></a></td>';

			            	row += '<td><a id="delete-division" data-id="'+data.id+'" data-toggle="tooltip" title="Delete" href="#" role="button"><i class="glyphicon glyphicon-trash text-danger"></i></a></td>';

			            	row += '</tr>';
					
							// append row of division details to table
					        $("#division-table").append(row);

					        // notify that the subject was created
					        var message = '<b>'+data.name+'</b>'+ ' save successfully!!';
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

			// deleting a division
			$(document).on('click', '#delete-division', function(event) {
				event.preventDefault();
				/* Act on the event */

				// id of the row to be deleted
				var id = $(this).attr('data-id');

			    // row to be deleted
			    var row = $(this).parent("td").parent("tr");

				var message = "division";

				var route = "/divisions/delete/"+id;

				swal_delete(message, route, row);
				
			});	
		});
	</script>

@endsection
