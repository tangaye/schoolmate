@extends('layouts.master')

@section('page-title', 'New Guardian')

@section('meta')
    <meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('page-css')
<!-- Animate css -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header', 'New Guardian')

@section('user-logout')
  @component('components.user-logout')
      @slot('user_name')
          {{Auth::guard('web')-> user()->user_name}}
      @endslot
      {{route('user.logout')}}
  @endcomponent
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
  <li class="treeview active">
    <a href="#"><i class="fa fa-user"></i> <span>Guardians</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="/users/guardians"><i class="glyphicon glyphicon-th-list"></i> <span>Guardians</span></a></li>
      <li class="active"><a href="/users/guardians/create"><i class="fa fa-pencil"></i>New Guardian</a></li>
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
      <li><a href="/users/students"><i class="glyphicon glyphicon-list-alt"></i>Student List</a></li>
      <li><a href="/users/students/create"><i class="fa fa-pencil"></i>Student Admission</a></li>
    </ul>
  </li>

  <!-- score -->
  <li class="">
    <a href="/users/scores"><i class="glyphicon glyphicon-list-alt"></i> Score Tables
    </a>
  </li>
</ul>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">
                  <div class="container-fluid">
                    <span class="panel-title">New Guardian</span>
                    <!-- button that triggers modal -->
                    <a role="button" class="pull-right" href="/users/guardians" title="students table">
                      <span class="badge label-primary"><i class="glyphicon glyphicon-arrow-left"></i> </span>
                    </a>
                  </div>
                  
                </div>
                <div class="panel-body">
                    <form role="form" method="POST" action="/users/guardians">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }} col-md-12">
                                <label for="first_name" class="control-label">First Name</label>

                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" id="first_name" required autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            
                        </div>
                        <div class="row">
                          <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }} col-md-12">
                                <label for="surname" class="    control-label">Last Name</label>

                                <input id="surname" type="text" class="form-control" name="surname" value="{{ old('surname') }}" required autofocus>

                                @if ($errors->has('surname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">

                            <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }} col-md-6">
                                <label for="gender" class="control-label">Gender</label>

                                <select id="gender" type="text" class="form-control" name="gender" value="{{ old('gender') }}" required autofocus>
                                    <option value="Female">Female</option>
                                    <option value="Male">Male</option>
                                </select>

                                @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }} col-md-6">
                                <label for="phone" class="control-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required="">

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

                                <input name="address" id="address" type="text" class="form-control"  value="{{ old('address') }}" required autofocus>

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group{{ $errors->has('relationship') ? ' has-error' : '' }} col-md-12">
                                <label class="control-label">Relationship</label>

                                <select class="form-control relationship" name="relationship" value="{{ old('relationship') }}">
                                    @foreach($relationships as $relationship)
                                        <option value="{{$relationship}}">{{$relationship}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('relationship'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('relationship') }}</strong>
                                    </span>
                                @endif
                            </div>                          
                        </div>

                        <div class="row">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} col-md-6">
                                <label for="email" class="control-label">E-Mail Address</label>

                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }} col-md-6">
                                <label for="user_name" class="control-label">User Name</label>

                                <input id="user_name" type="email" class="form-control" name="user_name" value="{{old('user_name')}}">

                                @if ($errors->has('user_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} col-md-6">
                                <label for="password" class="control-label">Password</label>

                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                        </div>
                    

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary form-control">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('page-scripts')
    @if($flash = session('message'))
        <script type="text/javascript">
            var message = "User <b>{{$flash}}</b> save!";
            notify(message);
        </script>
    @endif
@endsection
