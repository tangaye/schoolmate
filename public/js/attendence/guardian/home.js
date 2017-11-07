$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$("#student").select2();

$(document).ajaxStart(function() {
  $(".overlay").css("display", "block");
});

$(document).ajaxStop(function() {
  $(".overlay").css("display", "none");
});

$('#student').on('change', function(event) {
  	event.preventDefault();

  	/* Act on the event */
    var student = $('#student').val();
    var studentDiv = $('.student-div');

    if (student != '') {
    	if (!studentDiv.hasClass('col-md-4')) {
	      $('.student-div').removeClass('fadeOut animated zoomIn col-md-12').addClass('col-md-4');
	      $('.hidden-years-dates').removeClass('hidden').show().addClass('animated fadeInRight col-md-4');
	    } 

    	$("#years").removeAttr('disabled');
    } else {

        $('.hidden-search-div').removeClass('fadeIn').addClass('hidden');
    	$('.hidden-years-dates').removeClass('fadeInRight').addClass('hidden');
    	$('.student-div').removeClass('col-md-4').addClass('fadeOut col-md-12 animated zoomIn');
    	$("#years").attr('disabled', 'true');
    	$("#dates").attr('disabled', 'true');
        $("#years").val("");
        $("#dates").val("");
    	$("#result").html('');

    }   

});

$('#years').on('change', function(event) {
  	event.preventDefault();

  	/* Act on the event */
    var year = $('#years').val();

    if (year != '') {

    	$.get('/attendence/years/'+year)
	    .done(function (data) {

	      $('select[name="date"]').empty();
	      $('select[name="date"]').append('<option value="">Select Dates</option>');

	      $.each(data, function() {
	        $.each(this, function(key, value) {
	          $('select[name="date"]').append('<option value="'+ key +'">'+ value +'</option>');
	        });
	      });
	      
	    })
	    .fail(function (data) {
	      // body...
	      $("#result").html('There was an error please contact administrator');
	    });

    	$("#dates").removeAttr('disabled');


    } else {

    	// reset student list
		$("#student").select2('val', 'All');
        $("#dates").val("");
        $('.hidden-search-div').removeClass('fadeIn').addClass('hidden');
    	$('.hidden-years-dates').removeClass('fadeInRight').addClass('hidden');
    	$('.student-div').removeClass('col-md-4').addClass('fadeOut col-md-12 animated zoomIn');

    	$("#dates").attr('disabled', 'true');
    	$("#result").html('');

    }   

});


$('#dates').on('change', function(event) {
  	event.preventDefault();

  	/* Act on the event */
    var dates = $('#dates').val();
    var year = $('#years').val();
    var student = $('#student').val();

    if (year != '' && dates != '' && student != '') {

        $('.hidden-search-div').removeClass('hidden').show().addClass('animated fadeIn');
        $('.search-btn').removeAttr('disabled');

    } else {

    	// reset student list
		$("#student").select2('val', 'All');
    	// empty date list
    	$('select[name="date"]').empty();

        $('.hidden-search-div').removeClass('fadeIn').addClass('hidden');
    	$('.hidden-years-dates').removeClass('fadeInRight').addClass('hidden');
        $('.hidden-search-div').removeClass('fadeIn').addClass('hidden');
    	$('.student-div').removeClass('col-md-4').addClass('fadeOut col-md-12 animated zoomIn');

    	$("#years").val("");
    	$("#years").attr('disabled', 'true');
    	$("#result").html('');

    }   

});


//when search btn is click display attendence based
//on the date, grade, and student specify
$(document).on('click', '.search-btn', function(event) {
 event.preventDefault();
 /* Act on the event */

    var date = $('#dates').val();
    var year = $('#years').val();
    var student = $('#student').val();

    if (year != '' && date != '' && student != '') {

    $.ajax({
          url: '/guardian/attendence/students',
          type: 'GET',
          dataType: 'html',
          data: {'student_id':student, 'date':date},
        })
        .done(function(data) {
          $("#result").html(data);
        })
        .fail(function() {
          $("#result").html("An error occur! Please try again, if problem persists contact administrator.");
        });
        

    } else {
        $("#date").val("");
        $("#date").attr('disabled','disabled');
        $("#years").val("");
        $("#years").attr('disabled','disabled');
        $('select[name="date"]').empty();
        $("#date").val("");
        $("#date").attr('disabled','disabled');
        $(".search-btn").attr('disabled','disabled');
        $("#result").html('Please make sure you have date, grade, years and subject specify! All are required to view attendence');
    }
});


