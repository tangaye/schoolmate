
@extends('layouts.master')

@section('page-title', 'Attendence')

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
          {{Auth::guard('teacher')-> user()->user_name}}
      @endslot
      {{route('teacher.logout')}}
  @endcomponent
@endsection


@section('sidebar-navigation')
<!-- Sidebar Menu -->
<ul class="sidebar-menu">
  <li class="header">TEACHER NAVIGATION</li>
  <li>
    <a href="{{route('teacher.dashboard')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
    </a>
  </li>
  <li>
    <a href="{{route('teacher.manage-scores')}}"><i class="fa fa-pencil"></i> <span>Manage Scores</span></a>
  </li>
  <li class="active">
    <a href="{{route('teacher.scores-home')}}"><i class="glyphicon glyphicon-th-list"></i> <span>Scores Table</span></a>
  </li>

  <li class="treeview active">
    <a href="#">
      <i class="glyphicon glyphicon-stats"></i><span>Attendence</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="active"><a href="{{route('teacher-attendence')}}"><i class="glyphicon glyphicon-list-alt"></i>Manage Attendence</a></li>
      <li><a href="{{route('teacher-attendence.create')}}"><i class="fa fa-pencil"></i>New Attendence</a></li>      
    </ul>
  </li>

</ul>
<!-- /.sidebar-menu -->
@endsection


@section('content')

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-default ol-md-offset-2">
				<div class="panel-heading">
					<div class="container-fluid">
						<span class="panel-title">Manage Attendence</span>

						<a class="btn btn-primary pull-right btn-sm" href="{{route('teacher-attendence.create')}}">
							<i class="glyphicon glyphicon-plus"></i> New Attendence
						</a>
					</div>
				</div>

				<div class="panel-body">
          @component('components.loader')
          @endcomponent

          <form>
            <div class="row">

              <div class="form-group col-md-12 grade-div">
                <label class="control-label">Grades</label>
                <select class="form-control search" name="grade_id" id="grade">
                  <option value="" selected="">Select Grade</option>
                  @foreach($teacher_grades as $grade)
                    <option value="{{$grade->id}}">{{$grade->name}}</option>
                  @endforeach
                </select>
              </div>
              <!-- ./ grades close -->

              <div class="form-group hidden-subject-div hidden">
                <label class="control-label">Subjects</label>
                <select class="form-control" disabled="" id="subject" name="subject_id">
                  
                </select>
              </div>
              <!-- ./ grades close -->

              <div class="form-group col-md-3 hidden-dates-div hidden">
                <label class="control-label">Years</label>
                <select class="form-control search" disabled="" id="years">
                  <option selected="" value="">Select Year</option>
                  @foreach($years as $values)
                    @foreach($values as $year)
                      <option>{{$year}}</option>
                    @endforeach
                  @endforeach
                </select>
              </div>

              <div class="form-group col-md-3 hidden-dates-div hidden">
                <label class="control-label">Dates</label>
                <select class="form-control search" disabled="" id="date" name="date">
                  
                </select>
              </div>
            </div>
            <div class="row container">
              <div class="form-group hidden-search-div hidden">
                <button class="btn btn-primary search-btn" disabled="">
                  <i class="glyphicon glyphicon-search"></i> Search
                </button>
              </div>
            </div>
          </form>
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

  <script src="{{ asset ("/js/attendence/teacher/home.js") }}"></script>
@endsection