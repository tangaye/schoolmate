@extends('layouts.master')

@section('page-title', 'Term Report')

@section('meta')
	<meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('page-css')
	<!-- Animate css -->
	<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header', 'Term Report')


@section('content')


	<div class="row">
		<div class="col-md-12">

			<!-- div to display errors returned by server-->
            <div class="errors alert hidden">
            </div>
            <!-- end of errors div -->

         	<div class="panel">
         		<div class="panel-body">
         			<div class="form-group">
         				<div class="input-group">
                        	<span class="input-group-addon">Student Code</span>
                        	<input class="form-control" maxlength="4" type="text" name="student_code" id="code" placeholder="Enter student code">

	                  		<span class="input-group-addon">Term</span>
	                  		<select name="term_id" class="form-control" id="term">
                      			@foreach($terms as $term)
		                  			<option value="{{$term->id}}">{{$term->name}}</option>
		                  		@endforeach
	         				</select>
	         			</div>
	         		</div>
	         		<div id="result"></div>
	         	</div>
         	</div>
	    </div>
	</div>

@endsection

@section('page-scripts')

	<script src="{{ asset ("/bower_components/AdminLTE/plugins/bootbox/bootbox.min.js") }}"></script>
	<script src="{{ asset ("/js/app.js") }}"></script>
	<script type="text/javascript">

		$(document).ready(function() {

			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});
			
			$("#code").keyup(function(event){
				event.preventDefault();

		        var code = $('#code').val();
		        var term = $('#term').val();

		        if (code != '' && code.length === 4) {
		          $.ajax({
		          	url:"/scores/report/terms",
		            method:"POST",
		           	data:{"student_code":code, "term_id":term},
		           	success:function(data){
		            	$("#result").html(data);
		           	}
		          });
		        } else {
		          $("#result").html('');

		        }   
		    });  

			$('#term').on('change', function(event) {
		      	event.preventDefault();

		      	/* Act on the event */
		        var code = $('#code').val();
		        var term = $('#term').val();

		        if (code != '' && code.length === 4) {
		          $.ajax({
		          	url:"/scores/report/terms",
		            method:"POST",
		           	data:{"student_code":code, "term_id":term},
		           	success:function(data){
		            	$("#result").html(data);
		           	}
		          });
		        } else {
		          $("#result").html('');

		        }   

		    });
		});

	</script>
@endsection