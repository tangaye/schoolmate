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


//When an academic year is selected request grades that have scores recorded in the 
//academic year selected.
$(document).on('change', '#academic', function(event) {
	event.preventDefault();
	/* Act on the event */

	var academic = $('#academic').val();

	if (academic != '') {

		$.ajax({
			url: '/scores/grades/'+academic,
			type: 'GET',
		})
		.done(function(data) {
			if (data.none) {
				$('select[name="grade_id"]').empty();
    			$("#grade").attr('disabled','true');
    			$('select[name="subject_id"]').empty();
    			$("#subject").attr('disabled','true');
    			$("#term").attr('disabled', 'true');
    			$("#result").html(data.none);
			} else {
				$("#grade").removeAttr('disabled');
				$("#result").html('');

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

	    $('select[name="grade_id"]').empty();
		$("#grade").attr('disabled','true');
		$('select[name="subject_id"]').empty();
		$("#subject").attr('disabled','true');
		$("#term").attr('disabled', 'true');
		$("#result").html('');
	}
});


// on change of the grades select list the subject select list should be load up 
// with subjects that are taught in the selected grade/class
$(document).on('change', '#grade', function(event) {
	event.preventDefault();
	/* Act on the event */

	var academic = $('#academic').val();
	var grade = $('#grade').val();

	if (grade != "" && academic != "") {


		$.get('/grades/subjects/'+grade)
		.done(function (data) {

			if (data.none) {

				$('select[name="subject_id"]').empty();
    			$("#subject").attr('disabled','true');
    			$("#term").attr('disabled', 'true');
				$("#result").html(data.none);

			} else {
				$("#subject").removeAttr('disabled');
				$("#term").removeAttr('disabled');
				$("#result").html("");

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

		$('select[name="subject_id"]').empty();
		$("#subject").attr('disabled','true');
		$("#term").attr('disabled', 'true');
		$("#result").html('');
	}
});

$(document).on('change', '.search_fields', function(event) {
	event.preventDefault();
	/* Act on the event */

	var subject = $('#subject').val();
  	var grade = $('#grade').val();
	var academic = $('#academic').val();
	var term = $('#term').val();

	if (term != "" && grade != "" && academic != "" && subject != "") {
		$.ajax({
			url:"/users/scores/students",
			type: 'POST',
			data:{"subject_id":subject, "grade_id":grade, "term_id":term, "academic_id":academic},
		})
		.done(function(data) {
			if (data.none) {
				$("#result").html(data.none);
			} 
			else {
				$("#result").html(data);
				var print_title = $(".print-title").text();
			    $('#scores-table').DataTable({
			      	dom: 'Bfrtip',
				    buttons: [
				        {
				          extend: 'excel',
				          text: '<i class="fa fa-file-excel-o"></i> Excel',
				          title: print_title,
				          exportOptions: {
				            columns: ':not(.noExport)'
				          }
				        },
				        {
				          extend: 'pdf',
				          text: '<i class="fa fa-file-pdf-o"></i> PDF',
				          title: print_title,
				          exportOptions: {
				           columns: ':not(.noExport)'
				          }
				        },
				        {
				          extend: 'print',
				          text: '<i class="fa fa-print"></i> Print',
				          title: print_title,
				          exportOptions: {
				            columns: ':not(.noExport)'
				          }
				        }
				    ]
			    });
			}
		})
		.fail(function() {
			$("#result").html('There was an error please contact administrator');
		});
		
	} else {
		 $("#result").html('Please make sure you have all the fields selected.');
	}

});


//when search btn is click students scores for the specify grade,
//subject, term and academic year are generated
$(document).on('click', '.search-btn', function(event) {
 event.preventDefault();
 /* Act on the event */

  var subject = $('#subject').val();
  var grade = $('#grade').val();
  var academic = $('#academic').val();
  var term = $('#term').val();

 if (term != "" && grade != "" && academic != "" && subject != "") {

 	$(document).ajaxStart(function() {
	  $(".overlay").css("display", "block");
	});

	$(document).ajaxStop(function() {
	  $(".overlay").css("display", "none");
	});

    $.ajax({
		url:"/scores/students-scores",
		method:"GET",
		data:{"subject_id":subject, "grade_id":grade, "term_id":term, "academic_id":academic},
		dataType:"text",
		success:function(data){
		    $("#result").html(data);
		    $("#scores-table").DataTable({
		    	"aoColumnDefs" : [
		       {
		         'bSortable' : false,
		         'aTargets' : ['actions', 'text-holder' ]
		       }]
		    });
		},
		error:function(){
			$("#result").html('There was an error please contact administrator');
		}
	});
    

  } else {

  	$('.hidden-search-div').removeClass('fadeIn').addClass('hidden');

    $("#term").val("");
    $("#term").attr('disabled','disabled');
    $("#grade").val("");
    $("#academic").val("");
    $("#academic").attr('disabled','disabled');
    $('select[name="subject_id"]').empty();
    $("#subject").attr('disabled','disabled');
    $(".search-btn").attr('disabled','disabled');
    $("#result").html('Please select the Subject, Grade, Term and Academic Year.');
  }
});