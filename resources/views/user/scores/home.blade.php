@extends('layouts.master')

@section('page-title', 'Students Scores')

@section('page-css')
	<!-- Animate css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
	<!-- swal alert css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.css") }}" rel="stylesheet" type="text/css" />
	<!-- datatables -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header', 'Students Scores')

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
    @if($user->canAccessGuardians())
      <li class="treeview">
        <a href="#"><i class="fa fa-user"></i> <span>Guardians</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @can('view-guardian')
            <li><a href="{{route('users.guardians')}}"><i class="glyphicon glyphicon-th-list"></i> <span>Guardians</span></a></li>
          @endcan
          @can('create-guardian')
            <li><a href="{{route('users.guardians.create')}}"><i class="fa fa-pencil"></i>New Guardian</a></li>
          @endcan
        </ul>
      </li>
    @endif

    <!-- student -->
    @if($user->canAccessStudents())
      <li class="treeview">
        <a href="#">
          <i class="fa fa-users"></i><span>Students</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @can('view-student')
            <li><a href="{{route('users.students')}}"><i class="glyphicon glyphicon-list-alt"></i>Student List</a></li>
          @endcan
          @can('create-student')
            <li><a href="{{route('users.students.create')}}"><i class="fa fa-pencil"></i>Student Admission</a></li>
          @endcan
        </ul>
      </li>
    @endif

    @if($user->canAccessScores())
      <li class="active">
        <a href="{{route('users.scores')}}"><i class="glyphicon glyphicon-list-alt"></i> <span>Score Tables</span></a>
      </li>
    @endif
  </ul>
@endsection

@section('content')	
	<!-- edit score modal form start -->
	@include('scores.edit')
	<!-- edit score modal form end -->

	<div class="row">
		<div class="col-md-12">
      <div class="panel">     
        @component('components.loader')
        @endcomponent
          
        <div class="panel-body">
          <div class="row">

            <div class="form-group col-md-3">
              <label class="control-label">Academic Years</label>
              <select name="academic_id" class="form-control" id="academic">
                <option value="">Select Academic Year</option>
                  @foreach($academics as $academic)
                  <option value="{{$academic->id}}">{{$academic->full_year}}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group col-md-3">
              <label class="control-label">Grade</label>
              <select name="grade_id" disabled="" class="form-control" id="grade">
              </select>
            </div>

            <div class="form-group col-md-3">
              <label class="control-label">Subject</label>
              <select disabled="true" name="subject_id" id="subject" class="form-control search_fields"></select>
            </div>

            <div class="form-group col-md-3">
              <label class="control-label">Term</label>
              <select disabled="" name="term_id" class="form-control search_fields" id="term">
                @foreach($terms as $term)
                  <option value="{{$term->id}}">{{$term->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div id="result">
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

	<script type="text/javascript" src="{{asset("/js/scores/user/home.js")}}"></script>
@endsection