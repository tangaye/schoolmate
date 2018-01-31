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

// on change of academic_years query out all dates within that year and populate
// the dates select element with data gotten
$(document).on('change', '#academic_years', function(event) {
  event.preventDefault();
  /* Act on the event */

  var academic_year_id = $("#academic_years").val();

  if (academic_year_id != "") {

    $.ajax({
      url: '/attendence/academic/'+academic_year_id,
      type: 'GET',
    })
    .done(function(data) {
      if (data.none) {

        $("#result").html(data.none);
        $("#date").attr('disabled', 'true');
        $('select[name="date"]').empty();
        $("#student").attr('disabled', 'true');
        $('select[name="student_id"]').empty();
      } else {

        $("#result").html("");

        $("#date").removeAttr('disabled');
        $('select[name="date"]').empty();
        $('select[name="date"]').append('<option value="">Select Dates</option>');

        $.each(data, function() {
          $.each(this, function(key, value) {
            $('select[name="date"]').append('<option value="'+ key +'">'+ value +'</option>');
          });
        });
      }
    })
    .fail(function() {
      $("#result").html('There was an error please contact administrator');
    });
  } else {

    $('select[name="date"]').empty();
    $("#date").attr('disabled','disabled');
    $("#student").attr('disabled', 'true');
    $('select[name="student_id"]').empty();
    $("#result").html('');
  }
});

// on change of the date query all students who have attendence recorded for
// them on the date selected and are assigned to the guardian logged id.
$(document).on('change', '#date', function(event) {
    event.preventDefault();
    /* Act on the event */

    var date = $("#date").val();
    var academic_id = $("#academic_years").val();

    if (date != "" && academic_id != "") {
        $.ajax({
            url: '/guardian/attendence/students/'+date,
            type: 'GET',
        })
        .done(function(data) {
            if (data.none) {
                $("#result").html(data.none);
            } else {

                $("#result").html("");

                $("#student").removeAttr('disabled');
                $('select[name="student_id"]').empty();
                $('select[name="student_id"]').append('<option value="">Select Student</option>');

                $.each(data, function(key, value) {
                    $('select[name="student_id"]').append('<option value="'+ value.id +'">'+'('+value.student_code+')'+ value.first_name+' '+value.middle_name+' '+value.surname+'</option>');
                });
            }
        })
        .fail(function() {
            $("#result").html("An error occur. Try again and if problem persists please contact administrator.");
        });
        
    } else {
        $("#result").html("");
    }
});

$(document).on('change', '#student', function(event) {
    event.preventDefault();

    /* Act on the event */
    var date = $("#date").val();
    var academic_id = $("#academic_years").val();
    var student = $("#student").val();
    
    if (student != "" && date != "" && academic_id != "") {
        $.ajax({
          url: '/guardian/attendence/students',
          type: 'Post',
          data: {'student_id':student, 'date':date},
        })
        .done(function(data) {
          $("#result").html(data);
        })
        .fail(function() {
          $("#result").html("An error occur! Please try again, if problem persists contact administrator.");
        });
    } else {
        // statement
    }
});

