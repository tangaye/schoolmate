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

// on change of the grades select list the subject select list should be load up 
// with subjects that are taught in the selected grade/class
$(document).on('change', '#grade', function(event) {
  event.preventDefault();
  /* Act on the event */

  var grade = $('#grade').val();
  var gradeDiv = $('.grade-div');
  var subjectDiv = $('.hidden-subject-div');

  if (grade != "") {

    if (!gradeDiv.hasClass('col-md-3')) {
      $('.grade-div').removeClass('fadeOut animated zoomIn col-md-12').addClass('col-md-6');
      $('.hidden-subject-div').removeClass('hidden').show().addClass('animated fadeInRight col-md-6');
    } else {
      
    }
    
    $("#subject").removeAttr('disabled');

    $.get('/grades/grade-subjects/'+grade)
    .done(function (data) {

      /*************************************************************************************
      * if no subject is returned then reshape the elements. if both the grade and subject 
      * elements are col-md-6 reset the subject select list and disable it whilst the message
      * returnd is display ("No subject found for the selected grade").
      *
      * If the both elements have the classes col-md-3 rather than col-md-6, then hide the 
      * search-btn and dates elements; then reshape both the subject and grade elements to 
      * have the class col-md-6
      **************************************************************************************/
      if (data.none) {
        $("#result").html(data.none);

        if (!subjectDiv.hasClass('col-md-3') && !gradeDiv.hasClass('col-md-3')) {
          $("#subject").val('');
          $("#subject").attr('disabled','disabled');
        } 
        else {
          $("#subject").val('');
          $("#subject").attr('disabled','disabled');

          $('.grade-div').removeClass('col-md-3').addClass('col-md-6');
          $('.hidden-subject-div').removeClass('col-md-3').addClass('animated fadeInRight col-md-6');
          $('.hidden-dates-div').removeClass('fadeInRight').addClass('hidden');
          $('.hidden-search-div').removeClass('shake').addClass('hidden');
        }

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

    $('.hidden-dates-div').removeClass('fadeInRight').addClass('hidden');
    $('.hidden-subject-div').removeClass('fadeInRight').addClass('hidden');
    $('.hidden-search-div').removeClass('shake').addClass('hidden');
    $('.grade-div').removeClass('col-md-6 col-md-3').addClass('fadeOut col-md-12 animated zoomIn');

    $("#subject").val("");
    $("#subject").attr('disabled','disabled');
    $("#years").val("");
    $("#years").attr('disabled','disabled');
    $("#date").val("");
    $("#date").attr('disabled','disabled');
    $("#result").html('');
  }
});

// on change of subject display years and dates elements
$(document).on('change', '#subject', function(event) {
 event.preventDefault();
 /* Act on the event */

  var subject = $('#subject').val();

  if (subject != "") {
    // fading and animation for divs
    $('.grade-div').removeClass('col-md-6').addClass('col-md-3');
    $('.hidden-subject-div').removeClass('col-md-6').addClass('col-md-3');
    $('.hidden-dates-div').removeClass('hidden').show().addClass('animated fadeInRight');
    $("#years").removeAttr('disabled');

  } else {

    // remove fadind and animation fro divs
    $('.hidden-dates-div').removeClass('fadeInRight').addClass('hidden');
    $('.hidden-subject-div').removeClass('fadeInRight').addClass('hidden');
    $('.grade-div').removeClass('col-md-4 col-md-3').addClass('fadeOut col-md-12 animated zoomIn');

    $("#grade").val("");

    // empty subject list
    $('select[name="subject_id"]').empty();
    $("#subject").attr('disabled','disabled');

    $("#years").val("");
    $("#years").attr('disabled','disabled');
    $("#date").val("");
    $("#date").attr('disabled','disabled');
    $("#result").html('');
  }
});

// on change of years query out all dates within that year and populate
// the dates select element with data gotten
$(document).on('change', '#years', function(event) {
  event.preventDefault();
  /* Act on the event */

  var year = $("#years").val();
  if (year != "") {

    $("#date").removeAttr('disabled');

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

  } else {

    // remove fading and animation for divs
    $('.hidden-dates-div').removeClass('fadeInRight').addClass('hidden');
    $('.hidden-subject-div').removeClass('fadeInRight').addClass('hidden');
    $('.hidden-search-div').removeClass('shake').addClass('hidden');
    $('.grade-div').removeClass('col-md-4 col-md-3').addClass('fadeOut col-md-12 animated zoomIn');

    $("#grade").val("");
    $("#years").val("");
    $("#years").attr('disabled','disabled');
    $('select[name="subject_id"]').empty();
    $("#subject").attr('disabled','disabled');
    $("#date").val("");
    $("#date").attr('disabled','disabled');
    $("#result").html('');
  }
});

// on change of display the search button
$(document).on('change', '#date', function(event) {
  event.preventDefault();
   /* Act on the event */

  var subject = $('#subject').val();
  var grade = $('#grade').val();
  var years = $('#years').val();
  var date = $('#date').val();

  if (date != "" && grade != "" && years != "" && subject != "") {

    $('.hidden-search-div').removeClass('hidden').show().addClass('animated fadeIn');
    $('.search-btn').removeAttr('disabled');

  } else {

    // remove fading and animation for divs
    $('.hidden-dates-div').removeClass('fadeInRight').addClass('hidden');
    $('.hidden-subject-div').removeClass('fadeInRight').addClass('hidden');
    $('.hidden-search-div').removeClass('shake').addClass('hidden');
    $('.grade-div').removeClass('col-md-4 col-md-3').addClass('fadeOut col-md-12 animated zoomIn');



    $("#date").val("");
    $("#date").attr('disabled','disabled');
    $("#grade").val("");
    $("#years").val("");
    $("#years").attr('disabled','disabled');
    $('select[name="subject_id"]').empty();
    $("#subject").attr('disabled','disabled');
    $("#date").val("");
    $("#date").attr('disabled','disabled');
    $(".search-btn").attr('disabled','disabled');
    $("#result").html('');
  }
});

//when search btn is click display attendence of students based
//on the date, grade, and subject specify
$(document).on('click', '.search-btn', function(event) {
 event.preventDefault();
 /* Act on the event */

  var subject = $('#subject').val();
  var grade = $('#grade').val();
  var years = $('#years').val();
  var date = $('#date').val();

 if (date != "" && grade != "" && years != "" && subject != "") {

    $.ajax({
      url: '/teacher/attendence/students-attendence',
      type: 'GET',
      dataType: 'html',
      data: {'subject_id':subject, 'grade_id':grade, 'date':date},
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
    $("#grade").val("");
    $("#years").val("");
    $("#years").attr('disabled','disabled');
    $('select[name="subject_id"]').empty();
    $("#subject").attr('disabled','disabled');
    $("#date").val("");
    $("#date").attr('disabled','disabled');
    $(".search-btn").attr('disabled','disabled');
    $("#result").html('');
  }
});