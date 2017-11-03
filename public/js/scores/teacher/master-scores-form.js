$.ajaxSetup({
  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
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

  $("#subject").removeAttr('disabled');

  if (!gradeDiv.hasClass('col-md-4')) {
    $('.grade-div').removeClass('fadeOut animated zoomIn col-md-12').addClass('col-md-4');
    $('.hidden-subjectTerm-div').removeClass('hidden').show().addClass('animated fadeInRight col-md-4');
  } 

  $.get('/teacher/grade-subjects/'+grade)
  .done(function (data) {
    // body...
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
// is made that displays students in relation to the options selected
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
      url:"/teacher/manage-scores/create",
      method:"GET",
      data:{"subject_id":subject, "grade_id":grade, "term_id":term},
      dataType:"text",
      success:function(data){
        $("#result").html(data);
      },
      error:function(){
        $("#result").html('There was an error please contact administrator');
      }
    });
  } else {
    $("#result").html('');
  }
});

// after the results have been returned this handles inserting students grades
$(document).on('click', '.save-score', function() {
/* Act on the event */

  var student = $(this).parents('tr').find(".student").val();
  var grade = $(this).parents('tr').find(".grade").val();
  var subject = $(this).parents('tr').find(".subject").val();
  var score = $(this).parents('tr').find(".score").val();
  var term = $(this).parents('tr').find(".term").val();
  var row = $(this).parent("td").parent("tr");

  if (score >= 59 && score <= 100) {
  	$.ajax({
  		url: '/teacher/manage-scores',
  		type: 'POST',
  		dataType: 'json',
  		data: {"student_id":student, "grade_id":grade, "subject_id":subject, "term_id":term, "score":score},
  	})
  	.done(function(data) {
  		if (data.errors) {
      	$('.errors').removeClass('hidden');
      	$('.errors').addClass('alert-danger');
  			var errors = '';
              for(datum in data.errors){
                  errors += data.errors[datum] + '<br>';
              }
              $('.errors').show().html(errors); 
          } 
          else if (data.duplicate){
          	$('.errors').removeClass('hidden');
          	$('.errors').addClass('alert-warning');
          	$('.errors').show().html(data.duplicate); 
          }
          else if (data.success){
          	 // fading out the record that was inserted
            	jQuery(row).fadeOut('slow');

            	// notify user
            	big_notify(data.success);
              $('.errors').addClass('hidden');
          }
  	})
  	.fail(function() {
      $('.errors').removeClass('hidden');
      $('.errors').addClass('alert-warning');
  	  $('.errors').show().html('An error occur. Please try again. If problem persists contact administrator'); 
  	});
  } else {
  	$('.errors').removeClass('hidden');
    $('.errors').addClass('alert-warning');
     $('.errors').show().html('The score should be between 59 - 100.'); 
  }
});