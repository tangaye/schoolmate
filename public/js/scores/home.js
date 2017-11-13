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

	var gradeDiv = $('.grade-div');
  	var subjectDiv = $('.hidden-subjectTerm-div');

	if (grade != "") {

		$(document).ajaxStart(function() {
		  $(".overlay").css("display", "block");
		});

		$(document).ajaxStop(function() {
		  $(".overlay").css("display", "none");
		});

		if (!gradeDiv.hasClass('col-md-4')) {
	      $('.grade-div').removeClass('fadeOut animated zoomIn col-md-12').addClass('col-md-4');
	      $('.hidden-subjectTerm-div').removeClass('hidden').show().addClass('animated fadeInRight col-md-4');
	    } 

		$("#subject").removeAttr('disabled');

		$.get('/grades/grade-subjects/'+grade)
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

	    $('.hidden-subjectTerm-div').removeClass('fadeInRight').addClass('hidden');
	    $('.grade-div').removeClass('col-md-4').addClass('fadeOut col-md-12 animated zoomIn');

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


	if (subject != '') {
		$("#term").removeAttr('disabled');
	} else {

		 // remove fading and animation fro divs
	    $('.hidden-subjectTerm-div').removeClass('fadeInRight').addClass('hidden');
	    $('.grade-div').removeClass('col-md-4').addClass('fadeOut col-md-12 animated zoomIn');

	    $("#grade").val("");
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

	if (subject != "" && term != "" && grade != "") {

		$(document).ajaxStart(function() {
		  $(".overlay").css("display", "block");
		});

		$(document).ajaxStop(function() {
		  $(".overlay").css("display", "none");
		});

		$.ajax({
		  url:"/scores/students-scores",
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

/*
************************************************************************************
* 							AFTER SCORES HAVE BEEN LOADED
*************************************************************************************
*/

// prepare edit modal
$(document).on('click', '.edit-score', function(event) {
	event.preventDefault();
	/* Act on the event */
	// hide all errors

	// set the hidden score id
	$('#score-id').val($(this).data('id'));

	// set the hidden student id
	$('#student-id').val($(this).data('studentid'));

	//setting the student name
	$('#edit-name').val($(this).data('name'));

	// setting the subject name
	$('#edit-subject').val($(this).data('subject'));

	// setting the grade/class name
	$('#edit-grade').val($(this).data('grade'));

	// setting the student score
	$('#edit-score').val($(this).data('score'));

	// subject to be edited id
	var id = $(this).attr('data-id');

	$('.name-error').addClass('hidden');
	$('.errors').addClass('hidden');


	// display the add modal
	$('#edit-modal').modal({
		show: true,
		backdrop:'static',
		keyboard:false
	});
});

// update student score
$(document).on('click', '#update-score', function(event) {
	event.preventDefault();
	/* Act on the event */

	// getting the score id to be updated
	var id = $('#score-id').val();
	var score = $("#edit-score").val();

	if (score >= 59 && score <= 100){

		$(document).ajaxStart(function() {
	      $(".overlay").css("display", "block");
	    });

	    $(document).ajaxStop(function() {
	      $(".overlay").css("display", "none");
	    });
    
		$.ajax({
			url: '/scores/terms/update/'+id,
			type: 'PUT',
			data: $("#score-form").serialize(),
		})
		.done(function(data) {

			// if the validator bag returns error display error in modal
			if (data.errors) {
	    		$('.errors').removeClass('hidden');
				var errors = '';
	            for(datum in data.errors){
	                errors += data.errors[datum] + '<br>';
	            }
	            $('.errors').show().html(errors); 

	        } else if (data.success){
	        	// Hide the modal
	        	$("#edit-modal").modal('hide');

	        	var score_id = data.score[0].id;
	        	var student_id = data.score[0].student_id;

	        	var student_code  = data.score[0].student.student_code;
	        	var name  = data.score[0].student.first_name+" "+data.score[0].student.surname;
	        	var subject = data.score[0].subject.name;
	        	var grade = data.score[0].grade.name;
	        	var score = data.score[0].score;
	        	var term = data.score[0].term.name;

	        	// prepare row of grade details to append to table
	        	var row = '<tr class="score'+score_id+'">';
	        		row += '<td><a href="/students/edit/'+student_id+'">'+student_code+'</a></td>';
	        		row += '<td>'+name+'</td>';

	        		if (score <= 69) {
	        			row += '<td style="color:red;">'+score+'</td>';
	        		} else {
	        			row += '<td>'+score+'</td>';
	        		}

	        		row += '<td><a class="edit-score" data-id="'+score_id+'" data-name="'+name+'" data-grade="'+grade+'" data-subject="'+subject+'" data-score="'+score+'" data-studentid="'+student_id+'" data-toggle="tooltip" title="Edit" href="#" role="button"><i class="glyphicon glyphicon-edit text-info"></i></a>  &nbsp;';

	        		row += '<a class="delete-score" data-id="'+score_id+'" data-toggle="tooltip" title="Delete" href="#" role="button"><i class="glyphicon glyphicon-trash text-danger"></i></a></td>';
	        	row += '</tr>';
		
				// replace subject row with updated details of subject
		        $(".score" + score_id).replaceWith(row);

	        	// notify user
	        	big_notify(data.success);
	        } 
	    
		})
		.fail(function(data) {
			console.log("error");
			$('.errors').removeClass('hidden');
			$('.errors').text('There was an error. Please try again, and if error persits contact administrator');
		});
	} else {
		$('.errors').removeClass('hidden');
	   	$('.errors').addClass('alert-warning');
	   	$('.errors').show().html('The score should be between 59 - 100.'); 
	}
});

$(document).on('click', '.delete-score', function(event) {
	event.preventDefault();
	/* Act on the event */

	// id of the row to be deleted
	var id = $(this).attr('data-id');

	// row to be deleted
	var row = $(this).parent("td").parent("tr");

	var message = "You won't be able to retrieve this score if you continue!";

	var route = "/scores/terms/delete/"+id;

	swal_delete(message, route, row);
});
