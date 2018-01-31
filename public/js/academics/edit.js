 $(document).ready(function($) {

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  // setup datepicker for years only
  $('.date').datepicker({
      minViewMode: 2,
      autoclose: true,
      format: 'yyyy',
      todayHighlight: true,
  });

  // academic to be edited id
  var id = $("#academic-id").val();

  $(document).on('change', '.edit-years', function(event) {
    event.preventDefault();
    /* Act on the event */


    var editYearStart = $('#edit-start').val();
    var editYearEnd = $('#edit-end').val();
    var currentDate = new Date();

    // checks if the year start being set is less than the current date
    if (editYearStart < currentDate.getFullYear()) {
      // remove the hidden class on the error block
      $('.edit-date-start-error').removeClass('hidden');
      // display error message
      $('.edit-date-start-error').show().html('Year Start cannot be in the past. Current year is: <b class="text-muted">'+ currentDate.getFullYear() +'</b>');
      $('#update-academic').attr('disabled', 'true');
    } 

    else {
      // hide the date start error
      $('.edit-date-start-error').addClass('hidden');

      /**
      * If all the above passes, lastly check if the date start
      * year currently exists in the database. This is to avoid
      * two academic term having the same start year.
      **/
      $.ajax({
        url: '/academics/edit-start/'+id+'/'+editYearStart,
        type: 'GET',
        dataType: 'JSON'
      })
      .done(function(data) {
        if (data.exists) {
          // remove the hidden class on the error block
          $('.edit-date-start-duplicate').removeClass('hidden');
          // display error message
          $('.edit-date-start-duplicate').show().html(data.exists);
          $('#update-academic').attr('disabled', 'true');
    
        } else {
          // remove the hidden class on the error block
          $('.edit-date-start-duplicate').addClass('hidden'); 
        }
      })
      .fail(function() {
        $('.errors').removeClass('hidden');
        $('.errors').text('There was an error. Please try again, and if error persits contact administrator');
      });
    }

    var noDateError = true;

    // the date end cannot be the same as the the current year
    if (editYearEnd == editYearStart){

      noDateError = false;

      // remove the hidden class on the error block
      $('.edit-date-end-error').removeClass('hidden');
      // display the error message
      $('.edit-date-end-error').show().html('The <b>Year Start</b> cannot be the same as the Date Start Year'); 
      $('#update-academic').attr('disabled', 'true');
    }
    // the date end value cannot not be in the past
    else if (editYearEnd < editYearStart) {

      noDateError = false;

      // remove the hidden class on the error block
      $('.edit-date-end-error').removeClass('hidden');
      // display the error message
      $('.edit-date-end-error').show().html('The <b>Year End</b> cannot be in past or less than Date Start year'); 

      $('#update-academic').attr('disabled', 'true');
    } 
    // the date end value cannot be 2 years greater than the date start value
    // Ex. dateStart = 2017 ----- date end = 2019 (this shouldn't be)
    else if (editYearEnd - editYearStart >= 2) {

      noDateError = false;
      
      // remove the hidden class on the error block
      $('.edit-date-end-error').removeClass('hidden');
      // display the error message
      $('.edit-date-end-error').show().html('The <b>Year End</b> cannot be set two(2) or more years apart from the <b>Year Start</b>'); 

      $('#update-academic').attr('disabled', 'true');
    } 
    else if(noDateError) {

      // hide date end attribute
      ('.edit-date-end-error').addClass('hidden');

      /**
        * If all the above passes, lastly check if the date end
        * year currently exists in the database. This is to avoid
        * two academic term having the same end year.
        *
      */

      $.ajax({
          url: '/academics/edit-end/'+id+'/'+editYearEnd,
          type: 'GET',
          dataType: 'JSON'
      })
      .done(function(data) {
        if (data.exists) {
          // remove the hidden class on the error block
          $('.edit-date-end-duplicate').removeClass('hidden');
          // display error message
          $('.edit-date-end-duplicate').show().html(data.exists);
          $('#update-academic').attr('disabled', 'true');
        } else {
          // remove the hidden class on the error block
          $('.edit-date-end-duplicate').addClass('hidden');
          $('#update-academic').removeAttr('disabled');
          
        }
      })
      .fail(function() {
        $('.errors').removeClass('hidden');
        $('.errors').text('There was an error. Please try again, and if error persits contact administrator');
      });   
    }

  });
});