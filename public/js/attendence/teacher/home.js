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
        $("#date").val("");
        $("#date").attr('disabled','disabled');
        $("#grade").val("");
        $("#grade").attr('disabled', 'true');
        $("#subject").val("");
        $("#subject").attr('disabled','disabled');

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

    $("#grade").val("");
    $("#grade").attr('disabled', 'true');
    $("#subject").val("");
    $("#subject").attr('disabled','disabled');
    $("#date").val("");
    $("#date").attr('disabled','disabled');
    $("#result").html('');
  }
});

// On change of the date display a listing of grades/classes that have
// attendence recorded for them on on the date selected and in the academic
// year selected. Grades returned are grades that the teacher logged in is 
// teaching
$(document).on('change', '#date', function(event) {
  event.preventDefault();
   /* Act on the event */

  var academic_year_id = $('#academic_years').val();
  var date = $('#date').val();

  if (date != "" && academic_years != "") {
    $.ajax({
      url: '/teacher/attendence/date/grades',
      type: 'POST',
      data: {"date": date, "academic_id":academic_year_id},
    })
    .done(function(data) {
      if (data.none) {
        $("#result").html(data.none);
        $("#grade").val("");
        $("#grade").attr('disabled', 'true');
        $("#subject").val("");
        $("#subject").attr('disabled','disabled');
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
    $("#subject").attr('disabled','disabled');
    $("#result").html('');
  }
});

// on change of the grades select list the subject select list should be load up 
// with subjects that are taught in the selected grade/class. The subjects returned
// should be subjects the logged in teacher is teaching.
$(document).on('change', '#grade', function(event) {
  event.preventDefault();
  /* Act on the event */

  var grade = $('#grade').val();
  var academic_year_id = $('#academic_years').val();
  var date = $('#date').val();

  if (grade != "" && academic_year_id != "" && date != "") {


    $.ajax({
      url: '/teacher/academic/grade/subjects',
      type: 'POST',
      data: {'grade_id':grade, 'academic_id':academic_year_id},
    })
    .done(function(data) {
      if (data.none) {

        $("#result").html(data.none);
        $("#subject").val("");
        $("#subject").attr('disabled','disabled');

      } else {

        $("#result").html("");
        $("#subject").removeAttr('disabled');

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

    $("#subject").val("");
    $("#subject").attr('disabled','disabled');
    $("#result").html('');
  }
});

// on change of subject display recorded attendence of the academic year
// date, grade and subject specify.
$(document).on('change', '#subject', function(event) {
 event.preventDefault();
 /* Act on the event */

  var subject = $('#subject').val();
  var grade = $('#grade').val();
  var academic_year_id = $('#academic_years').val();
  var date = $('#date').val();

  if (subject != "" && grade != "" && academic_year_id != "" && date != "") {

    $.ajax({
      url: '/teacher/attendence/students/recorded',
      type: 'GET',
      dataType: 'html',
      data: {'subject_id':subject, 'grade_id':grade, 'date':date, 'academic_id':academic_year_id},
    })
    .done(function(data) {
      $("#result").html(data);
    })
    .fail(function() {
      $("#result").html("An error occur! Please try again, if problem persists contact administrator.");
    });

  } else {

    $("#result").html('Please make sure you have all the field selected to view attendence.');
  }
});


