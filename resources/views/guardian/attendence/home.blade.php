@extends('layouts.master')

@section('page-title', 'Students Attendence')

@section('page-css')

<!-- Animate css -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
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

@section('page-header', 'View Students Attendence')

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
  <li class="treeview">
    <a href="#">
      <i class="fa fa-folder-open-o"></i>
      <span>Scores Reports</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="/guardian/students/term"><i class="fa fa-file-text-o"></i>Term Report</a></li>
      <li><a href="/guardian/students/semester"><i class="fa fa-file-text-o"></i>Semester Report</a></li>
      <li><a href="/guardian/students/annual"><i class="fa fa-file-text-o"></i>Annual Report</a></li>
    </ul>
  </li>
  <li class="active">
    <a href="{{route('guardian.attendence')}}"><i class="glyphicon glyphicon-stats"></i> <span>Students Attendence</span>
    </a>
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
         				<div class="form-group col-md-12 student-div">
         					<div class="input-group">
         						<span class="input-group-addon">Students</span>
                    	<select id="student" name="student_id" style="width: 100%" class="form-control">
                    		<option value="" selected="">Select Student(s)</option>
                  		  @foreach($guardians as $guardian)
    			                @foreach($guardian->student as $student)
    			                	<option value="{{$student->id}}">{{$student->first_name}} {{$student->surname}}</option>
    			                @endforeach
      			            @endforeach
                    	</select>
         					</div>
         				</div>

         				<div class="form-group col-md-4 hidden-years-dates hidden">
         					<div class="input-group">
         						<span class="input-group-addon">Years</span>
                		<select class="form-control" disabled="" id="years">
  	                  <option selected="" value="">Select Year</option>
  	                  @foreach($years as $values)
  	                    @foreach($values as $year)
  	                      <option>{{$year}}</option>
  	                    @endforeach
  	                  @endforeach
  	                </select>
         					</div>
         				</div>

         				<div class="form-group col-md-4 hidden-years-dates hidden">
         					<div class="input-group">
         						<span class="input-group-addon">Dates</span>
         						<select class="form-control" disabled="" id="dates" name="date"></select>
         					</div>
         				</div>
         			</div>

              <div class="row container">
                <div class="form-group hidden-search-div hidden">
                  <button class="btn btn-primary search-btn" disabled="">
                    <i class="glyphicon glyphicon-search"></i> Search
                  </button>
                </div>
              </div>
         			
	         		<div id="result"></div>
	         	</div>
         	</div>
	    </div>
	</div>

@endsection

@section('page-scripts')

	<script src="{{ asset ("/bower_components/AdminLTE/plugins/select2/select2.full.min.js") }}"></script>
	<script type="text/javascript" src="{{asset("/js/attendence/guardian/home.js")}}""></script>
@endsection