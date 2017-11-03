$(document).ready(function() {

  $(document).on('click', '.print-btn', function(event) {
    event.preventDefault();
    /* Act on the event */
    printReport('result');
  });

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

			
	$("#code").keyup(function(event){
		event.preventDefault();

      var code = $('#code').val();
      var semester = $('#semester').val();

      if (code != '' && code.length === 4) {
        $(document).ajaxStart(function() {
          $(".overlay").css("display", "block");
        });

        $(document).ajaxStop(function() {
          $(".overlay").css("display", "none");
        });

        $.ajax({
        	url:"/scores/report/semesters",
          method:"POST",
         	data:{"student_code":code, "semester_id":semester},
          success:function(data){
            if (data.none) {
              $("#result").html(data.none);
            } else {
              $("#result").html(data);
            }
          },
          error:function() {
            $('#result').html('There was an error. Please try again, if problem persits please contact adminstrator');
          }
        });
      } else {
        $("#result").html('');

      }   
    });  

	$('#semester').on('change', function(event) {
      	event.preventDefault();


      	/* Act on the event */
        var code = $('#code').val();
        var semester = $('#semester').val();

        if (code != '' && code.length === 4) {

          $(document).ajaxStart(function() {
            $(".overlay").css("display", "block");
          });

          $(document).ajaxStop(function() {
            $(".overlay").css("display", "none");
          });

          $.ajax({
          	url:"/scores/report/semesters",
            method:"POST",
           	data:{"student_code":code, "semester_id":semester},
            success:function(data){
              if (data.none) {
                $("#result").html(data.none);
              } else {
                $("#result").html(data);
              }
            },
            error:function() {
              $('#result').html('There was an error. Please try again, if problem persits please contact adminstrator');
            }
          });
        } else {
          $("#result").html('');

        }   

    });
});
