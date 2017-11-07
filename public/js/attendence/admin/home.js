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

    // remove fading and animation fro divs
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
    $('.hidden-search-div').removeClass('fadeIn').addClass('hidden');
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
      url: '/attendence/students-attendence',
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
    $("#result").html('Please make sure you have date, grade, years and subject specify! All are required to view attendence');
  }
});


/******************************************************************************
*                            EDIT AND DELETE SECTION
*******************************************************************************/

// Setup with details of attendence record to be updated
$(document).on('click', '.edit-attendence', function(event) {
  event.preventDefault();
  /* Act on the event */

  //setting the student name
  $('#edit-name').val($(this).data('name'));

  // setting the subject name
  $('#edit-subject').val($(this).data('subject'));

  // setting the grade/class name
  $('#edit-grade').val($(this).data('grade'));

  // setting the date
  $('#edit-date').val($(this).data('date'));

  // setting the student score
  $('#edit-remarks').val($(this).data('remarks'));

  // set the hidden score id
  $('#attendence-id').val($(this).data('id'));

  $('.errors').addClass('hidden');

  // attendence to be edited id
  var id = $(this).attr('data-id');

  //an ajax call the get the status selected for a given attendence row
  $.get('/attendence/edit/'+id)
  .done(function (data) {
    // body...
    $('select[id="edit-status"]').empty();
    $.each(data.statuses, function(key, value) {
       /* iterate through array or object */
       if(value === data.attendence){
          $('select[id="edit-status"]').append('<option selected="true" value="'+ value +'">'+ value +'</option>');
       } else {
          $('select[id="edit-status"]').append('<option value="'+ value +'">'+ value +'</option>');
       }
    });
  })
  .fail(function (data) {
    // body...
    $('.errors').removeClass('hidden');
    $('.errors').addClass('alert-warning');
    $('.errors').show().html('An error occur. Try again, and if problem persists contact administrator.'); 
  });

  // display the add modal
  $('#attendence-modal').modal({
    show: true,
    backdrop:'static',
    keyboard:false
  });

});


// update attendence when the update button is click
$(document).on('click', '#update-attendence', function(event) {
  event.preventDefault();
  /* Act on the event */

  // getting the attendence id to be updated
  var id = $('#attendence-id').val();
  $.ajax({
    url: '/attendence/update/'+id,    
    type: 'PUT',
    data: $("#attendence-form").serialize(),
  })
  .done(function(data) {
    // if the validator bag returns error display error in modal
    if (data.errors) {
      $('.errors').removeClass('hidden');
      var errors = '';
      for(datum in data.errors){
          errors += data.errors[datum] + '<br>';
      }
      $('.errors').show().html(errors); 
    } else {

      $("#attendence-modal").modal('hide');

      var attendence_id = data.attendence[0].id;
      // converting the date return to a javascript date instance
      // so that I can utilize javascript's date functions.
      var date = data.date;
      var status = data.attendence[0].status;
      var remarks = data.attendence[0].remarks;
      var student_id = data.attendence[0].student.id;
      var student_code  = data.attendence[0].student.student_code;
      var name  = data.attendence[0].student.first_name+" "+data.attendence[0].student.surname;
      var subject = data.attendence[0].subject.name;
      var grade = data.attendence[0].grade.name;

      // prepare row of attendence details to append to the table
      var row = '<tr class="attendence'+attendence_id+'">';
        row += '<td class="text-right"><a href="/students/edit/'+student_id+'">'+student_code+'</a></td>';
        row += '<td>'+name+'</td>';
        if (status === "Present") {
          row += '<td><span class="badge label-success">'+status+'</span></td>';
        } else {
          row += '<td><span class="badge label-danger">'+status+'</span></td>';
        }

        if (remarks == null) {
          row += '<td></td>';
        } else {
          row += '<td>'+remarks+'</td>';
        }

        row += '<td>';
          row += '<a class="edit-attendence" data-id="'+attendence_id+'" data-name="'+name+'" data-grade="'+grade+'" data-subject="'+subject+'"  data-remarks="'+remarks+'"  data-date="'+date+'" data-toggle="tooltip" title="Edit" href="#" role="button"><i class="glyphicon glyphicon-edit text-info"></i></a>  &nbsp;';
          row += '<a class="delete-attendence" data-id="'+attendence_id+'" data-toggle="tooltip" title="Delete" href="#" role="button"><i class="glyphicon glyphicon-trash text-danger"></i></a>';
        row += '</td>';
      row += '</tr>';
        
      // replace attendence row with updated details of attendence
      $(".attendence" + attendence_id).replaceWith(row);

      // notify user
      big_notify(data.success);
    }
  })
  .fail(function() {
    $('.errors').removeClass('hidden');
    $('.errors').show().html("An error occur. Try again, if problem persists contact administrator."); 
  });
  
});


// delete attendence
$(document).on('click', '.delete-attendence', function(event) {
  event.preventDefault();
  /* Act on the event */

  // id of the row to be deleted
  var id = $(this).attr('data-id');

  // row to be deleted
  var row = $(this).parent("td").parent("tr");

  var message = "If you continue you won't be able to retrieve this attendence record!";

  var route = "/attendence/delete/"+id;

  swal_delete(message, route, row);
});