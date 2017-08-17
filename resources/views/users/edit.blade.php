@extends('layouts.master')

@section('page-title', 'Edit User')

@section('meta')
    <meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('page-header', 'Edit User')

@section('page-css')
<!-- date picker -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css") }}" rel="stylesheet" type="text/css" />
@endsection


@section('content')

	<div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img src="{{ asset("/bower_components/AdminLTE/dist/img/user2-160x160.jpg") }}" class="profile-user-img img-responsive img-circle" alt="User profile picture"/>

                    <h3 class="profile-username text-center">{{$user->first_name}} {{$user->surname}}</h3>

                    <p class="text-muted text-center">{{$user->type}}</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                          <b>Username</b> <a class="pull-right">{{$user->user_name}}</a>
                        </li>
                        <li class="list-group-item">
                          <b>Email</b> <a class="pull-right">{{$user->email}}</a>
                        </li>
                        @if(AutH::user()->hasType('\App\Guardian'))
                            <li class="list-group-item">
                              <b>Relationship</b> <a class="pull-right">{{$user->relationship}}</a>
                            </li>
                        @endif
                        <li class="list-group-item">
                          <b>Date Of Birth</b> <a class="pull-right">{{$user->date_of_birth->toFormattedDateString()}}</a>
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
                  <strong><i class="fa fa-book margin-r-5"></i>Education</strong>

                  <p class="text-muted">
                    {{$user->education}}
                  </p>

                  <hr>

                  <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

                  <p class="text-muted">{{$user->address}}</p>

                  <hr>

                </div>
                <!-- /.box-body -->
            </div>
              <!-- /.box -->
        </div>
		<div class="col-md-9">

            @include ('layouts.errors')
            
			<div class="panel panel-default">
				<!-- Default panel contents -->
				<div class="panel-heading">
					<div class="container-fluid">
						<span class="panel-title">Edit User</span>
						<!-- button that triggers modal -->
						<a role="button" class="pull-right" href="/users" title="students table">
							<span class="badge label-primary"><i class="glyphicon glyphicon-arrow-left"></i> </span>
						</a>
					</div>
					
				</div>
				<div class="panel-body">
					<form method="POST" action="/users/update/{{$user->id}}">

                        {{ csrf_field() }}
                        {{-- this is required for every update request --}}
                        <input type="hidden" name="_method" value="PUT" />

                        <div class="row">
                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }} col-md-6">
                                <label for="first_name" class="control-label">First Name</label>

                                <input type="text" class="form-control" name="first_name" value="{{$user->first_name}}" id="first_name" required autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }} col-md-6">
                                <label for="surname" class="    control-label">Last Name</label>

                                <input id="surname" type="text" class="form-control" name="surname" value="{{$user->surname}}" required autofocus>

                                @if ($errors->has('surname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group{{ $errors->has('date_of_birth') ? ' has-error' : '' }} col-md-6">
                                <label for="date_of_birth" class="control-label">Date Of Birth</label>

                                <input id="date_of_birth" type="text" class="form-control date" name="date_of_birth" value="{{$user->date_of_birth->format('m/d/Y')}}" required autofocus>

                                @if ($errors->has('date_of_birth'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date_of_birth') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }} col-md-6">
                                <label for="gender" class="control-label">Gender</label>

                                <select name="gender" class="form-control" required="">
                                    @foreach($genders as $gender)
                                        @if($gender === $user->gender)
                                            <option value="{{$gender}}" selected="">{{$gender}}</option>
                                        @else
                                            <option value="{{$gender}}">{{$gender}}</option>
                                        @endif
                                    @endforeach
                                </select>

                                @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group{{ $errors->has('education') ? ' has-error' : '' }} col-md-4">
                                <label for="education" class="control-label">Education</label>

                                <select id="education" type="text" class="form-control" name="education" required autofocus>
                                    @foreach($educations as $education)
                                        @if($education === $user->education)
                                            <option value="{{$education}}" selected="">{{$education}}</option>
                                        @else
                                            <option value="{{$education}}">{{$education}}</option>
                                        @endif
                                    @endforeach
                                </select>

                                @if ($errors->has('education'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('education') }}</strong>
                                    </span>
                                @endif
                            </div>

                            

                            <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }} col-md-4">
                                <label for="country" class="control-label">Country</label>

                                <input id="country" type="text" class="form-control" name="country" value="{{$user->country }}" required autofocus>

                                @if ($errors->has('country'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('country') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }} col-md-4">
                                <label for="phone" class="control-label">Phone Number</label>

                                <input data-inputmask='"mask": "(9999) 999-999"' data-mask id="phone" type="text" class="form-control" name="phone" value="{{$user->phone}}" required autofocus>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }} col-md-12">
                                <label for="address" class="control-label">Address</label>

                                <input name="address" id="address" type="text" class="form-control"  value="{{$user->address}}" required autofocus>

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }} col-md-12">
                                <label for="type" class="control-label">Type</label>
                                <select id="type" name="type" class="form-control">
                                    @foreach($roles as $role)
                                        @if($role === $user->type)
                                            <option value="{{$user->type}}" selected="">{{$user->type}}</option>
                                        @else
                                            <option value="{{$role}}">{{$role}}</option>
                                        @endif
                                    @endforeach
                                </select>

                                @if ($errors->has('type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }} col-md-12">
                                <label for="user_name" class="control-label">User Name</label>

                                <input id="user_name" type="text" class="form-control" name="user_name" value="{{$user->user_name}}" required autofocus>

                                @if ($errors->has('user_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} col-md-12">
                                <label for="email" class="control-label">E-Mail Address</label>

                                <input id="email" type="email" class="form-control" name="email" value="{{$user->email}}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="checkbox form-group col-md-12">
                                <label>
                                    <input id="reset" type="checkbox" value="">
                                    <b> Reset Password?<b>
                                </label>
                            </div>
                        </div>

                        <div class="row resetpassword hidden">
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} col-md-6">
                                <label for="password" class="control-label">Password</label>

                                <input id="password" type="password" class="form-control password" name="password" value="{{old('password')}}">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control password" name="password_confirmation">
                                </div>
                            </div>

                        </div>
                    

                        <div class="form-group">
                            <button type="submit" class="btn btn-info form-control">Update</button>
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
        $('#date_of_birth').datepicker({
          autoclose: true
        });

        $("[data-mask]").inputmask();

        $(document).ready(function($) {
            $('#reset').change(function() {
                if ($('#reset').is(':checked')) {
                    $(".resetpassword").removeClass('hidden');
                    $('.password').attr('required', true);
                    $(".resetpassword").show();
                } else {
                    $(".resetpassword").addClass('hidden');
                    $('.password').attr('required', false);
                    $(".resetpassword").hide();
                }
            });
        });
    </script>   
@endsection