@extends('layouts.master')

@section('page-title', 'Home')

@section('page-header', 'Home')

@section('page-description', 'Control Panel')

@section('page-css')
<!-- Animate css -->
  <link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
@endsection
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home </a></li>
    <li class="active">Dashboard</li>
@endsection

@section('content')
    @include('layouts.partials.stats-bar')
@endsection


@section('page-scripts')

  @if($flash = session('welcome'))
      <script type="text/javascript">
          var message = "Welcome <b>{{$flash}}</b>!";
          welcome(message);
      </script>
  @endif
@endsection