@extends('layouts.master')

@section('page-title', 'Scores')

@section('meta')
	<meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('page-css')
	<!-- Animate css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />

	\
@endsection

@section('page-header', 'Scores')


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

         					<span class="input-group-addon">Subject</span>
                  			<select name="subject_id" id="subject" class="form-control search-field">
                  				<option value="">Select Subject</option>
                  				@foreach($subjects as $subject)
		                  			<option value="{{$subject->id}}">{{$subject->name}}</option>
		                  		@endforeach
                  			</select>
                  
	                  		<span class="input-group-addon">Grades/Class</span>
		                  	<select disabled="true" name="grade_id" class="form-control search-field" id="grade">
		                  		<option value="">Select Grade/Class</option>
		                  		@foreach($grades as $grade)
		                  			<option value="{{$grade->id}}">{{$grade->name}}</option>
		                  		@endforeach
		                  	</select>

	                  		<span class="input-group-addon">Term</span>
	                  		<select disabled="true" name="term_id" class="form-control search-field" id="term">
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
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		
		$('.search-field').on('change', function(event) {
	      	event.preventDefault();

	      	// hide all errors
	      	$('.errors').addClass('hidden');

	      	/* Act on the event */
	        var subject = $('#subject').val();
	        var grade = $('#grade').val();
	        var term = $('#term').val();

	        if (subject != "") {
	        	$("#term").removeAttr('disabled');
	        	$("#grade").removeAttr('disabled');
	        	$("#result").html('');
	        } else {
	        	$("#term").val("");
	        	$("#grade").val("");
	        	$("#term").attr('disabled','disabled');
	        	$("#grade").attr('disabled','disabled');
	        	$("#result").html('');
	        }
	        if (grade != "" && term != "") {
	        	$.ajax({
	            url:"/scores/master/create",
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

	    $(document).on('click', '.save-score', function(event) {
	    	event.preventDefault();
	    	/* Act on the event */

	    	var student = $(this).parents('tr').find(".student").val();
	        var grade = $(this).parents('tr').find(".grade").val();
	        var subject = $(this).parents('tr').find(".subject").val();
	        var score = $(this).parents('tr').find(".score").val();
	        var term = $(this).parents('tr').find(".term").val();

	    	var row = $(this).parent("td").parent("tr");

	    	if (score >= 59 && score <= 100) {
	    		$.ajax({
		    		url: '/scores',
		    		type: 'POST',
		    		dataType: 'json',
		    		data: {"student_id":student, "grade_id":grade, "subject_id":subject, "term_id":term, "score":score},
		    	})
		    	.done(function(data) {
		    		console.log("success");
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
		            }
		    	})
		    	.fail(function() {
		    		console.log("error");
		    		$('.errors').removeClass('hidden');
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