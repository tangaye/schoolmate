@extends('layouts.master')

@section('page-title', 'User Roles')

@section('meta')
	<meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('page-header', 'User Roles')

@section('page-css')
	<!-- Animate css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
	<!-- swal alert css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('admin-navigation')
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

  <!-- Settings -->
  <li class="treeview">
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
  <li class="treeview active">
    <a href="#">
      <i class="glyphicon glyphicon-user"></i><span>Users Roles</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="active"><a href="{{route('roles.home')}}"><i class="glyphicon glyphicon-list-alt"></i>Roles</a></li>
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
      <li><a href="#"><i class="fa fa-file-text-o"></i>Annual Report</a></li>
    </ul>
  </li>
</ul>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <a href="/roles/create" class="btn btn-sm btn-flat btn-primary pull-right">
      <i class="glyphicon glyphicon-plus"></i>
      New Role
      </a>
    </div>
  </div> <br>
  
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">
          User Roles
        </div>

				<div class="panel-body">
					<!-- Table -->
					<table class="table table-bordered table-condensed">
              <thead>
                  <th>Name</th>
                  <th>Permissions</th>
                  <th colspan="2">Actions</th>
              </thead>
              <tbody>
                  @foreach($roles as $role)
                      <tr>
                          <td>{{$role->name}}</td>
                          <td>
                              @foreach($role->permissions as $key => $value)
                                  <span class="label label-info">{{$key}}</span>
                              @endforeach
                          </td>
                          <td>
                            <a  data-toggle="tooltip" title="Edit" href="/roles/edit/{{$role->id}}" role="button">
                              <i class="glyphicon glyphicon-edit text-info"></i>
                            </a>
                          </td>
                          <td>
                            <a class="delete-role" data-id="{{$role->id}}" data-toggle="tooltip" title="Delete" href="#" role="button">
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
            var message = "Role <b>{{$flash}}</b> updated!";
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
		$(document).on('click', '.delete-role', function(event) {
			event.preventDefault();
			/* Act on the event */

			// id of the row to be deleted
			var id = $(this).attr('data-id');

		    // row to be deleted
		  var row = $(this).parent("td").parent("tr");

			var message = "role";

			var route = "/roles/delete/"+id;


			swal_delete(message, route, row);
			
		});	
	</script>

@endsection