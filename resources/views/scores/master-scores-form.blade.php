@extends('layouts.master')

@section('page-title', 'Scores')


@section('page-css')
	<!-- Animate css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header', 'Scores')

@section('user-logout')
  @component('components.user-logout')
      @slot('user_name')
          {{Auth::guard('admin')->user()->user_name}}
      @endslot
      {{route('admin.logout')}}
  @endcomponent
@endsection


@section('sidebar-navigation')
<!-- Sidebar Menu -->
<ul class="sidebar-menu">
  <li class="header">ADMIN NAVIGATION</li>

  <li class="">
    <a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
    </a>
  </li>

  <!-- guardians -->
  <li class="treeview">
    <a href="#"><i class="fa fa-user"></i> <span>Guardians</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{route('guardians.home')}}"><i class="glyphicon glyphicon-th-list"></i> <span>Guardians</span></a></li>
      <li><a href="{{route('guardians.form')}}"><i class="fa fa-pencil"></i>New Guardian</a></li>
    </ul>
  </li>

  <!-- teacher -->
  <li class="treeview">
    <a href="#"><i class="glyphicon glyphicon-education"></i> <span>Teachers</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{route('teachers.home')}}"><i class="glyphicon glyphicon-th-list"></i> <span>Teachers</span></a></li>
      <li><a href="{{route('teachers.form')}}"><i class="fa fa-pencil"></i>New Teacher</a></li>
      <li><a href="{{route('admin-gradesTeacher.home')}}"><i class="glyphicon glyphicon-asterisk"></i>Teacher Grades</a></li>
        <li><a href="{{route('admin-gradesTeacher.form')}}"><i class="fa fa-pencil"></i>New Teacher Grade</a></li>
    </ul>
  </li>

  <!-- Settings -->
  <li class="treeview">
    <a href="#"><i class="fa fa-cogs"></i> <span>Settings</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="/institution"><i class="fa fa-edit"></i>Institution</a></li>
      <li><a href="/academics"><i class="fa fa-edit"></i>Academic</a></li>
      <li><a href="/subjects"><i class="fa fa-edit"></i>Subjects</a></li>
      <li><a href="/grades"><i class="fa fa-edit"></i>Grades</a></li>
      <li><a href="/divisions"><i class="fa fa-edit"></i>Divisions</a></li>
      <li><a href="/semesters"><i class="fa fa-edit"></i>Semesters</a></li>
      <li><a href="/terms"><i class="fa fa-edit"></i>Terms</a></li>
    </ul>
  </li>

  <!-- student -->
  <li class="treeview">
    <a href="#">
      <i class="fa fa-users"></i><span>Students</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="/students"><i class="glyphicon glyphicon-list-alt"></i>Student List</a></li>
      <li><a href="/students/create"><i class="fa fa-pencil"></i>Student Admission</a></li>
    </ul>
  </li>

  <!-- users -->
  <li class="treeview">
    <a href="#">
      <i class="glyphicon glyphicon-user"></i><span>Users</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{route('users.home')}}"><i class="glyphicon glyphicon-list-alt"></i>User List</a></li>
      <li><a href="{{route('users.form')}}"><i class="fa fa-pencil"></i>New User</a></li>
    </ul>
  </li>

   <!-- users roles-->
  <li class="treeview">
    <a href="#">
      <i class="glyphicon glyphicon-user"></i><span>Users Roles</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{route('roles.home')}}"><i class="glyphicon glyphicon-list-alt"></i>Roles</a></li>
      <li><a href="{{route('roles.form')}}"><i class="fa fa-pencil"></i>New Role</a></li>
    </ul>
  </li>

  <!-- score -->
  <li class="active treeview">
    <a href="#">
      <i class="fa fa-fax"></i><span>Scores</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="/scores"><i class="glyphicon glyphicon-list-alt"></i>Score Tables</a></li>
      <li class="active"><a href="/scores/master"><i class="fa fa-pencil"></i>Enter Score</a></li>
    </ul>
  </li>

  <!-- reports -->
  <li class="treeview">
    <a href="#">
      <i class="fa fa-folder-open-o"></i>
      <span>Scores Reports</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="/scores/report/terms"><i class="fa fa-file-text-o"></i>Term Report</a></li>
      <li><a href="/scores/report/semesters"><i class="fa fa-file-text-o"></i>Semester Report</a></li>
      <li><a href="{{route('annual-scores')}}"><i class="fa fa-file-text-o"></i>Annual Report</a></li>
    </ul>
  </li>
