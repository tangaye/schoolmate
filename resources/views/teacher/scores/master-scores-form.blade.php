@extends('layouts.master')

@section('page-title', 'Scores')

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

@section('page-header', 'Master Scores Sheet')


@section('sidebar-navigation')
<!-- Sidebar Menu -->
<ul class="sidebar-menu">
  <li class="header">TEACHER NAVIGATION</li>
  <li>
    <a href="{{route('teacher.dashboard')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
    </a>
  </li>
  <li class="active">
    <a href="{{route('teacher.manage-scores')}}"><i class="fa fa-pencil"></i> <span>Manage Scores</span></a>
  </li>
  <li>
    <a href="{{route('teacher.scores-home')}}"><i class="glyphicon glyphicon-th-list"></i> <span>Scores Table</span></a>
  </li>

  <li class="treeview">
    <a href="#">
      <i class="glyphicon glyphicon-stats"></i><span>Attendence</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{route('teacher-attendence')}}"><i class="glyphicon glyphicon-list-alt"></i>Manage Attendence</a></li>
      <li><a href="{{route('teacher-attendence.create')}}"><i class="fa fa-pencil"></i>New Attendence</a></li>      
    </ul>
  </li>
</ul>
<!-- /.sidebar-menu -->
@endsection


@section('content')


	<div class="row">
		<div class="col-md-12">
         	<div class="panel">

            @component('components.loader')
            @endcomponent

         		<div class="panel-body">

              <div class="row">
                <div class="form-group col-md-12 grade-div">
                  <div class="input-group">
                    <span class="input-group-addon">Grades/Class</span>
                    <select name="grade_id" class="form-control" id="grade">
                      <option value="">Select Grade/Class</option>
                      @foreach($teacher_grades as $grade)
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
                    <select disabled="true" name="term_id" class="form-control subjects-terms" id="term">
                      <option value="">Select term</option>
                      @foreach($terms as $term)
                        <option value="{{$term->id}}">{{$term->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>

              <!-- div to display errors returned by server-->
              <div class="errors alert hidden">
              </div>
              <!-- end of errors div -->

	         		<div id="result"></div>
	         	</div>
         	</div>
	    </div>
	</div>

@endsection

@section('page-scripts')

	<script src="{{ asset ("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.min.js") }}"></script>

	<script type="text/javascript" src="{{asset("/js/scores/teacher/master-scores-form.js")}}"></script>
@endsection