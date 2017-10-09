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
</ul>
<!-- /.sidebar-menu -->
@endsection


@section('content')


	<div class="row">
		<div class="col-md-12">

			<!-- div to display errors returned by server-->
            <div class="errors alert hidden">
            </div>
            <!-- end of errors div -->

         	<div class="panel">
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

	<script src="{{ asset ("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.min.js") }}"></script>

	<script type="text/javascript">

	 $.ajaxSetup({
		  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
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
   // is made that displays students in relation to the options selected
   $(document).on('change', '.subjects-terms', function(event) {
      event.preventDefault();
      /* Act on the event */

      $('.errors').addClass('hidden');
    
      var subject = $('#subject').val();
      var grade = $('#grade').val();
      var term = $('#term').val();

      if (subject != "" && term != "" && subject != "") {
        $.ajax({
          url:"/teacher/manage-scores/create",
          method:"GET",
          data:{"subject_id":subject, "grade_id":grade, "term_id":term},
          dataType:"text",
          success:function(data){
            $("#result").html(data);
          },
          error:function(){
            $("#result").html('There was an error please contact administrator');
          }
        });
      } else {
        $("#result").html('');
      }
   });

   // after the results have been returned this handles inserting students grades
  $(document).on('click', '.save-score', function() {
  	/* Act on the event */

     var student = $(this).parents('tr').find(".student").val();
     var grade = $(this).parents('tr').find(".grade").val();
     var subject = $(this).parents('tr').find(".subject").val();
     var score = $(this).parents('tr').find(".score").val();
     var term = $(this).parents('tr').find(".term").val();
     var row = $(this).parent("td").parent("tr");

  	if (score >= 59 && score <= 100) {
  		$.ajax({
    		url: '/teacher/manage-scores',
    		type: 'POST',
    		dataType: 'json',
    		data: {"student_id":student, "grade_id":grade, "subject_id":subject, "term_id":term, "score":score},
    	})
    	.done(function(data) {
    		if (data.errors) {
        	$('.errors').removeClass('hidden');
        	$('.errors').addClass('alert-danger');
    			var errors = '';
                for(datum in data.errors){
                    errors += data.errors[datum] + '<br>';
                }
                $('.errors').show().html(errors); 
            } 
            else if (data.duplicate){
            	$('.errors').removeClass('hidden');
            	$('.errors').addClass('alert-warning');
            	$('.errors').show().html(data.duplicate); 
            }
            else if (data.success){
            	 // fading out the record that was inserted
              	jQuery(row).fadeOut('slow');

              	// notify user
              	big_notify(data.success);
                $('.errors').addClass('hidden');
            }
    	})
    	.fail(function() {
        $('.errors').removeClass('hidden');
        $('.errors').addClass('alert-warning');
			  $('.errors').show().html('An error occur. Please try again. If problem persists contact administrator'); 
    	});
  	} else {
  		$('.errors').removeClass('hidden');
      $('.errors').addClass('alert-warning');
       $('.errors').show().html('The score should be between 59 - 100.'); 
  	}
  });
	</script>
@endsection