</ul>
@endsection


@section('content')


	<div class="row">
		<div class="col-md-12">

			<!-- div to display errors returned by server-->
            <div class="errors alert hidden">
            </div>
            <!-- end of errors div -->

         	<div class="panel">

            @component('components.loader')
            @endcomponent
            
         		<div class="panel-body">
         			<div class="form-group">
         				<div class="input-group">
                  <span class="input-group-addon">Grades/Class</span>
                  <select name="grade_id" class="form-control" id="grade">
                    <option value="">Select Grade/Class</option>
                    @foreach($grades as $grade)
                      <option value="{{$grade->id}}">{{$grade->name}}</option>
                    @endforeach
                  </select>

                  <span class="input-group-addon">Subject</span>
            			<select disabled="true" name="subject_id" id="subject" class="form-control subjects-terms">
            			</select>
                 
            		<span class="input-group-addon">Term</span>
            		<select disabled="true" name="term_id" class="form-control subjects-terms" id="term">
            			<option value="">Select term</option>
              			@foreach($terms as $term)
              			<option value="{{$term->id}}">{{$term->name}}</option>
              		@endforeach
	         				</select>
	         			</div>
	         		</div>

	         		<div id="result">
              </div>
	         	</div>
         	</div>
	    </div>
	</div>

@endsection

@section('page-scripts')

	<script src="{{ asset ("/bower_components/AdminLTE/plugins/sweetalert-master/dist/sweetalert.min.js") }}"></script>

	<script type="text/javascript">

	 $.ajaxSetup({
		  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
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
      var term = $('#term').val();

      if (grade != "") {

        $(document).ajaxStart(function() {
          $(".overlay").css("display", "block");
        });

        $(document).ajaxStop(function() {
          $(".overlay").css("display", "none");
        });
        
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
        $("#term").val("");
        $("#grade").val("");
        $("#term").attr('disabled','disabled');
        $("#subject").attr('disabled','disabled');
        $("#result").html('');
      }
   });

   // a subject should be selected before the term select list field is enable
   // for selection
   $(document).on('change', '#subject', function(event) {
      event.preventDefault();
      /* Act on the event */

      // hide all errors
      $('.errors').addClass('hidden');
    
      var subject = $('#subject').val();
      var grade = $('#grade').val();
      var term = $('#term').val();


      if (subject != '') {
        $("#term").removeAttr('disabled');
      } else {
        $("#term").val("");
        $("#term").attr('disabled',true);
        $("#result").html('');
      }
    });

   // when grades, subjects and terms have been then an ajax call
   // is made that displays students in relation to the options selected
   $(document).on('change', '.subjects-terms', function(event) {
      event.preventDefault();
      /* Act on the event */

      $('.errors').addClass('hidden');
    
      var subject = $('#subject').val();
      var grade = $('#grade').val();
      var term = $('#term').val();

      if (subject != "" && term != "" && subject != "") {
        $(document).ajaxStart(function() {
          $(".overlay").css("display", "block");
        });

        $(document).ajaxStop(function() {
          $(".overlay").css("display", "none");
        });

        $.ajax({
          url:"/scores/master/create",
          method:"GET",
          data:{"subject_id":subject, "grade_id":grade, "term_id":term},
          dataType:"text",
          success:function(data){
            $("#result").html(data);
          },
          error:function(){
            $("#result").html('There was an error please contact administrator');
          }

        });
      } else {
        $("#result").html('');
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
   var row = $(this).parent("td").parent("tr");

  	if (score >= 59 && score <= 100) {
  		$.ajax({
    		url: '/scores',
    		type: 'POST',
    		dataType: 'json',
    		data: {"student_id":student, "grade_id":grade, "subject_id":subject, "term_id":term, "score":score},
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
	</script>
@endsection