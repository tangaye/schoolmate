$(document).ready(function() {

  //Initialize Select2 Elements
  $("#student").select2();

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
    printReport('result', title);
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
          url: '/scores/academic-students/'+academic_id,
          type: 'GET',
          dataType: 'JSON',
        })
        .done(function(data) {
          if (data.none) {
            $('#student').attr('disabled', 'disabled');
            $('select[name="student_id"]').empty();
            $("#result").html(data.none);
          } else {

            $(".print-div").addClass('hidden');
            $("#student").removeAttr('disabled');
            $("#result").html('');

            $('select[name="student_id"]').empty();
            $('select[name="student_id"]').append('<option value="">Select Students</option>');
            $.each(data, function(key, value) {
                $('select[name="student_id"]').append('<option value="'+ value.id +'">'+'('+value.code+')'+ value.first_name+' '+value.middle_name+' '+value.surname+'</option>');
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
        $("#result").html('');
        $(".print-div").addClass('hidden');
      }
    });

    $('#student').on('change', function(event) {
      event.preventDefault();
      /* Act on the event */

      var student_id = $('#student').val();
      var academic_id = $('#academic').val();

      if (student_id != "" && academic_id != "") {

        $.ajax({
          url:"/scores/report/annual",
          type: 'POST',
          data:{"student_id":student_id, "academic_id":academic_id},
        })
        .done(function(data) {
          if (data.none) {
            $("#result").html(data.none);
            $(".print-div").addClass('hidden');
          } else {
            $("#result").html(data);
            $(".print-div").removeClass('hidden');
          }
        })
        .fail(function() {
          $('#result').html('There was an error. Please try again, if problem persits please contact adminstrator');
        });
      } else {
        $("#result").html('To view report please make sure you have all the fields selected.');
        $(".print-div").addClass('hidden');
      }
    });
	});