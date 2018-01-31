$(document).ready(function($) {
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

	function enrolled_students(academic_id) {
		if (academic_id != "") {
			$.ajax({
				url: '/enrollments/academic-students/'+academic_id,
				type: 'GET',
				dataType: 'html',
			})
			.done(function(data) {
				$("#result").html(data);
			})
			.fail(function() {
				$("#result").html("An error occur! Try again and if problem persits contact administrator");
			});

		} else {
			$("#result").html("To view enrollment details please select a specific academic year.");
		}

	}

	// when the page is loaded and ready and academic year is selected
	// as should be the case. An ajax call is made that returns a table
	// which contains students with enrollment details within the selected
	// academic year.
	var academic_id = $("#academic").val();
	enrolled_students(academic_id);

	// on change of the academic year display the student 
	// enrollment table for the specify academic year
	$("#academic").on('change', function(event) {
		event.preventDefault();
		/* Act on the event */

		var academic_id = $("#academic").val();
		enrolled_students(academic_id);
	});

	// when the new enrollment button is click display the new enrollment modal
	// form
	$(document).on('click', '.new_enrollment', function(event) {
		event.preventDefault();
		/* Act on the event */
		// display the add modal
		$('#enrollment-modal').modal({
			show: true,
			backdrop:'static',
			keyboard:false
		});

		$('.errors').addClass('hidden');
		$("#enrollment-form")[0].reset();

		$.ajax({
			url: '/enrollments/unenrolled-students',
			type: 'GET',
			dataType: 'JSON',
		})
		.done(function(data) {

			if (data.none) {
				$('select[name="student_id"]').empty();
		        $('select[name="student_id"]').append('<option value="">'+data.none+'</option>');
			} else {
				
				//Initialize Select2 Elements
				$(".student").select2();

				$('select[name="student_id"]').empty();
				$('select[name="student_id"]').append('<option value="">Select Students</option>');
				$.each(data, function(key, value) {
		          $('select[name="student_id"]').append('<option value="'+ value.id +'"> ('+value.student_code+') '+value.first_name+' '+value.surname+'</option>');
		        });
			}
		})
		.fail(function() {
			$('.errors').removeClass('hidden');
			$('.errors').text('There was an error. Please try again, and if error persits contact administrator');
		});
		
	});

	// when a student is selected enabled disable fields that are to be
	// enable (last grade, current grade and enrollment status) and  set 
	// the student status.
	$("#student").on('change', function(event) {
		event.preventDefault();
		/* Act on the event */
		var student_id = $("#student").val();
		if (student_id != "") {
			$.ajax({
				url: '/enrollments/student-exists/'+student_id,
				type: 'GET',
				dataType: 'JSON',
			})
			.done(function(data) {
				$(".enrollment_status").removeAttr('disabled');
				$("#last_grade").removeAttr('disabled');
				$("#current_grade").removeAttr('disabled');
				$("#student_type").val(data.student_type);
			})
			.fail(function() {
				$(".errors").html("An error occur. Try again, and if problem persists contact administrator.");
			});
			
		} else {
			$(".enrollment_status").attr('disabled', 'true');
			$("#last_grade").attr('disabled', 'true');
			$("#current_grade").attr('disabled', 'true');
			$(".save-enrollment").attr('disabled', 'true');
			$(".enrollment_status").val("");
		}
	});

	// when the student enrollment status is selected enable the "Enroll Student"
	// button other wise disabled it.
	$(".enrollment_status").on('change', function(event) {
		event.preventDefault();
		/* Act on the event */
		var enrollment_status = $(".enrollment_status").val();
		if (enrollment_status != "") {
			$(".save-enrollment").removeAttr('disabled');
		} else {
			$(".save-enrollment").attr('disabled', 'true');
		}
	});

	$(".save-enrollment").on('click', function(event) {
		event.preventDefault();
		/* Act on the event */

		var enrollment_status = $(".enrollment_status").val();
		var student_id = $("#student").val();
		var academic_id = $("#academic").val();
		var last_grade = $("#last_grade").val();
		var current_grade = $("#current_grade").val();
		var student_type = $("#student_type").val();

		if (enrollment_status != "" && student_id != "" && academic_id != "" && last_grade != "" && current_grade != "" && student_type != "") {
			$.ajax({
				url: '/enrollments',
				type: 'POST',
				data: {"enrollment_status": enrollment_status, "student_id":student_id, "academic_id":academic_id, "last_grade":last_grade, "current_grade":current_grade, "student_type":student_type},
			})
			.done(function(data) {
				if (data.errors) {
	        		$('.errors').removeClass('hidden');
	    			var errors = '';
	                for(datum in data.errors){
	                    errors += data.errors[datum] + '<br>';
	                }
	                $('.errors').show().html(errors); 

	            } else {
	       
	            	// hide the bootstrap dialog
	            	$("#enrollment-form")[0].reset();
	            	$('#enrollment-modal').modal('hide');

	            	//refresh the enrollments table
	            	enrolled_students(academic_id);

	            	// notify the record was updated
	            	var message = data.success;
	            	big_notify(message);
	            }
			})
			.fail(function() {
				$('.errors').removeClass('hidden');
				$('.errors').text('There was an error. Please try again, and if error persits contact administrator');
			});
			
		} else {
			$(".save-enrollment").attr('disabled', 'true');
			$(".enrollment_status").attr('disabled');
			$("#last_grade").attr('disabled');
			$("#current_grade").attr('disabled');

			$('.errors').removeClass('hidden alert-danger').addClass('alert-warning');
			$('.errors').text('There was an error. Please try again, and if error persits contact administrator');
		}
	});

	

});

