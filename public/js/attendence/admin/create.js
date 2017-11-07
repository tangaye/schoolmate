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

  // hide all errors
  $('.errors').addClass('hidden');

  var subject = $('#subject').val();
  var grade = $('#grade').val();

  if (grade != "") {
    $('.grade-div').removeClass('fadeOut animated zoomIn col-md-12').addClass('col-md-4');
    $('.hidden-div').removeClass('hidden').show().addClass('animated fadeInRight');
    $("#subject").removeAttr('disabled');

    $.get('/grades/grade-subjects/'+grade)
    .done(function (data) {

      if (data.none) {
        $("#result").html(data.none);
        $("#subject").val('');
        $("#subject").attr('disabled','disabled');

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
    $('.hidden-div').removeClass('fadeInRight').addClass('hidden');
    $('.grade-div').removeClass('col-md-4').addClass('fadeOut col-md-12 animated zoomIn');
    $("#grade").val("");
    $("#subject").attr('disabled','disabled');
    $("#result").html('');
  }
});

// on change of subject get students in the selected class
$(document).on('change', '#subject', function(event) {
  event.preventDefault();
  /* Act on the event */

  $('.errors').addClass('hidden');

  var subject = $('#subject').val();
  var grade = $('#grade').val();
  var date = $('#date').val();

  if (subject != "") {
    $.ajax({
      url:"/attendence/students",
      method:"GET",
      data:{"subject_id":subject, "grade_id":grade, "date":date},
      dataType:"html",
      success:function(data){
        $("#result").html(data);
      },
      error:function(){
        $("#result").html('There was an error please contact administrator');
      }
    });
  }
  else {
    $('.hidden-div').removeClass('fadeInRight').addClass('hidden');
    $('.grade-div').removeClass('col-md-4').addClass('fadeOut col-md-12 animated zoomIn');
    $("#grade").val("");
    $("#subject").attr('disabled','disabled');
    $("#result").html('');
  }
});

$(document).on('click', '.save-attendence', function(event) {
  event.preventDefault();
  /* Act on the event */

  var status = $('.status').val();

  if (status != "") {
    $.ajax({
      url: '/attendence',
      method: 'POST',
      dataType: 'JSON',
      data: $("#attendence-form").serialize(),
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
          $("#search-form")[0].reset();
          jQuery("#attendence-form").fadeOut('slow');

          $('.hidden-div').removeClass('fadeInRight').addClass('hidden');
          $('.grade-div').removeClass('col-md-4').addClass('fadeOut col-md-12 animated zoomIn');
          notify(data);
        }
    })
    .fail(function() {
      $("#result").html('There was an error please contact administrator');
    });
  } else {
     $('.errors').removeClass('hidden');
     $('.errors').show().html("Please select status"); 
  }
});