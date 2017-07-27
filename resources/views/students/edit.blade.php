@extends('layouts.master')

@section('page-title', 'Edit Student')

@section('meta')
    <meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('page-header', 'Edit Student')

@section('page-css')
<!-- date picker -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css") }}" rel="stylesheet" type="text/css" />
@endsection


@section('content')

    @include ('layouts.errors')

	<div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img src="{{ asset("/bower_components/AdminLTE/dist/img/user2-160x160.jpg") }}" class="profile-user-img img-responsive img-circle" alt="User profile picture"/>

                    <h3 class="profile-username text-center">{{$student->first_name}} {{$student->middle_name}} {{$student->surname}}</h3>

                    <p class="text-muted text-center">Student</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                          <b>Class</b> <a class="pull-right">{{$student->grade->name}}</a>
                        </li>
                        <li class="list-group-item">
                          <b>Age</b> <a class="pull-right">{{$student->age()}}</a>
                        </li>
                        <li class="list-group-item">
                          <b>Date Of Birth</b> <a class="pull-right">{{$student->date_of_birth->toFormattedDateString()}}</a>
                        </li>
                        <li class="list-group-item">
                          <b>Code</b> <a class="pull-right">{{$student->student_code}}</a>
                        </li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">About Me</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <strong><i class="fa fa-book margin-r-5"></i> Last School Attended</strong>

                  <p class="text-muted">
                    {{$student->last_school}}
                  </p>

                  <hr>

                  <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

                  <p class="text-muted">{{$student->address}}</p>

                  <hr>

                </div>
                <!-- /.box-body -->
            </div>
              <!-- /.box -->
        </div>
		<div class="col-md-9">

			<div class="panel panel-primary">
				<!-- Default panel contents -->
				<div class="panel-heading">
					<div class="container-fluid">
						<span class="panel-title">Edit Student</span>
						<!-- button that triggers modal -->
						<a role="button" class="pull-right" href="/students" title="students table">
							<span class="badge"><i class="glyphicon glyphicon-arrow-left"></i> </span>
						</a>
					</div>
					
				</div>
				<div class="panel-body">
					<form method="POST" action="/students/update/{{$student->id}}">

						{{csrf_field()}}

                       
                        <input type="hidden" name="_method" value="PUT" />
                       


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
                            		<input class="form-control" name="first_name" required="required" type="text" maxlength="45" value="{{$student->first_name}}">
                            	</div>		                 
                            </div>
                            <div class="form-group col-sm-4">
                            	<label for="" class="req">Middle Name</label>
                            	<div class="input-group">
                            		<span class="input-group-addon">
                            			<i class="fa fa-user"></i>
                            		</span>
                            		<input class="form-control" name="middle_name" type="text" maxlength="45" value="{{$student->middle_name}}">
                            	</div>     
                            </div>
                            <div class="form-group col-sm-4">
                            	<label for="surname">Surname</label>
                            	<div class="input-group">
                            		<span class="input-group-addon">
                            			<i class="fa fa-user"></i>
                            		</span>
                            		<input class="form-control" id="surname" name="surname" required="required" type="text" maxlength="45" value="{{$student->surname}}">
                            	</div>
                            </div>		                                
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-4">
                            	<label for="" class="req">Date of Birth</label>
                            	<div class="input-group">
                            		<span class="input-group-addon">
                            			<i class="fa fa-calendar-plus-o"></i>
                            		</span>
                            		<input class="form-control" id="datepicker" name="date_of_birth" required="required" value="{{$student->date_of_birth->format('m/d/Y')}}">
                            	</div>
                            </div>
                            <div class="form-group col-sm-4">
                            	<label for="" class="req">Gender</label>
                            	<select name="gender" class="form-control" required="">
                                    @foreach($genders as $gender)
                                        @if($gender === $student->gender)
                                            <option value="{{$gender}}" selected="">{{$gender}}</option>
                                        @else
                                            <option value="{{$gender}}">{{$gender}}</option>
                                        @endif
                                    @endforeach
                            	</select>
                            </div>
                           <div class="form-group col-sm-4">
                                <label>Country</label>
                                <input type="text" name="country" class="form-control" value="{{$student->country}}">
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
                            <div class="form-group col-sm-6">
                                <label>Phone</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </span>
                                    <input type="" name="phone" class="form-control" value="{{$student->phone}}">
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">County Of Origin</label>
                                <select name="county" class="form-control select2">
                                    @foreach($counties as $name => $value)
                                        @if($value === $student->county)
                                            <option value="{{$value}}" selected="">{{$name}}</option>
                                        @else
                                            <option value="{{$value}}">{{$name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label>Address</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-home"></i>
                                    </span>
                                    <input type="text" class="form-control" name="address" value="{{$student->address}}">
                                </div>
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
                            	<label for="last_school">Last school attended</label>
                            	<div class="input-group">
                            		<span class="input-group-addon">
                            			<i class="fa fa-institution"></i>
                            		</span>
                            		<input class="form-control" value="{{$student->last_school}}" name="last_school" id="last_school" type="text" maxlength="100">
                            	</div>
                            </div>
                            <div class="form-group col-sm-6">
                            	<label for="past_class_name">Last class</label>
								<select name="last_grade" id="last_grade" class="form-control" required="">
			
                                    @foreach($grades as $grade)
                                        @if($grade->id === $student->last_grade)
                                            <option value="{{$grade->id}}" selected="">{{$grade->name}}</option>
                                        @else
                                            <option value="{{$grade->id}}">{{$grade->name}}</option>
                                        @endif
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
                                    @foreach($types as $type)
                                        @if($type === $student->student_type)
                                            <option value="{{$type}}" selected="">{{$type}}</option>
                                        @else
                                            <option value="{{$type}}">{{$type}}</option>
                                        @endif
                                    @endforeach
								</select>
                        	</div>
                        	<div class="form-group col-sm-6">
                        		<label>Class</label>
                        		<select name="grade_id" id="grade_id" class="form-control" required="">
									@foreach($grades as $grade)
                                        @if($grade->id === $student->grade_id)
                                            <option value="{{$grade->id}}" selected="">{{$grade->name}}</option>
                                        @else
                                            <option value="{{$grade->id}}">{{$grade->name}}</option>
                                        @endif
									@endforeach
								</select>
                        	</div>
                        </div>	
						
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <input type="submit" name="update" class="btn btn-success form-control" value="Update">
                            </div>
                        </div>
					</form>
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
@endsection