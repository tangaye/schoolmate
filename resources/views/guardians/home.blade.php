@extends('layouts.master')

@section('page-title', 'Guardian Table')

@section('meta')
	<meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('page-header', 'Guardian Table')

@section('page-css')
	<!-- Animate css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
	<!-- swal alert css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.css") }}" rel="stylesheet" type="text/css" />
	<!-- datatables -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css") }}" rel="stylesheet" type="text/css" />
@endsection


@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-default ol-md-offset-2">
				<div class="panel-heading">
					<div class="container-fluid">
						<span class="panel-title">Guardians</span>
						<!-- button that triggers modal -->
						<a role="button" title="New Guardian" data-toggle="title" href="/register" class="pull-right">
							<span class="badge label-primary"><i class="fa fa-pencil"></i> </span>
						</a>
					</div>
				</div>

				<div class="panel-body">
					<!-- Table -->
					<table class="table table-bordered table-condensed table-striped" id="guardian-table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Birth Date</th>
								<th>Gender</th>
								<th>Address</th>
								<th>Phone</th>
								<th>Education</th>
								<th>Relationship</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($guardians as $guardian)
								<tr class="semester{{$guardian->id}}">
									<td>{{$guardian->first_name}} {{$guardian->surname}}</td>
									<td>{{$guardian->date_of_birth->toFormattedDateString()}}</td>
									<td>{{$guardian->gender}}</td>
									<td>{{$guardian->address}}</td>
									<td>{{$guardian->phone}}</td>
									<td>{{$guardian->education}}</td>
									<td>{{$guardian->data->relationship}}</td>
									<td>
										<a data-toggle="tooltip" title="Edit" href="/guardians/edit/{{$guardian->id}}" role="button">
											<i class="glyphicon glyphicon-edit text-info"></i>
										</a> &nbsp; 
										<a data-toggle="tooltip" data-id="{{$guardian->id}}" class="delete-guardian" title="Delete" href="#" role="button">
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

	<script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js") }}"></script>
	<script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>

	<script type="text/javascript">

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

		$('#guardian-table').DataTable();

		// deleting a student
		$(document).on('click', '.delete-guardian', function(event) {
			event.preventDefault();
			/* Act on the event */

			// id of the row to be deleted
			var id = $(this).attr('data-id');

		    // row to be deleted
		    var row = $(this).parent("td").parent("tr");

			var message = "Deleting this guardian will disassociate it from others records if related.";

			var item = "guardian";

			var route = "/users/delete/"+id;


			swal_delete(message, item, route, row);
			
		});	
	</script>

	@if($flash = session('message'))
        <script type="text/javascript">
            var message = "Guardian <b>{{$flash}}</b> updated!";
            notify(message);
        </script>
    @endif
@endsection