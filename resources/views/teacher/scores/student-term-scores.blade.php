@extends('layouts.master')

@section('page-title', 'Term Report')

@section('page-header', 'Term Report')

@section('page-css')

<link href="{{ asset("/bower_components/AdminLTE/plugins/select2/select2.min.css") }}" rel="stylesheet" type="text/css" />
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
        <li><a href="{{route('teacher-attendence')}}"><i class="glyphicon glyphicon-list-alt"></i>View Attendence</a></li>
        <li><a href="{{route('teacher-attendence.create')}}"><i class="fa fa-pencil"></i>New Attendence</a></li>      
      </ul>
    </li>

    <!-- reports -->
    <li class="active treeview">
      <a href="#">
        <i class="fa fa-folder-open-o"></i>
        <span>Scores Reports</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="active"><a href="{{route('teacher.term-scores')}}"><i class="fa fa-file-text-o"></i>Term Report</a></li>
        <li><a href="{{route('teacher.semester-scores')}}"><i class="fa fa-file-text-o"></i>Semester Report</a></li>
        <li><a href="{{route('teacher.annual-scores')}}"><i class="fa fa-file-text-o"></i>Annual Report</a></li>
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

            <div class="form-group col-md-3">
              <label class="control-label">Academic Years</label>
              <select name="academic_id" class="form-control" id="academic_id">
                @if(count($academics) > 0)
                  <option selected="" value="">Select Academic Year</option>
                  @foreach($academics as $academic)
                    @if($academic->status)
                      <option class="text-danger" style="font-weight: bold;" value="{{$academic->id}}">
                        {{$academic->full_year}}
                        <span>- Current</span>
                      </option>
                    @else 
                      <option value="{{$academic->id}}">{{$academic->full_year}}</option>
                    @endif
                  @endforeach
                @else
                  <option selected="" value="">You haven't yet been assigned to teach any grade.</option>
                @endif
              </select>
            </div>

            <div class="form-group col-md-3">
              <label class="control-label">Grade Sponsoring</label>
              <select disabled="" name="grade_id" class="form-control" id="grade">
              </select> 
            </div>
            
            <div class="form-group col-md-3">
              <label class="control-label">Students</label>
              <select class="form-control search_fields" disabled="" name="student_id" id="student" style="width: 100%;"></select>
            </div>

            <div class="form-group col-md-3">
              <label class="control-label">Term</label>
              <select name="term_id"  disabled=""  class="form-control search_fields" id="term">
                @foreach($terms as $term)
                 <option value="{{$term->id}}">{{$term->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          
       		<div id="result">
          </div>
          <div class="print-div hidden">
            <a href="#" class="btn btn-primary print-btn">
              <span>
                <i class="fa fa-print"></i>
              </span>
              Print
            </a>
          </div>
       	</div>
     	</div>
	 </div>
	</div>

@endsection

@section('page-scripts')
  <script src="{{ asset ("/bower_components/AdminLTE/plugins/select2/select2.full.min.js") }}"></script>
  <script type="text/javascript" src="{{asset("/js/scores/teacher/student-term-scores.js")}}"></script>
@endsection