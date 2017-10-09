@extends('layouts.master')

@section('page-title', 'Edit Student')

@section('user-logout')
  @component('components.user-logout')
      @slot('user_name')
          {{Auth::guard('web')-> user()->user_name}}
      @endslot
      {{route('user.logout')}}
  @endcomponent
@endsection


@section('page-header', 'Edit Student')

@section('page-css')
<!-- date picker -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css") }}" rel="stylesheet" type="text/css" />
@endsection


@section('sidebar-navigation')
<!-- Sidebar Menu -->
<ul class="sidebar-menu">
  <li class="header">USER NAVIGATION</li>

  <li class="">
    <a href="{{route('user.dashboard')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
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
      <li><a href="/users/guardians"><i class="glyphicon glyphicon-th-list"></i> <span>Guardians</span></a></li>
      <li><a href="/users/guardians/create"><i class="fa fa-pencil"></i>New Guardian</a></li>
    </ul>
  </li>

  <!-- student -->
  <li class="treeview active">
    <a href="#">
      <i class="fa fa-users"></i><span>Students</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="active"><a href="/users/students"><i class="glyphicon glyphicon-list-alt"></i>Student List</a></li>
      <li><a href="/users/students/create"><i class="fa fa-pencil"></i>Student Admission</a></li>
    </ul>
  </li>

  <!-- score -->
<li class="">
    <a href="/users/scores"><i class="glyphicon glyphicon-list-alt"></i> <span>Score Tables</span>
    </a>
  </li>
</ul>
@endsection


