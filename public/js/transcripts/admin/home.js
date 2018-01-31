$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$(document).ready(function($) {

	$(document).ajaxStart(function() {
	  $(".overlay").css("display", "block");
	});

	$(document).ajaxStop(function() {
	  $(".overlay").css("display", "none");
	});

	$(document).on('click', '.print-btn', function(event) {
	    event.preventDefault();
	    /* Act on the event */
	    var title = $('.title').val();
	    printReport('transcript', title);
	});


	//Initialize Select2 Elements
	$(".student").select2();

	

	$(".student").on('change', function(event) {
		event.preventDefault();
		/* Act on the event */

		$(".print-div").addClass('hidden');
		$("#message").html("");

		var student_id = $(".student").val();

		if (student_id != "") {

			$.ajax({
				url: '/transcripts/setup',
				method: 'POST',
				data: {"student_id":student_id},
			})
			.done(function(data) {
				$("#result").html(data);
			})
			.fail(function(data) {
				$("#message").html("An error occur! Try again, if problem persists contact administrator.");
				$("#result").html("");
			});
			
		} else {
			$("#message").html("Please select the student you want to view transcript for.");
			$("#result").html("");
			$(".print-div").addClass('hidden');
		}
	});

	/* When a student has been in four(4) or more grades and the grades are returned,
	* the user now have to select three(3) of the four(4) or more grades returned to
	* generate the student transcript.
	* One cannot generate transcript for four(4) or more grades.
	*/
	var limit = 3;

	$(document).on('change', 'input.grade-checkbox', function(event) {
		event.preventDefault();
		/* Act on the event */
		if($("input[class='grade-checkbox']:checked").length > 0 && $("input[class='grade-checkbox']:checked").length <= limit) {
            $(".generate_transcript").removeAttr('disabled');
        } else if ($("input[class='grade-checkbox']:checked").length > limit) {
        	this.checked = false;
        }
        else {
        	$(".generate_transcript").attr('disabled', 'true');
        	$("#transcript").html("");
        	$(".print-div").addClass('hidden');
        }
	});

	$(document).on('click', '.generate_transcript', function(event) {
		event.preventDefault();
		/* Act on the event */
		

		$.ajax({
			url: '/transcripts/generate',
			method: 'POST',
			data: $("#transcript_form" ).serialize(),
		})
		.done(function(data) {
			if (data.none) {
				$("#message").html(data.none);
				$(".print-div").addClass('hidden');
			} else {
				$("#transcript").html(data);
				$(".print-div").removeClass('hidden');
				$("#message").html("");
			}
			
		})
		.fail(function(data) {
			$("#message").html("An error occur! Try again, if problem persists contact administrator.");
			$("#result").html(data);
		});
	});

});