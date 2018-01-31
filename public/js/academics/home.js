$(document).ready(function() {

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$('.date').datepicker({
        minViewMode: 2,
        autoclose: true,
        format: 'yyyy',
        todayHighlight: true,
    });


	// validate year start field
	$('.date-start').on('change', function(event) {
		event.preventDefault();
		/* Act on the event */

		$('.errors').addClass('hidden');
    	var currentDate = new Date();
        var yearStart = this.value;


        // checks if the date being set is less than the current date
        if (yearStart < currentDate.getFullYear()) {
        	// remove the hidden class on the error block
        	$('.date-start-error').removeClass('hidden');
        	// display error message
			$('.date-start-error').show().html('The Year Start cannot be in the past. Current year is: <b class="text-muted">'+ currentDate.getFullYear() +'</b>');
        } 
        else {
        	// hide the date start error
        	$('.date-start-error').addClass('hidden');

        	/**
        	* If all the above passes, lastly check if the year start
        	* currently exists in the database. This is to avoid
        	* two academic term having the same start year.
        	**/
        	$.ajax({
            	url: '/academics/start/'+yearStart,
            	type: 'GET',
            	dataType: 'JSON'
            })
            .done(function(data) {
            	if (data.exists) {
            		// remove the hidden class on the error block
            		$('.date-start-duplicate').removeClass('hidden');
            		// display error message
					$('.date-start-duplicate').show().html(data.exists);
					// remove the date picker function on the date end field
					$('.date').removeAttr('data-provide');
            	} else {
            		// remove the hidden class on the error block
            		$('.date-start-duplicate').addClass('hidden');	

            		// activate datepicker function on the date-end field
	            	$('.date').attr('data-provide', 'datepicker');
	            	// remove the disable attribute on the date end field
	            	$('.date-end').removeAttr('disabled');
            	}
            })
            .fail(function() {
            	$('.errors').removeClass('hidden');
        		$('.errors').text('There was an error. Please try again, and if error persits contact administrator');
            });
        }    	            
    });		

	// validate year end field
    $('.date-end').on('change', function(event) {
    	event.preventDefault();
		/* Act on the event */

		$('.errors').addClass('hidden');
        var yearStart = $('.date-start').val();
        var yearEnd = this.value;

        // If the year start and year end is the same display and error message
        if (yearEnd == yearStart){
        	// remove the hidden class on the error block
        	$('.date-end-error').removeClass('hidden');
        	// display the error message
			$('.date-end-error').show().html('The Year End <b>year</b> cannot be the same as the Start Year'); 
        }
		// The year end cannot be in the past or less than the year start.
        else if (yearEnd < yearStart) {
        	// remove the hidden class on the error block
        	$('.date-end-error').removeClass('hidden');
        	// display the error message
			$('.date-end-error').show().html('The Year End <b>year</b> cannot be in past or less than the Start year'); 
        } 
        // the year end value cannot be 2 years greater than the year start value
        // Ex. yearStart = 2017 ----- yearEnd = 2019 (this shouldn't be!)
            else if (yearEnd - yearStart >= 2) {
        	// remove the hidden class on the error block
        	$('.date-end-error').removeClass('hidden');
        	// display the error message
			$('.date-end-error').show().html('The <b>Year End</b> cannot be set two(2) or more years apart from the  <b>Year Start</b>'); 
			//disable all other fields
			$('.btn-submit').attr('disabled', 'true');
        } else {

        	// hide date end attribute
			$('.date-end-error').addClass('hidden');

			/**
        	* If all the above passes, lastly check if the year end
        	* year currently exists in the database. This is to avoid
        	* two academic term having the same year end.
        	**/
        	$.ajax({
            	url: '/academics/end/'+yearEnd,
            	type: 'GET',
            	dataType: 'JSON'
            })
            .done(function(data) {
            	if (data.exists) {
            		// remove the hidden class on the error block
            		$('.date-end-duplicate').removeClass('hidden');
            		// display error message
					$('.date-end-duplicate').show().html(data.exists);
            	} else {
            		// remove the hidden class on the error block
            		$('.date-end-duplicate').addClass('hidden');

					//remove the disable attribut from on the status option
					$('.status').removeAttr('disabled');
					// remove disable attribute from on save btn
	            	$('.btn-submit').removeAttr('disabled');
            		
            	}
            })
            .fail(function() {
            	$('.errors').removeClass('hidden');
        		$('.errors').text('There was an error. Please try again, and if error persits contact administrator');
            });     
        }
    });

	// deleting an academic year
	$(document).on('click', '#delete-academic', function(event) {
		event.preventDefault();
		/* Act on the event */

		// id of the row to be deleted
		var id = $(this).attr('data-id');

	    // row to be deleted
	    var row = $(this).parent("td").parent("tr");

		var message = "You won't be able to retrieve this academic year if it's not active!";

		var route = "/academics/delete/"+id;

		swal_delete(message, route, row);
		
	});	
});