@section('content')

	<div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    @if($student->photo)
                        <img src="{{ asset("images/".$student->photo) }}" class="profile-user-img img-responsive img-circle" alt="User profile picture"/>
                    @else
                        <img src="{{ asset("images/default.png") }}" class="profile-user-img img-responsive img-circle" alt="User profile picture"/>
                    @endif

                    <h3 class="profile-username text-center">{{$student->first_name}} {{$student->middle_name}} {{$student->surname}}</h3>

                    <p class="text-muted text-center">{{$student->grade->name}}</p>

                    <ul class="list-group list-group-unbordered">
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

            <!-- Widget: Student guardian -->
              <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                @if($student->guardian)
                    <div class="widget-user-header bg-yellow">
                      <h3><a style="color: white;" href="/users/guardians/edit/{{$student->guardian->id}}">{{$student->guardian->first_name}} {{$student->guardian->surname}}</a></h3>
                      <h5>{{$student->guardian->relationship}}</h5>
                    </div>
                    <div class="box-footer no-padding">
                      <ul class="nav nav-stacked">
                        <li>
                            <a href="javascript:void(0)">Phone
                                <span class="pull-right badge bg-blue">
                                    {{$student->guardian->phone}}
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">Address 
                                <span class="pull-right badge bg-aqua">
                                    {{$student->guardian->address}}
                                </span>
                            </a>
                        </li>
                      </ul>
                    </div>
                @endif
              </div>
              <!-- /.widget-user -->
        </div>
		<div class="col-md-9">

			<div class="panel panel-default">
				<!-- Default panel contents -->
				<div class="panel-heading">
					<div class="container-fluid">
						<span class="panel-title">Edit Student</span>
						<!-- button that triggers modal -->
						<a role="button" class="pull-right" href="" onclick="history.back()" title="students table">
							<span class="badge label-primary"><i class="glyphicon glyphicon-arrow-left"></i> </span>
						</a>
					</div>
					
				</div>
				<div class="panel-body">
					<form method="POST" action="/students/update/{{$student->id}}" enctype="multipart/form-data">

						{{csrf_field()}}

                        {{-- this is required for every update request --}}                       
                        <input type="hidden" name="_method" value="PUT" />
                       
                    	<!-- personal information -->  
                    	<div class="form-group">
                    		<p>
                                <b>PERSONAL INFOMATION:</b>
                                <hr>
                            </p>
                    	</div>

                        <div class="row">
                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }} col-sm-4">
                                <label for="" class="control-label">First Name</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <input class="form-control" name="first_name" required="required" type="text" maxlength="45" value="{{$student->first_name}}">
                                </div>
                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif                   
                            </div>
                            <div class="form-group{{ $errors->has('middle_name') ? ' has-error' : '' }} col-sm-4">
                                <label for="" class="control-label">Middle Name</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <input class="form-control" name="middle_name" type="text" maxlength="45" value="{{$student->middle_name}}">
                                </div>  
                                @if ($errors->has('middle_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif   
                            </div>
                            <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }} col-sm-4">
                                <label for="surname" class="control-label">Surname</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <input class="form-control" id="surname" name="surname" required="required" type="text" maxlength="45" value="{{$student->surname}}">
                                </div>

                                @if ($errors->has('surname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>                                      
                        </div>

                        <div class="row">
                            <div class="form-group{{ $errors->has('date_of_birth') ? ' has-error' : '' }} col-sm-6">
                                <label for="datepicker" class="control-label">Date of Birth</label>
                                <div class="input-group date">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar-plus-o"></i>
                                    </span>
                                    <input class="form-control" id="datepicker" name="date_of_birth" required="required" value="{{$student->date_of_birth->format('m/d/Y')}}">
                                </div>

                                @if ($errors->has('date_of_birth'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date_of_birth') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }} col-sm-6">
                                <label for="" class="control-label">Gender</label>
                                <select name="gender" class="form-control" required="">
                                    @foreach($genders as $gender)
                                        <option value="{{$student->gender}}" {{$student->gender === $gender ? 'selected' : ''}}>Female</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('gender'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="row"> 
                            <div class="form-group{{ $errors->has('county') ? ' has-error' : '' }} col-sm-6">
                                <label for="county">County</label>
                                <select name="county" id="county" class="form-control">
                                    @foreach($counties as $name => $value)
                                        <option value="{{$value}}" {{$student->county === $value ? 'selected' : ''}}>{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                             @if ($errors->has('county'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('county') }}</strong>
                                </span>
                            @endif

                            <div class="form-group{{ $errors->has('religion') ? ' has-error' : '' }} col-sm-6">
                                <label for="religion" class="control-label">Religion</label>
                                <select class="form-control" name="religion" id="religion">
                                    @foreach($religions as $name => $value)
                                        <option value="{{$value}}" {{$student->religion === $value ? 'selected' : ''}}>{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('religion'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('religion') }}</strong>
                                </span>
                            @endif
                        </div>

                        <!-- contact information -->
                        <div class="form-group">
                            <p>
                                <b>CONTACT DETAILS:</b>
                                <hr>
                            </p>
                        </div>

                        <div class="row">
                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }} col-sm-12 col-md-12 col-xs-12">
                                <label for="address" class="control-label">Address</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-home"></i>
                                    </span>
                                    <input id="address" type="text" class="form-control" name="address" value="{{$student->address}}">
                                </div>
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }} col-sm-6">
                                <label for="phone" class="control-label">Phone</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </span>
                                    <input id="phone" type="" name="phone" class="form-control" data-inputmask='"mask": "(9999) 999-999"' value="{{$student->phone}}" phone-mask>
                                </div>
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }} col-sm-6">
                                <label for="country" class="control-label">Country</label>
                                <input type="text" id="country" name="country" value="{{$student->country}}" class="form-control" required="">

                                @if ($errors->has('country'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('country') }}</strong>
                                    </span>
                                @endif
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
                            <div class="form-group{{ $errors->has('last_school') ? ' has-error' : '' }} col-sm-6">
                                <label for="last_school" class="control-label">Last school attended</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-institution"></i>
                                    </span>
                                    <input id="last_school" class="form-control" name="last_school" id="last_school" type="text" maxlength="100" value="{{$student->last_school}}">
                                </div>

                                @if ($errors->has('last_school'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_school') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('last_grade') ? ' has-error' : '' }} col-sm-6">
                                <label for="last_grade" class="control-label">Last class</label>
                                <select name="last_grade" id="last_grade" class="form-control" required="">
                                    @foreach($grades as $grade)
                                        <option value="{{$grade->id}}" {{$student->last_grade === $grade->id ? 'selected' : ''}}>{{$grade->name}}</option>
                                    @endforeach
                                </select>
                            </div>  
                            @if ($errors->has('last_grade'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('last_grade') }}</strong>
                                </span>
                            @endif
                        </div>

                        <!-- school information -->
                        <div class="form-group">
                            <p>
                                <b>School Information</b>
                                <hr>
                            </p>                                
                        </div>

                        <div class="row">
                            <div class="form-group{{ $errors->has('student_type') ? ' has-error' : '' }} col-sm-6">
                                <label id="type" class="control-label">Student Type</label>
                                <select name="student_type" id="type" required="required" class="form-control">
                                    @foreach($types as $type)
                                        <option value="{{$type}}" {{$student->student_type == $type ? 'selected' : ''}}>{{$type}}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if ($errors->has('student_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('student_type') }}</strong>
                                </span>
                            @endif
                            <div class="form-group{{ $errors->has('grade_id') ? ' has-error' : '' }} col-sm-6">
                                <label id="grade" class="control-label">Class</label>
                                <select name="grade_id" id="grade" class="form-control" required="">
                                    @foreach($grades as $grade)
                                        <option value="{{$grade->id}}" {{$student->grade_id === $grade->id ? 'selected' : ''}}>{{$grade->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if ($errors->has('grade_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('grade_id') }}</strong>
                                </span>
                            @endif
                        </div>  

                        <!-- student photo -->

                        <!-- student photo -->
                        <div class="row">
                            <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }} photoWarning col-md-12">
                                <label class="control-label">Update Student Photo</label>
                                <input type="file" class="form-control photo" name="photo">

                                @if ($errors->has('photo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('photo') }}</strong>
                                    </span>
                                @endif

                                <span class="help-block hidden photoWarningMsg">
                                    <strong class="photoWarningMsg"></strong>
                                </span>
                            </div>
                        </div>



                        <!-- school information -->
                        <div class="form-group">
                            <p>
                                <b>Student Guardian</b>
                                <hr>
                            </p>                                
                        </div>
                        <div class="row">
                            <div class="form-group{{ $errors->has('guardian_id') ? ' has-error' : '' }} col-sm-12">
                                <label id="guardian" class="control-label">Guardian</label>
                                <select name="guardian_id" id="guardian" class="form-control guardians" style="width: 100%;" required="">
                                    <option value="">None Selected(Please Select Guardian)</option>
                                    @foreach($guardians as $guardian)
                                        <option value="{{$guardian->id}}" {{$guardian->id == $student->guardian->id ? 'selected' : ''}}>{{$guardian->first_name}} {{$guardian->surname}}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if ($errors->has('guardian_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('guardian_id') }}</strong>
                                </span>
                            @endif
                        </div>  
						
                        @can('update-student')
                          <div class="row">
                              <div class="form-group col-sm-12">
                                  <input type="submit" name="update" class="btn btn-info form-control" value="Update">
                              </div>
                          </div>
                        @endcan
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

        $("[phone-mask]").inputmask();

        // check if student picture is greater than 2mb
        // If it is avoid upload of such large file by 
        // removing the image choosen by the user
        // and display an warning message
        $('.photo').on('change', function(event) {
            event.preventDefault();
            /* Act on the event */

            var PhotoSize = this.files[0].size/1024/1024// in MB

            if (PhotoSize > 2) {
                $('.photoWarning').addClass('has-warning');
                $('.photoWarningMsg').removeClass('hidden');
                $('.photoWarningMsg').html('Please choose an image less than 2mb.');
                $('.photo').val(null);
               // $(file).val(''); //for clearing with Jquery
            } else {
                $('.photoWarning').removeClass('has-warning');
                $('.photoWarningMsg').addClass('hidden');
                $('.photoWarningMsg').html(null);
            }
        });
    </script>
@endsection