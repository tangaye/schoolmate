@extends('layouts.master')

@section('page-title', 'Users Table')

@section('page-header', 'User Table')

@section('page-css')
	<!-- Animate css -->
  <link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
  <!-- swal alert css -->
  <link href="{{ asset("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.css") }}" rel="stylesheet" type="text/css" />
  <!-- datatables -->
  <link href="{{ asset("/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.css") }}" rel="stylesheet" type="text/css" />

  <link href="{{ asset("/bower_components/AdminLTE/plugins/datatables/buttons.bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('user-logout')
  @component('components.user-logout')
      @slot('user_name')
          {{Auth::guard('admin')-> user()->user_name}}
      @endslot
      {{route('admin.logout')}}
  @endcomponent
@endsection


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
      <li><a href="{{route('guardians.form')}}"><i class="glyphicon glyphicon-pencil"></i>New Guardian</a></li>
    </ul>
  </li>

  <!-- teachers -->
  <li class="treeview">
    <a href="#"><i class="glyphicon glyphicon-education"></i> <span>Teachers</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{route('teachers.home')}}"><i class="glyphicon glyphicon-th-list"></i> <span>Teachers</span></a></li>
      <li><a href="{{route('teachers.form')}}"><i class="fa fa-pencil"></i>New Teacher</a></li>
      <li><a href="{{route('admin-gradesTeacher.home')}}"><i class="glyphicon glyphicon-align-left""></i>Teacher Grades</a></li>
      <li><a href="{{route('admin-gradesTeacher.form')}}"><i class="fa fa-pencil"></i>New Teacher Grade</a></li>
      <li><a href="{{route('admin.ponsor.home')}}"><i class="glyphicon glyphicon-knight"></i>Sponsors</a></li>
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
      <li><a href="{{route('students.home')}}"><i class="glyphicon glyphicon-list-alt"></i>Student List</a></li>
      <li><a href="{{route('students.create')}}"><i class="glyphicon glyphicon-pencil"></i>Student Admission</a></li>
      <li><a href="{{route('enrollments.home')}}"><i class="glyphicon glyphicon-saved"></i>Student Enrollment</a></li>
    </ul>
  </li>

  <!-- attendence -->
  <li class="treeview">
    <a href="#">
      <i class="glyphicon glyphicon-stats"></i><span>Attendence</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{route('attendence')}}"><i class="glyphicon glyphicon-list-alt"></i>Manage Attendence</a></li>
      <li><a href="{{route('attendence.create')}}"><i class="glyphicon glyphicon-pencil"></i>New Attendence</a></li>      
    </ul>
  </li>

  <!-- users -->
  <li class="treeview active">
    <a href="#">
      <i class="glyphicon glyphicon-user"></i><span>Users</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="active"><a href="{{route('users.home')}}"><i class="glyphicon glyphicon-list-alt"></i>User List</a></li>
      <li><a href="{{route('users.form')}}"><i class="glyphicon glyphicon-pencil"></i>New User</a></li>
      <li><a href="{{route('roles.home')}}"><i class="glyphicon glyphicon-tasks"></i>Roles</a></li>
      <li><a href="{{route('roles.form')}}"><i class="glyphicon glyphicon-pencil"></i>New Role</a></li>
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
      <li><a href="/scores/master"><i class="glyphicon glyphicon-pencil"></i>Enter Score</a></li>
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
  <!-- transcript -->
  <li>
    <a href="{{route('transcripts.home')}}"><i class="fa fa-file-text-o"></i> <span>Student Transcript</span>
    </a>
  </li>
</ul>
@endsection

@section('content')

	<div class="row">
		<div class="col-md-12">

			<div class="panel panel-default">

				<div class="panel-heading">
          <div class="container-fluid">
            <span>User Listing</span>
            <a href="{{route('users.form')}}" class="btn btn-sm btn-primary pull-right">
              <i class="glyphicon glyphicon-plus"></i>
              New User
            </a>
          </div>    
        </div>

				<div class="panel-body">
					<!-- Table -->
					<table class="table table-bordered table-condensed table-striped" id="user-table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Gender</th>
								<th>Address</th>
								<th>Phone</th>
                <th>User Name</th>
								<th>Email</th>
								<th>Role</th>
								<th class="actions noExport">Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($users as $user)
								<tr>
									<td>{{$user->name}}</td>
									<td>{{$user->gender}}</td>
									<td>{{$user->address}}</td>
									<td>{{$user->phone}}</td>
                  <td>{{$user->user_name}}</td>
									<td><span class="label label-info">{{$user->email}}</span></td>
                  <td>
                      <span class="label label-default">{{$user->role->name}}</span>
                  </td>
									<td>
										<a data-toggle="tooltip" title="Edit" href="/admin/users/edit/{{$user->id}}" role="button">
											<i class="glyphicon glyphicon-edit text-info"></i>
										</a>
										<a data-id="{{$user->id}}" data-toggle="tooltip" class="delete-user" title="Delete" href="#" role="button">
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

   <script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/dataTables.buttons.min.js") }}"></script>
   <script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/buttons.bootstrap.min.js") }}"></script>

   <script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/jszip.min.js") }}"></script>
   <script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/pdfmake.min.js") }}"></script>
   <script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/vfs_fonts.js") }}"></script>

   <script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/buttons.print.min.js") }}"></script>

   <script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/buttons.html5.min.js") }}"></script>

	@if($flash = session('message'))
      <script type="text/javascript">
          var message = "User <b>{{$flash}}</b> save!";
          notify(message);
      </script>
  @endif

  <script type="text/javascript">

    $('#user-table').DataTable({
      dom: 'Bfrtip',
      buttons: [
        {
          extend: 'excel',
          title: 'User Listing',
          text: '<i class="fa fa-file-excel-o"></i> Excel',
          exportOptions: {
            columns: ':not(.noExport)'
          }
        },
        {
          extend: 'pdf',
          title: 'User Listing',
          text: '<i class="fa fa-file-pdf-o"></i> PDF',
          exportOptions: {
           columns: ':not(.noExport)'
          }
        },
        {
          extend: 'print',
          title: 'User Listing',
          text: '<i class="fa fa-print"></i> Print',
          exportOptions: {
            columns: ':not(.noExport)'
          }
        }
      ],

      "aoColumnDefs" : [
       {
         'bSortable' : false,
         'aTargets' : ['actions', 'text-holder' ]
       }]

    });


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

      var message = "user";

      var route = "/admin/users/delete/"+id;


      swal_delete(message, route, row);
      
    }); 
  </script>

@endsection