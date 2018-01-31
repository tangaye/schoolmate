$(document).ready(function($) {

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var academic_id = $("#academic_years").val();

  if (academic_id != "") {

    $("#result").html("");

    $.ajax({
      url: '/grades-teacher/academic/'+academic_id,
      type: 'GET',
    })
    .done(function(data) {

      if (data.none) {
        $("#teachers").attr('disabled', 'true');
        $("#result").html(data.none);
      } else {

        $("#teachers").removeAttr('disabled');

        $('select[name="teacher_id"]').empty();
        $('select[name="teacher_id"]').append('<option value="">Select Teacher</option>');
        $.each(data, function(key, value) {
          $('select[name="teacher_id"]').append('<option value="'+ value.id +'">'+value.first_name+' '+value.surname+'</option>');
        });
      }
    })
    .fail(function() {
      $("#result").html("An error occur. Please try again, and if problem persits contact administrator.");
    });
    
  } else {
    $("#teachers").attr('disabled', 'true');
    $("#result").html("");
  }

  $(document).on('change', '#academic_years', function(event) {
    event.preventDefault();

    var academic_id = $("#academic_years").val();

    if (academic_id != "") {

      $("#result").html("");

      $.ajax({
        url: '/grades-teacher/academic/'+academic_id,
        type: 'GET',
      })
      .done(function(data) {

        if (data.none) {
          $("#teachers").attr('disabled', 'true');
          $("#result").html(data.none);
        } else {

          $("#teachers").removeAttr('disabled');

          $('select[name="teacher_id"]').empty();
          $('select[name="teacher_id"]').append('<option value="">Select Teacher</option>');
          $.each(data, function(key, value) {
            $('select[name="teacher_id"]').append('<option value="'+ value.id +'">'+value.first_name+' '+value.surname+'</option>');
          });
        }
      })
      .fail(function() {
        $("#result").html("An error occur. Please try again, and if problem persits contact administrator.");
      });
      
    } else {
      $("#teachers").attr('disabled', 'true');
      $("#teachers").val("");
      $("#result").html("");
    }
  });  

  $(document).on('change', '#teachers', function(event) {
    event.preventDefault();
    /* Act on the event */

    var teacher_id = $("#teachers").val();
    var academic_id = $("#academic_years").val();

    if (teacher_id != "" && academic_id != "") {
      
      $.ajax({
        url: '/grades-teacher/grade-subject',
        type: 'POST',
        data: {'teacher_id':teacher_id, 'academic_id':academic_id},
      })
      .done(function(data) {
        if (data.none) {
          $("#result").html(data.none);
        } else {
          $("#result").html(data);
        }
      })
      .fail(function() {
        $("#result").html("An error occur. Please try again, and if problem persits contact administrator.");
      });
      
    } else {
      $("#result").html("");
    }

  });

  $(document).on('click', '.delete-grade-teacher', function(event) {
    event.preventDefault();
    /* Act on the event */

    // id of the row to be deleted
    var id = $(this).attr('data-id');

      // row to be deleted
    var row = $(this).parent("td").parent("tr");

    var message = "If you continue the subject and grade assigned will be unassigned.";

    var route = "/grades-teacher/delete/"+id;


    swal_delete(message, route, row);
    
  }); 
});