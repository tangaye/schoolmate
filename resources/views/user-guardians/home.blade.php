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

@section('user-logout')
  @component('components.user-logout')
      @slot('user_name')
          {{Auth::guard('web')-> user()->user_name}}
      @endslot
      {{route('user.logout')}}
  @endcomponent
@endsection


@section('sidebar-navigation')
<!-- Sidebar Menu -->
<ul class="sidebar-menu">
  <li class="header">USER NAVIGATION</li>

  <li class="">
    <a href="{{route('user.dashboard')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
    </a>
  </li>

  <!-- guardians -->
  <li class="treeview active">
    <a href="#"><i class="fa fa-user"></i> <span>Guardians</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="active"><a href="/users/guardians"><i class="glyphicon glyphicon-th-list"></i> <span>Guardians</span></a></li>
      <li><a href="/users/guardians/create"><i class="fa fa-pencil"></i>New Guardian</a></li>
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
      <li><a href="/users/students"><i class="glyphicon glyphicon-list-alt"></i>Student List</a></li>
      <li><a href="/users/students/create"><i class="fa fa-pencil"></i>Student Admission</a></li>
    </ul>
  </li>

  <li class="">
    <a href="/users/scores"><i class="glyphicon glyphicon-list-alt"></i> Score Tables
    </a>
  </li>
</ul>
@endsection

@section('content')
	@can('create-guardian')
		<div class="row">
			<div class="col-sm-12">
				<a href="/users/guardians/create" class="btn btn-sm btn-primary btn-flat pull-right">New Guardian</a>
			</div> 
		</div><br>
	@endcan
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-default ol-md-offset-2">
				<div class="panel-heading">
					Guardians
				</div>

				<div class="panel-body">
					<!-- Table -->
					<table class="table table-bordered table-condensed table-striped" id="guardian-table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Gender</th>
								<th>Address</th>
								<th>Phone</th>
								<th>Relationship</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($guardians as $guardian)
								<tr class="semester{{$guardian->id}}">
									<td>{{$guardian->first_name}} {{$guardian->surname}}</td>
									<td>{{$guardian->gender}}</td>
									<td>{{$guardian->address}}</td>
									<td>{{$guardian->phone}}</td>
									<td>{{$guardian->relationship}}</td>
									<td>
										@can('show-guardian')
											<a data-toggle="tooltip" title="Edit" href="/users/guardians/edit/{{$guardian->id}}" role="button">
												<i class="glyphicon glyphicon-edit text-info"></i>
											</a> &nbsp; 
										@endcan

										@can('delete-guardian')
											<a data-toggle="tooltip" data-id="{{$guardian->id}}" class="delete-guardian" title="Delete" href="#" role="button">
												<i class="glyphicon glyphicon-trash text-danger"></i>
											</a>
										@endcan
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

			var route = "/users/guardian/delete/"+id;


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