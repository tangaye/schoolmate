@extends('layouts.master')

@section('page-title', 'Students Scores')

@section('page-css')
	<!-- datatables -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.css") }}" rel="stylesheet" type="text/css" />

  	<link href="{{ asset("/bower_components/AdminLTE/plugins/datatables/buttons.bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header', 'Students Scores')

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

</ul>
<!-- /.sidebar-menu -->
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
			                    @foreach($teacher_grades as $grade)
			                      <option value="{{$grade->id}}">{{$grade->name}}</option>
			                    @endforeach
			                  </select>	

			                <span class="input-group-addon">Subject</span>
	            			<select disabled="true" name="subject_id" id="subject" class="form-control subjects-terms">
	            			</select>

	                  		<span class="input-group-addon">Term</span>
		            		  <select disabled="true" name="term_id" class="form-control subjects-terms" id="term">
		            			   <option value="">Select term</option>
		              			   @foreach($terms as $term)
		              			     <option value="{{$term->id}}">{{$term->name}}</option>
		              		    @endforeach
	         				</select>
	         			</div>
	         		</div>
	         		<div id="result"></div>
	         	</div>
         	</div>
	    </div>
	</div>

@endsection

@section('page-scripts')

	<script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js") }}"></script>
  <script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>

   <script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/dataTables.buttons.min.js") }}"></script>
   <script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/buttons.bootstrap.min.js") }}"></script>

   <script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/jszip.min.js") }}"></script>
   <script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/pdfmake.min.js") }}"></script>
   <script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/vfs_fonts.js") }}"></script>

   <script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/buttons.print.min.js") }}"></script>

   <script src="{{ asset ("/bower_components/AdminLTE/plugins/datatables/buttons.html5.min.js") }}"></script>

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

	        $.get('/teacher/grade-subjects/'+grade)
	        .done(function (data) {
	          // body...
	          $('select[name="subject_id"]').empty();
	          $('select[name="subject_id"]').append('<option value="">Select Subjects</option>');
	          $.each(data, function(key, value) {
	              $('select[name="subject_id"]').append('<option value="'+ key +'">'+ value +'</option>');
	          });
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
	   // is made that displays students scores in relation to the options selected
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
	            url:"/teacher/students-scores",
	            method:"GET",
	            data:{"grade_id":grade, "subject_id":subject, "term_id":term},
	            success:function(data){
	              $("#result").html(data);
	              $('#scores-table').DataTable({
	              	dom: 'Bfrtip',
				      buttons: [
				        {
				          extend: 'excel',
				          title: 'Scores Report',
				          text: '<i class="fa fa-file-excel-o"></i> Excel',
				          exportOptions: {
				            columns: ':not(.noExport)'
				          }
				        },
				        {
				          extend: 'pdf',
				          title: 'Scores Report',
				          text: '<i class="fa fa-file-pdf-o"></i> PDF',
				          exportOptions: {
				           columns: ':not(.noExport)'
				          }
				        },
				        {
				          extend: 'print',
				          title: 'Scores Report',
				          text: '<i class="fa fa-print"></i> Print',
				          exportOptions: {
				            columns: ':not(.noExport)'
				          }
				        }
				      ]
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