@extends('layouts.master')

@section('page-title', 'New Attendence')

@section('page-css')
	<!-- Animate css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
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
      <li ><a href="{{route('teacher-attendence')}}"><i class="glyphicon glyphicon-list-alt"></i>Manage Attendence</a></li>
      <li class="active"><a href="{{route('teacher-attendence.create')}}"><i class="fa fa-pencil"></i>New Attendence</a></li>      
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
						<span class="panel-title">New Attendence</span>

						<a class="btn btn-primary pull-right btn-sm" onclick="history.back()">
							<i class="glyphicon glyphicon-arrow-left"></i> Back
						</a>
					</div>
				</div>

				<div class="panel-body">
          @component('components.loader')
          @endcomponent

          <div class="alert alert-warning errors hidden"></div>

          <div class="row">
            <form id="search-form">
              <div class="form-group col-md-12 grade-div">
                <label class="control-label">Grade</label>
                <select class="form-control" name="grade_id" id="grade">
                  <option value="" selected="">Select Grade</option>
                  @foreach($teacher_grades as $grade)
                    <option value="{{$grade->id}}">{{$grade->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-md-4 hidden-div hidden">
                <label class="control-label">Subject</label>
                <select class="form-control" disabled="" name="subject_id" id="subject">
                </select>
              </div>
              <div class="form-group col-md-4 hidden-div hidden">
                <label class="control-label">Date</label>
                <input class="form-control" type="" id="date" value="{{$date}}" readonly="" name="date">
              </div>
            </form>
          </div>
          <div id="result"></div>
          <div id="test"></div>
				</div>
			</div>
		</div>	
	</div>

@endsection

@section('page-scripts')
  <script src="{{ asset ("/js/attendence/create.js") }}"></script>
@endsection