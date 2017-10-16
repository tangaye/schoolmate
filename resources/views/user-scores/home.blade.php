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
         			<div class="form-group">
         				<div class="input-group">
         					<span class="input-group-addon">Grades/Class</span>
         					<select name="grade_id" class="form-control" id="grade">
			                    <option value="">Select Grade/Class</option>
			                    @foreach($grades as $grade)
			                      <option value="{{$grade->id}}">{{$grade->name}}</option>
			                    @endforeach
			                </select>

                 			 <span class="input-group-addon">Subject</span>
            				<select disabled="true" name="subject_id" id="subject" class="form-control subjects-terms">
            				</select>

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

	<script type="text/javascript">

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});


        // on change of the grades select list the subject select list should be load up 
	   // with subjects that are taught in the selected grade/class
	   	$(document).on('change', '#grade', function(event) {
	      event.preventDefault();
	      /* Act on the event */

	      // hide all errors
	      $('.errors').addClass('hidden');
	    
	      var subject = $('#subject').val();
	      var grade = $('#grade').val();
	      var term = $('#term').val();

	      if (grade != "") {

	        $(document).ajaxStart(function() {
	          $(".overlay").css("display", "block");
	        });

	        $(document).ajaxStop(function() {
	          $(".overlay").css("display", "none");
	        });

	        $("#subject").removeAttr('disabled');

	       	$.get('/users/scores/grade-subjects/'+grade)
	        .done(function (data) {

	        	if (data.none) {
	        		$("#result").html(data.none);
	        		$("#subject").val('');
	        		$("#subject").attr('disabled','disabled');

	        	} else {
	        		$('select[name="subject_id"]').empty();
		         	$('select[name="subject_id"]').append('<option value="">Select Subjects</option>');
		          	$.each(data, function(key, value) {
		            	$('select[name="subject_id"]').append('<option value="'+ key +'">'+ value +'</option>');
		          	});
	        	}
	          
	        })
	        .fail(function (data) {
	          // body...
	          $("#result").html('There was an error please contact administrator');
	        });


	        $("#result").html('');
	      } else {
	        $("#term").val("");
	        $("#grade").val("");
	        $("#term").attr('disabled','disabled');
	        $("#subject").attr('disabled','disabled');
	        $("#result").html('');
	      }
	   	});

	   // a subject should be selected before the term select list field is enable
	   // for selection
	   	$(document).on('change', '#subject', function(event) {
	      event.preventDefault();
	      /* Act on the event */

	      // hide all errors
	      $('.errors').addClass('hidden');
	    
	      var subject = $('#subject').val();
	      var grade = $('#grade').val();
	      var term = $('#term').val();


	      if (subject != '') {
	        $("#term").removeAttr('disabled');
	      } else {
	        $("#term").val("");
	        $("#term").attr('disabled',true);
	        $("#result").html('');
	      }
	    });

	   // when grades, subjects and terms have been then an ajax call
	   // is made that displays students in relation to the options selected
	   	$(document).on('change', '.subjects-terms', function(event) {
	      event.preventDefault();
	      /* Act on the event */

	      $('.errors').addClass('hidden');
	    
	      var subject = $('#subject').val();
	      var grade = $('#grade').val();
	      var term = $('#term').val();

	      if (subject != "" && term != "" && subject != "") {

	        $(document).ajaxStart(function() {
	          $(".overlay").css("display", "block");
	        });

	        $(document).ajaxStop(function() {
	          $(".overlay").css("display", "none");
	        });

	        $.ajax({
	          url:"/users/scores/students-scores",
	          method:"GET",
	          data:{"subject_id":subject, "grade_id":grade, "term_id":term},
	          dataType:"text",
	          success:function(data){
	            $("#result").html(data);
	            $("#scores-table").DataTable({
	            	"aoColumnDefs" : [
			       {
			         'bSortable' : false,
			         'aTargets' : ['actions', 'text-holder' ]
			       }]
	            });
	          },
	          error:function(){
	            $("#result").html('There was an error please contact administrator');
	          }
	        });
	      } else {
	        $("#result").html('');
	      }
	   });
	</script>
@endsection