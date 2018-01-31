$(document).ready(function($) {

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

  function sponsors(academic_id) {
    // body...

    if (academic_id != "") {

      $("#result").html("");

      $.ajax({
        url: '/admin/sponsor/'+academic_id,
        type: 'GET',
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
  }

  var academic_id = $("#academic_years").val();

  sponsors(academic_id);

  $(document).on('change', '#academic_years', function(event) {
    event.preventDefault();
    var academic_id = $("#academic_years").val();
    sponsors(academic_id);
  });  

  // when the new enrollment button is click display the new enrollment modal
  // form
  $(document).on('click', '.new_sponsor', function(event) {
    event.preventDefault();
    /* Act on the event */
    // display the add modal
    $('#sponsor_modal').modal({
      show: true,
      backdrop:'static',
      keyboard:false
    });

    $('.errors').addClass('hidden');
    $("#sponsor_grade_form")[0].reset();

    // query out teachers who are not sponsors in the current academic year.
    $.ajax({
      url: '/admin/sponsor/teachers',
      type: 'POST',
    })
    .done(function(data) {
      if (data.none) {
        $('select[name="teacher_id"]').empty();
        $('select[name="teacher_id"]').append('<option value="">'+data.none+'</option>');
      } else {
        
        //Initialize Select2 Elements
        $(".teacher").select2();

        $('select[name="teacher_id"]').empty();
        $('select[name="teacher_id"]').append('<option value="">Choose Teacher</option>');
        $.each(data, function(key, value) {
          $('select[name="teacher_id"]').append('<option value="'+ value.id +'">'+value.first_name+' '+value.surname+'</option>');
        });
      }
    })
    .fail(function() {
     $('.errors').removeClass('hidden');
     $('.errors').text('There was an error. Please try again, and if error persits contact administrator');
    });
  });

  //when the teacher is selected enable the grades element.
  $(document).on('change', '#teacher_id', function(event) {
    event.preventDefault();
    /* Act on the event */
    var teacher_id = $("#teacher_id").val();
    if (teacher_id != "") {

      $("#grade_id").removeAttr('disabled');

      //This ajax request returns the grades that are assigned to the teacher selected.
      $.ajax({
        url: '/admin/sponsor/grades/'+teacher_id,
        type: 'GET',
      })
      .done(function(data) {
        if (data.none) {
          $('select[name="grade_id"]').empty();
          $('select[name="grade_id"]').append('<option value="">'+data.none+'</option>');
        } else {
          
          $('select[name="grade_id"]').empty();
          $('select[name="grade_id"]').append('<option value="">Choose Grade</option>');
          $.each(data, function(key, value) {
            $('select[name="grade_id"]').append('<option value="'+ value.id +'">'+value.name+'</option>');
          });
        }
      })
      .fail(function() {
        $('.errors').removeClass('hidden');
        $('.errors').text('There was an error. Please try again, and if error persits contact administrator');
      });
    } else {
      $("#grade_id").val("");
      $("#grade_id").attr('disabled', 'true');
      $(".new_sponsor_btn").attr('disabled', 'true');
    }
  });

  //when a grade and teacher is selected enable the assign sponsor button.
  $(document).on('change', '#grade_id', function(event) {
    event.preventDefault();
    /* Act on the event */
    var teacher_id = $("#teacher_id").val();
    var grade_id = $("#grade_id").val();

    if (teacher_id != "" && grade_id != "") {
      $(".new_sponsor_btn").removeAttr('disabled');
    } else {
      $(".new_sponsor_btn").attr('disabled', 'true');
      $("#teacher_id").val("");
      $("#grade_id").val("");
      $("#grade_id").attr('disabled', 'true');
    }
  });



  //when the new sponsor btn is click to assign a sponsor to a grade
  $(document).on('click', '.new_sponsor_btn', function(event) {
    event.preventDefault();
    /* Act on the event */
    var academic_id = $("#academic_id").val();
    var teacher_id = $("#teacher_id").val();
    var grade_id = $("#grade_id").val();

    if (teacher_id != "" && grade_id != "" && academic_id != "") {
      $.ajax({
        url: '/admin/sponsor',
        type: 'POST',
        data: {'teacher_id':teacher_id, 'grade_id':grade_id, 'academic_id':academic_id},
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
     
          // hide the bootstrap dialog
          $("#sponsor_grade_form")[0].reset();
          $('#sponsor_modal').modal('hide');

          //refresh the sponsors table
          sponsors(academic_id);

          // notify the record was updated
          var message = data.success;
          big_notify(message);
        }
      })
      .fail(function() {
        $('.errors').removeClass('hidden');
        $('.errors').text('There was an error. Please try again, and if error persits contact administrator');
      });
      
    } else {
      $(".new_sponsor_btn").attr('disabled', 'true');
      $("#teacher_id").val("");
      $("#grade_id").val("");
      $("#grade_id").attr('disabled', 'true');
      $('.errors').removeClass('hidden');
      $('.errors').text('Please make sure you have all the fields selected.');
    }
  });


  $(document).on('click', '.delete_sponsor', function(event) {
    event.preventDefault();
    /* Act on the event */

    // id of the row to be deleted
    var id = $(this).attr('data-id');

    // row to be deleted
    var row = $(this).parent("td").parent("tr");

    var message = "If you continue this teacher will no longer be a sponser of this grade.";

    var route = "/admin/sponsor/delete/"+id;


    swal_delete(message, route, row);
    
  }); 
});