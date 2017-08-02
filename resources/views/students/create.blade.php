@extends('layouts.master')

@section('page-title', 'Create Student')

@section('meta')
	<meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('page-css')
<!-- Animate css -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />

<!-- date picker -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header', 'Create Student')


@section('content')

    @include ('layouts.errors')

	<div class="row">
		<div class="col-md-12">

			<div class="panel panel-primary">
				<!-- Default panel contents -->
				<div class="panel-heading">
					<div class="container-fluid">
						<span class="panel-title">Students</span>
						<!-- button that triggers modal -->
						<a role="button" href="/students" class="pull-right" title="students table">
							<span class="badge"><i class="glyphicon glyphicon-arrow-left"></i> </span>
						</a>
					</div>
					
				</div>
				<div class="panel-body">
                    <!-- start of form -->
					<form action="/students" method="POST">
						{{csrf_field()}}
                    	<!-- personal information -->  
                    	<div class="form-group">
                    		<p>
                                <b>PERSONAL INFOMATION:</b>
                                <hr>
                            </p>
                    	</div>

                        <div class="row">
                            <div class="form-group col-sm-4">
                            	<label for="" class="req">First Name</label>
                            	<div class="input-group">
                            		<span class="input-group-addon">
                            			<i class="fa fa-user"></i>
                            		</span>
                            		<input class="form-control" name="first_name" required="required" type="text" maxlength="45">
                            	</div>		                 
                            </div>
                            <div class="form-group col-sm-4">
                            	<label for="" class="req">Middle Name</label>
                            	<div class="input-group">
                            		<span class="input-group-addon">
                            			<i class="fa fa-user"></i>
                            		</span>
                            		<input class="form-control" name="middle_name" type="text" maxlength="45">
                            	</div>     
                            </div>
                            <div class="form-group col-sm-4">
                            	<label for="surname">Surname</label>
                            	<div class="input-group">
                            		<span class="input-group-addon">
                            			<i class="fa fa-user"></i>
                            		</span>
                            		<input class="form-control" id="surname" name="surname" required="required" type="text" maxlength="45">
                            	</div>
                            </div>		                                
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-6">
                            	<label for="" class="req">Date of Birth</label>
                            	<div class="input-group date">
                            		<span class="input-group-addon">
                            			<i class="fa fa-calendar-plus-o"></i>
                            		</span>
                            		<input class="form-control" id="datepicker" name="date_of_birth" required="required">
                            	</div>
                            </div>
                            <div class="form-group col-sm-6">
                            	<label for="" class="req">Gender</label>
                            	<select name="gender" class="form-control" required="">
                            		<option value="Female">Female</option>
                            		<option value="Male">Male</option>
                            	</select>
                            </div>
                        </div>

                        <div class="row"> 
                            <div class="form-group col-sm-6">
                            	<label for="">County</label>
                            	<select name="county" class="form-control">
									@foreach($counties as $name => $value)
                                        <option value="{{$value}}">{{$name}}</option>
                                    @endforeach
								</select>
                            </div>
                            <div class="form-group col-sm-6">
                            	<label for="religion">Religion</label>
                            	<select class="form-control" name="religion" id="religion">
                                    @foreach($religions as $name => $value)
                                        <option value="{{$value}}">{{$name}}</option>
                                    @endforeach
                            	</select>
                            </div>
                        </div>

                        <!-- contact information -->
                        <div class="form-group">
                    		<p>
                                <b>CONTACT DETAILS:</b>
                                <hr>
                            </p>
                    	</div>

                        <div class="row">
                        	<div class="form-group col-sm-12 col-md-12 col-xs-12">
                        		<label>Address</label>
                        		<div class="input-group">
                            		<span class="input-group-addon">
                            			<i class="fa fa-home"></i>
                            		</span>
                                    <input type="text" class="form-control" name="address">
                            	</div>
                        	</div>
                        </div>

                        <div class="row">
                        	<div class="form-group col-sm-6">
                        		<label>Phone</label>
                        		<div class="input-group">
                            		<span class="input-group-addon">
                            			<i class="fa fa-phone"></i>
                            		</span>
                            		<input type="" name="phone" class="form-control" data-inputmask='"mask": "(9999) 999-999"' data-mask>
                            	</div>
                        	</div>
                        	<div class="form-group col-sm-6">
                        		<label>Country</label>
                        		<input type="text" name="country" value="Liberia" class="form-control" required="">
                        	</div>
                        </div>

                        <!-- previous qualification section -->
                        <div class="form-group">
                    		<p>
                                <b>PREVIOUS QUALIFICATION:</b>
                                <hr>
                            </p>	
                    	</div>

                        <div class="row">
                            <div class="form-group col-sm-6">
                            	<label for="past_school_name" class="req">Last school attended</label>
                            	<div class="input-group">
                            		<span class="input-group-addon">
                            			<i class="fa fa-institution"></i>
                            		</span>
                            		<input class="form-control" name="last_school" id="last_school" type="text" maxlength="100">
                            	</div>
                            </div>
                            <div class="form-group col-sm-6">
                            	<label for="past_class_name">Last class</label>
								<select name="last_grade" id="last_grade" class="form-control" required="">
									@foreach($grades as $grade)
										<option value="{{$grade->id}}">{{$grade->name}}</option>
									@endforeach
								</select>
                            </div> 	
                        </div>

                        <!-- school information -->
                        <div class="form-group">
                    		<p>
                        		<b>School Information</b>
                        		<hr>
                        	</p>                        		
                    	</div>

                        <div class="row">
                        	<div class="form-group col-sm-6">
                        		<label>Student Type</label>
                        		<select name="student_type" required="required" class="form-control">
									<option value="Old Student">Old Student</option>
									<option value="New Student">New Student</option>
								</select>
                        	</div>
                        	<div class="form-group col-sm-6">
                        		<label>Class</label>
                        		<select name="grade_id" id="grade_id" class="form-control" required="">
									@foreach($grades as $grade)
										<option value="{{$grade->id}}">{{$grade->name}}</option>
									@endforeach
								</select>
                        	</div>
                        </div>	
						<div class="row">
                            <div class="form-group col-md-12">
                                <input class="form-control btn btn-primary" type="submit" name="submit" value="Save">
                            </div>
                        </div>
					</form>
                    <!-- /. close of form -->
				</div>
			</div>
			<!-- /. close of panel div -->
		</div>
	</div>

@endsection


@section('page-scripts')
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js") }}"></script>

    <script type="text/javascript">
        //Date picker
        $('#datepicker').datepicker({
          autoclose: true
        });

        $("[data-mask]").inputmask();
    </script>

    @if($flash = session('message'))
        <script type="text/javascript">
            var message = "Student <b>{{$flash}}</b> save!";
            notify(message);
        </script>
    @endif
@endsection