@extends('layouts.master')

@section('page-title', 'Terms')

@section('meta')
	<meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('page-css')
	<!-- Animate css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />

	<!-- swal alert css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header', 'Terms')


@section('content')

	<!-- grades modal form start -->
	@include('terms.edit')
	<!-- grades modal form end -->

	<div class="row">
		<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
			<div class="box box-primary collapsed-box box-solid">
				<div class="box-header with-border">
	              	<h3 class="box-title">Terms</h3>

		            <div class="box-tools pull-right">
		            	<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		            </div>
		        </div>

	            <div class="box-body container-fluid text-center">
					<form action="" method="POST" class="form-inline" role="form" id="terms-form">
						<p class="name-error text-danger hidden"></p>
						<p class="semester-error text-danger hidden"></p>
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" name="name" id="name" class="form-control" placeholder="Term name">
						</div>
						<div class="form-group">
                            <label for="semester">Semester</label>
                            
                            <select class="form-control" name="semester_id" id="semester" required="">
                                 @foreach($semesters as $semester)
                                    <option value="{{$semester->id}}">{{$semester->name}}</option>
                                @endforeach
                            </select>
                
                        </div>
                        <button type="submit" id="add-term" class="btn btn-success form-control">Save</button>
					</form>
				</div>

				<div class="panel-body">
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
			$(document).on('click', '#add-term', function(event) {
				event.preventDefault();
				/* Act on the event */
				var name = $('#name').val();
				var semester = $('#semester').val();

				if (name.length == 0 || name == null) {
					$('.name-error').removeClass('hidden');
					$('.name-error').show().html('Please enter term name.'); 
				} 
				if (semester == null){
					$('.semester-error').removeClass('hidden');
					$('.semester-error').show().html('Please select a semester the term is found in.');
				} else {
					$.post('/terms', $("#terms-form").serialize())
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
			            	$("#terms-form")[0].reset();

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

				var message = "term";

				var route = "/terms/delete/"+id;

				swal_delete(message, route, row);
				
			});	
		});
	</script>
@endsection