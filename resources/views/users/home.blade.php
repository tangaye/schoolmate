@extends('layouts.master')

@section('page-title', 'Users Table')

@section('meta')
	<meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('page-header', 'User Table')

@section('page-css')
	<!-- Animate css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
	<!-- swal alert css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">User</div>

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
								<th>Email</th>
								<th>Relationship</th>
								<th colspan="2">Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($users as $user)
								<tr class="semester{{$user->id}}">
									<td>{{$user->first_name}} {{$user->surname}}</td>
									<td>{{$user->date_of_birth->toFormattedDateString()}}</td>
									<td>{{$user->gender}}</td>
									<td>{{$user->address}}</td>
									<td>{{$user->education}}</td>
									<td>{{$user->phone}}</td>
									<td>{{$user->email}}</td>
									<td>{{$user->type}}</td>
									<td>
										<a data-toggle="tooltip" title="Edit" href="/users/edit/{{$user->id}}" role="button">
											<i class="glyphicon glyphicon-edit text-info"></i>
										</a>
									</td>
									<td>
										<a data-toggle="tooltip" class="delete-user" title="Delete" href="#" role="button">
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

	@if($flash = session('message'))
        <script type="text/javascript">
            var message = "User <b>{{$flash}}</b> updated!";
            notify(message);
        </script>
    @endif

    <script type="text/javascript">

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

		// deleting a student
		$(document).on('click', '.delete-user', function(event) {
			event.preventDefault();
			/* Act on the event */

			// id of the row to be deleted
			var id = $(this).attr('data-id');

		    // row to be deleted
		    var row = $(this).parent("td").parent("tr");

			var message = "Deleting this user will disassociate it from others records if related.";

			var item = "user";

			var route = "/users/delete/"+id;


			swal_delete(message, item, route, row);
			
		});	
	</script>

@endsection