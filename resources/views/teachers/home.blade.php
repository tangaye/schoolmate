@extends('layouts.master')

@section('page-title', 'Home')

@section('page-header', 'Home')

@section('page-description', 'Teacher Control Panel')

@section('page-css')
<!-- Animate css -->
  <link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
@endsection
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home </a></li>
    <li class="active">Dashboard</li>
@endsection

@section('user-logout')
  @component('components.user-logout')
      @slot('user_name')
          {{Auth::guard('teacher')-> user()->user_name}}
      @endslot
      {{route('teacher.logout')}}
  @endcomponent
@endsection


@section('sidebar-navigation')
<!-- Sidebar Menu -->
<ul class="sidebar-menu">
  <li class="header">TEACHER NAVIGATION</li>
  <li class="">
    <a href="{{route('teacher.dashboard')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
    </a>
  </li>
</ul>
<!-- /.sidebar-menu -->
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <span>WELCOME TEACHER:</span> <strong>{{Auth::guard('teacher')->user()->first_name }} {{Auth::guard('teacher')->user()->surname }}</strong> 
        </div>

        <div class="panel-body text-center">
          <h1>WELCOME TEACHER</h1>
        </div>
      </div>
    </div>  
  </div>
@endsection


@section('page-scripts')

  @if($flash = session('welcome'))
      <script type="text/javascript">
          var message = "Welcome <b>{{$flash}}</b>!";
          welcome(message);
      </script>
  @endif
@endsection