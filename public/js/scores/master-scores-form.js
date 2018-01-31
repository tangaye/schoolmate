$.ajaxSetup({
	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
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

  if (grade != "") {


    $.get('/grades/subjects/'+grade)
    .done(function (data) {

      if (data.none) {
        $("#result").html(data.none);
        $("#term").attr('disabled','disabled');
        $("#subject").val("");
        $("#subject").attr('disabled','disabled');

      } else {
        $("#subject").removeAttr('disabled');
        $("#term").removeAttr('disabled');

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

    $("#grade").val("");
    $("#term").attr('disabled','disabled');
    $("#subject").val("");
    $("#subject").attr('disabled','disabled');
    $("#result").html('');
  }
});

// when grades, subjects and terms have been then an ajax call
// is made that displays students in relation to the options selected
$(document).on('change', '.search_fields', function(event) {
  event.preventDefault();
  /* Act on the event */

  $('.errors').addClass('hidden');

  var subject = $('#subject').val();
  var grade = $('#grade').val();
  var term = $('#term').val();

  if (subject != "" && term != "" && subject != "") {

    $.ajax({
      url:"/scores/master/create",
      method:"GET",
      data:{"subject_id":subject, "grade_id":grade, "term_id":term},
      success:function(data){
        if (data.none) {
          $("#result").html(data.none);
        } else {
          $("#result").html(data);
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

// after the results have been returned this handles inserting students grades
$(document).on('click', '.save-score', function() {
  /* Act on the event */

  var student = $(this).parents('tr').find(".student").val();
  var grade = $(this).parents('tr').find(".grade").val();
  var subject = $(this).parents('tr').find(".subject").val();
  var score = $(this).parents('tr').find(".score").val();
  var term = $(this).parents('tr').find(".term").val();
  var academic = $(this).parents('tr').find(".academic").val();
  var row = $(this).parent("td").parent("tr");

  if (score >= 59 && score <= 100) {
  	$.ajax({
  		url: '/scores',
  		type: 'POST',
  		dataType: 'json',
  		data: {"student_id":student, "grade_id":grade, "subject_id":subject, "term_id":term, "score":score, "academic_id":academic},
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
          }
  	})
  	.fail(function() {
  		$('.errors').removeClass('hidden');
  	$('.errors').show().html('An error occur. Please try again. If problem persists contact administrator'); 
  	});
  } else {
  	$('.errors').removeClass('hidden');
     	$('.errors').addClass('alert-warning');
     	$('.errors').show().html('The score should be between 59 - 100.'); 
  }
});
