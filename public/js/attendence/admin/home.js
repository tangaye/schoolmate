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
// year selected.
$(document).on('change', '#date', function(event) {
  event.preventDefault();
   /* Act on the event */

  var academic_year_id = $('#academic_years').val();
  var date = $('#date').val();

  if (date != "" && academic_years != "") {
    $.ajax({
      url: '/attendence/date/grades',
      type: 'POST',
      data: {"date": date, "academic_id":academic_year_id},
    })
    .done(function(data) {
      if (data.none) {
        $("#result").html(data.none); $("#result").html(data.none);
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
// with subjects that are taught in the selected grade/class
$(document).on('change', '#grade', function(event) {
  event.preventDefault();
  /* Act on the event */

  var grade = $('#grade').val();
  var academic_year_id = $('#academic_years').val();
  var date = $('#date').val();

  if (grade != "" && academic_year_id != "" && date != "") {

    $.get('/grades/grade-subjects/'+grade)
    .done(function (data) {

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
    .fail(function (data) {
      // body...
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
      url: '/attendence/students',
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
        row += '<td><a href="/students/edit/'+student_id+'">'+student_code+'</a></td>';
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