$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ajaxStart(function() {
	$(".overlay").css("display", "block");
});

$(document).ajaxStop(function() {
	$(".overlay").css("display", "none");
});

// on change of the academic years populate the grades select list element
// with grades the logged in teacher is/was teacher in the selected academic year
$(document).on('change', '#academic_id', function(event) {
	event.preventDefault();
	/* Act on the event */

	var academic_id = $('#academic_id').val();

	if (academic_id != "") {

		$.ajax({
			url: '/teacher/academic/grades/'+academic_id,
			type: 'GET',
		})
		.done(function(data) {
			if (data.none) {

				$("#grade").val("");
				$("#grade").attr('disabled', 'true');
				$("#subject").val("");
				$("#subject").attr('disabled', 'true');
				$("#term").attr('disabled', 'true');
				$("#result").html(data.none);
				
			} else {
				$("#result").html("");
				$("#grade").removeAttr('disabled');
				$('select[name="grade_id"]').empty();
			  	$('select[name="grade_id"]').append('<option value="">Select Grades</option>');
			  	$.each(data, function(key, value) {
			      	$('select[name="grade_id"]').append('<option value="'+ value.id +'">'+ value.name +'</option>');
			  	});
			}
		})
		.fail(function() {
			$("#result").html('There was an error please contact administrator');
		});
	} else {

		$("#grade").val("");
		$("#grade").attr('disabled', 'true');
		$("#subject").val("");
		$("#subject").attr('disabled', 'true');
		$("#term").attr('disabled', 'true');
		$("#result").html("");
	}
	
});
// on change of the grades select list the subject select list should be load up 
// with subjects that are taught in the selected grade/class
$(document).on('change', '#grade', function(event) {
	event.preventDefault();
	/* Act on the event */

	// hide all errors
	$('.errors').addClass('hidden');

	var academic_id = $('#academic_id').val();
	var grade = $('#grade').val();

	if (grade != "" && academic_id != "") {

		$.ajax({
			url: '/teacher/academic/grade/subjects',
			type: 'POST',
			data: {'grade_id':grade, 'academic_id':academic_id},
		})
		.done(function(data) {
			if (data.none) {
				$("#subject").val("");
				$("#subject").attr('disabled', 'true');
				$("#term").attr('disabled', 'true');
				$("#result").html(data.none);
			} else {
				$("#result").html('');
				$("#subject").removeAttr('disabled');
				$("#term").removeAttr('disabled');

				$('select[name="subject_id"]').empty();
			  	$('select[name="subject_id"]').append('<option value="">Select Subjects</option>');
			  	$.each(data, function(key, value) {
			      	$('select[name="subject_id"]').append('<option value="'+ key +'">'+ value +'</option>');
			  	});
			}
		})
		.fail(function() {
			$("#result").html('There was an error please contact administrator');
		});
		
	} else {

		$("#term").attr('disabled','disabled');
		$('select[name="subject_id"]').empty();
		$("#subject").attr('disabled','disabled');
		$("#result").html('');
	}
});


// when grades, subjects and terms have been then an ajax call
// is made that displays students scores in relation to the options selected
$(document).on('change', '.search_fields', function(event) {
	event.preventDefault();
	/* Act on the event */

	var subject = $('#subject').val();
	var grade = $('#grade').val();
	var term = $('#term').val();
	var academic_id = $('#academic_id').val();

	if (subject != "" && term != "" && grade != "" && academic_id != "") {

		$.ajax({
		    url:"/teacher/students-scores",
		    method:"GET",
		    data:{"grade_id":grade, "subject_id":subject, "term_id":term, "academic_id":academic_id},
		    success:function(data){

		    	if (data.none) {
		    		$("#result").html(data.none);
		    	} else {

		    		$("#result").html(data);
				    var print_title = $(".print-title").text();
				    $('#scores-table').DataTable({
				      	dom: 'Bfrtip',
					    buttons: [
					        {
					          extend: 'excel',
					          text: '<i class="fa fa-file-excel-o"></i> Excel',
					          title: print_title,
					          exportOptions: {
					            columns: ':not(.noExport)'
					          }
					        },
					        {
					          extend: 'pdf',
					          text: '<i class="fa fa-file-pdf-o"></i> PDF',
					          title: print_title,
					          exportOptions: {
					           columns: ':not(.noExport)'
					          }
					        },
					        {
					          extend: 'print',
					          text: '<i class="fa fa-print"></i> Print',
					          title: print_title,
					          exportOptions: {
					            columns: ':not(.noExport)'
					          }
					        }
					    ]
				    });
		    	}
		    },
		    error:function(){
		      $("#result").html('There was an error please contact administrator');
		    }
		});
	} else {
		$("#result").html('Please make sure you have all fields selected.');
	}
});