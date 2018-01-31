@extends('layouts.master')

@section('page-title', 'Guardian Student Term Report')

@section('page-css')
<link href="{{ asset("/bower_components/AdminLTE/plugins/select2/select2.min.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('user-logout')
  @component('components.user-logout')
      @slot('user_name')
          {{Auth::guard('guardian')-> user()->user_name}}
      @endslot
      {{route('guardian.logout')}}
  @endcomponent
@endsection

@section('page-header', 'Guardian Student Term Report')

@section('sidebar-navigation')
<!-- Sidebar Menu -->
<ul class="sidebar-menu">
  <li class="header">MAIN NAVIGATION</li>
  <!-- Optionally, you can add icons to the links -->
  <li>
    <a href="{{route('guardian.dashboard')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
    </a>
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
      <li class="active"><a href="/guardian/students/term"><i class="fa fa-file-text-o"></i>Term Report</a></li>
      <li><a href="/guardian/students/semester"><i class="fa fa-file-text-o"></i>Semester Report</a></li>
      <li><a href="/guardian/students/annual"><i class="fa fa-file-text-o"></i>Annual Report</a></li>
    </ul>
    <li>
      <a href="{{route('guardian.attendence')}}"><i class="glyphicon glyphicon-stats"></i> <span>Students Attendence</span>
      </a>
    </li>
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

         				<div class="form-group col-md-4">

			              <label class="control-label">Academic Years</label>
			              <select name="academic_id" class="form-control" id="academic">
			                <option selected="true" value="">Select Academic Year</option>
			                @foreach($academics as $academic)
			                  <option value="{{$academic->id}}">{{$academic->year_start}}/{{$academic->year_end}}</option>
			                @endforeach
			              </select>
			              
			            </div>
				            
			            <div class="form-group col-md-4">
			              <label class="control-label">Students</label>
			              <select class="form-control search-fields" disabled="" name="student_id" id="student" style="width: 100%;"></select>
			            </div>

			            <div class="form-group col-md-4">
			              <label class="control-label">Term</label>
			              <select name="term_id"  class="form-control search-fields" id="term" disabled="">
			                @foreach($terms as $term)
			                 <option value="{{$term->id}}">{{$term->name}}</option>
			                @endforeach
			              </select>
			            </div>
         			</div>
         			
	         		<div id="result"></div>
	         		<div class="hidden print-div">
		                <button class="btn btn-primary print-btn">
		                 <i class="fa fa-print"></i> Print
		                </button>
		            </div>
	         	</div>
         	</div>
	    </div>
	</div>

@endsection

@section('page-scripts')

	<script src="{{ asset ("/bower_components/AdminLTE/plugins/select2/select2.full.min.js") }}"></script>

	<script type="text/javascript" src="{{asset("/js/scores/guardian/term.js")}}"></script>
@endsection