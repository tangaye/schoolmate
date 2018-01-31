$(document).ready(function() {

	$("#student").select2();

	$(document).on('click', '.print-btn', function(event) {
	    event.preventDefault();
	    /* Act on the event */
	    var title = $('.title').val();
	    printReport('result', title);
	});


	$(document).ajaxStart(function() {
    	$(".overlay").css("display", "block");
  	});

  	$(document).ajaxStop(function() {
    	$(".overlay").css("display", "none");
  	});

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$('#academic').on('change', function(event) {
	    event.preventDefault();
	    /* Act on the event */

	    var academic_id = $('#academic').val();

	    if (academic_id != "") {

	      $.ajax({
	        url: '/guardian/students/'+academic_id,
	        type: 'GET',
	        dataType: 'JSON',
	      })
	      .done(function(data) {

	        if (data.none) {
	          $('#student').attr('disabled', 'disabled');
	          $('select[name="student_id"]').empty();
	          $('#term').attr('disabled', 'disabled');
	          $("#result").html(data.none);
	        } else {

	          $("#student").removeAttr('disabled');
	          $("#term").removeAttr('disabled');
	          $("#result").html('');

	          $('select[name="student_id"]').empty();
	          $('select[name="student_id"]').append('<option value="">Select Students</option>');
	          $.each(data, function(key, value) {
	              $('select[name="student_id"]').append('<option value="'+ value.id +'">'+'('+value.student_code+')'+ value.first_name+' '+value.surname+'</option>');
	          });
	        }
	      })
	      .fail(function() {
	        $("#result").html("An error occur! Please try again, and if problem persists contact administrator.");
	      });
	      
	    } else {
	      // empty students list
	      $('select[name="student_id"]').empty();
	      $('select[name="student_id"]').append('<option value="">Select Students</option>');
	      $('#student').attr('disabled', 'disabled');
	      $('#term').attr('disabled', 'disabled');
	      $("#result").html('');
	      $(".print-div").addClass('hidden');
	    }
	});


	$('.search-fields').on('change', function(event) {
      	event.preventDefault();

      	/* Act on the event */
        var student = $('#student').val();
        var term = $('#term').val();
        var academic_id = $('#academic').val();

        if (student != '' && term != '' && academic_id != '') {

          $.ajax({
          	url:"/guardian/students/term",
            method:"POST",
           	data:{"student_id":student, "term_id":term, "academic_id":academic_id},
           	success:function(data){
           		if (data.none) {
           			$("#result").html(data.none);
            		$(".print-div").addClass('hidden');
           		} else {
           			$("#result").html(data);
            		$(".print-div").removeClass('hidden');
           		}
           	}
          });
        } else {
          $("#result").html('');
          $(".print-div").addClass('hidden');
        }   

    });
});