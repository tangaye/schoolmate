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

@section('page-header', 'View students scores')

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
  <li class="treeview">
    <a href="#"><i class="fa fa-user"></i> <span>Guardians</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="/users/guardians"><i class="glyphicon glyphicon-th-list"></i> <span>Guardians</span></a></li>
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

  <li class=" active">
    <a href="/users/scores"><i class="glyphicon glyphicon-list-alt"></i> <span>Score Tables</span>
    </a>
  </li>
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
         			<div class="form-group col-md-12 grade-div">
         				<div class="input-group">
         					<span class="input-group-addon">Grades/Class</span>
         					<select name="grade_id" class="form-control" id="grade">
			                    <option value="">Select Grade/Class</option>
			                    @foreach($grades as $grade)
			                      <option value="{{$grade->id}}">{{$grade->name}}</option>
			                    @endforeach
			                </select>
         				</div>
         			</div>
         			<div class="form-group col-md-4 hidden-subjectTerm-div hidden">
         				<div class="input-group">
         					<span class="input-group-addon">Subject</span>
            				<select disabled="true" name="subject_id" id="subject" class="form-control subjects-terms">
            				</select>
         				</div>
         			</div>
         			<div class="form-group col-md-4 hidden-subjectTerm-div hidden">
         				<div class="input-group">
	                  		<span class="input-group-addon">Term</span>
	                  		<select disabled="" name="term_id" class="form-control subjects-terms" id="term">
	                  			<option value="">Select term</option>
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
	</div>

@endsection

@section('page-scripts')

	<script src="{{ asset ("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.min.js") }}"></script>


	<script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js") }}"></script>
	<script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>

	<script type="text/javascript" src="{{asset("/js/scores/user/home.js")}}"></script>
@endsection