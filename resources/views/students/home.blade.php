@extends('layouts.master')

@section('page-title', 'Students')

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

@section('page-header', 'Students')


@section('content')

	<div class="row">
		<div class="col-md-12">

			<div class="panel panel-default">
				<!-- Default panel contents -->
				<div class="panel-heading">
					<div class="container-fluid">
						<span class="panel-title">Students</span>
						<!-- button that triggers modal -->
						<a role="button" title="New student" data-toggle="title" href="/students/create" class="pull-right" id="add-student">
							<span class="badge label-primary"><i class="fa fa-pencil"></i> </span>
						</a>
					</div>
					
				</div>
				<div class="panel-body">
					<table class="table table-responsive table-striped table-condensed table-bordered" id="student-table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Birth Date</th>
								<th>Address</th>
								<th>County</th>
								<th>Country</th>
								<th>Grade</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($students as $student)
								<tr>

									<td>{{$student->first_name}} {{$student->surname}}</td>
									<td>{{$student->date_of_birth->toFormattedDateString()}}</td>
									<td>{{$student->address}}</td>
									<td>{{$student->county}}</td>
									<td>{{$student->country}}</td>
									<td>{{$student->grade->name}}</td>

									<td>
										<a id="edit-student" href="/students/edit/{{$student->id}}" data-toggle="tooltip" title="Edit" href="#" role="button">
											<i class="glyphicon glyphicon-edit text-info"></i>
										</a> &nbsp;
										<a id="delete-student" data-id="{{$student->id}}" data-toggle="tooltip" title="Delete" href="#" role="button">
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

	<script src="{{ asset ("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.min.js") }}"></script>
	<script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js") }}"></script>
	<script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>

	<script type="text/javascript">

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

		$('#student-table').DataTable();

		// deleting a student
		$(document).on('click', '#delete-student', function(event) {
			event.preventDefault();
			/* Act on the event */

			// id of the row to be deleted
			var id = $(this).attr('data-id');

		    // row to be deleted
		    var row = $(this).parent("td").parent("tr");

			var message = "You'll not be able to retrieve this student!";

			var route = "/students/delete/"+id;

			var item = "student";


			swal_delete(message, item, route, row);
		});	
	</script>

	@if($flash = session('message'))
        <script type="text/javascript">
            var message = "Student <b>{{$flash}}</b> updated!";
            notify(message);
        </script>
    @endif


@endsection