@extends('layouts.master')

@section('page-title', 'Annual Report')

@section('page-header', 'Annual Report')

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
      <li><a href="/guardian/students/term"><i class="fa fa-file-text-o"></i>Term Report</a></li>
      <li><a href="/guardian/students/semester"><i class="fa fa-file-text-o"></i>Semester Report</a></li>
      <li class="active"><a href="/guardian/students/annual"><i class="fa fa-file-text-o"></i>Annual Report</a></li>
    </ul>
  </li>
</ul>
<!-- /.sidebar-menu -->
@endsection


@section('content')


	<div class="row">
		<div class="col-md-12">

         	<div class="panel">
         		<div class="panel-body">
         			<div class="form-group">
         				<div class="input-group">
                  <span class="input-group-addon">Students</span>
                    <select id="student" class="search-fields form-control" name="student_id" class="form-control">
                      <option value="" selected="">Select Student(s)</option>
                      @foreach($guardians as $guardian)
                        @foreach($guardian->student as $student)
                          <option value="{{$student->id}}">{{$student->first_name}} {{$student->surname}}</option>
                        @endforeach
                      @endforeach
                    </select>
	         			</div>
	         		</div>
	         		<div id="result"></div>
              <div>
                <button class="btn btn-primary print-btn" onclick="printReport('result')">
                 <i class="fa fa-print"></i> Print
                </button>
              </div>
	         	</div>
         	</div>
	    </div>
	</div>

@endsection

@section('page-scripts')
	<script type="text/javascript">

    function printReport (section){
        var printContent = document.getElementById(section);
        var WinPrint = window.open();

        WinPrint.document.write('<link rel="stylesheet" type="text/css" href="{{ asset("/css/app.css") }}">');
        WinPrint.document.write('<link rel="stylesheet" type="text/css" href="{{ asset("/css/media-print.css") }}" media="print">');
        WinPrint.document.write(printContent.innerHTML);
        WinPrint.document.write('<footer>Courtesy of <b>School</b>Mate</footer>');
        WinPrint.document.close();
        WinPrint.setTimeout(function(){
          WinPrint.focus();
          WinPrint.print();
          WinPrint.close();
        }, 1000);
    }

		$(document).ready(function() {

			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});

      $('.search-fields').on('change', function(event) {
            event.preventDefault();

            /* Act on the event */
            var student = $('#student').val();
            var semester = $('#semester').val();

            if (student != '' && semester != '') {
              $.ajax({
                url:"/guardian/students/annual",
                method:"POST",
                data:{"student_id":student, "semester_id":semester},
                success:function(data){
                  $("#result").html(data);
                }
              });
            } else {
              $("#result").html('');

            }   

        });
			
		});

	</script>
@endsection