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

		$.get('/teacher/grade-subjects/'+grade)
		.done(function (data) {
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
	var grade = $('#grade').val();
	var term = $('#term').val();


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