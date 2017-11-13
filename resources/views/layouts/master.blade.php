<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name') }} | @yield('page-title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" type="text/css" href="{{ asset("/css/media-print.css") }}" media="print">
  <!-- Bootstrap 3.3.2 -->
  <link href="{{ asset("/css/app.css") }}" rel="stylesheet" type="text/css" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

  <!-- custom page css -->
  @yield('page-css')

  <!-- Theme style -->
  <link href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.css")}}" rel="stylesheet" type="text/css" />

  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
  <link href="{{ asset("/bower_components/AdminLTE/dist/css/skins/skin-black.css")}}" rel="stylesheet" type="text/css" />
</head>

<body class="hold-transition skin-black sidebar-mini">
  <div class="wrapper">

    <!-- Main Header -->
    @include('layouts.header')
    
    <!-- Left side column. contains the logo and sidebar -->
    @include('layouts.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          @yield('page-header')
          <small>@yield('page-description')</small>
        </h1>
        <ol class="breadcrumb">
          @yield('breadcrumb')
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Your Page Content Here -->
        @yield('content')

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
    <!-- To the right -->
      <div class="pull-right hidden-xs">
        <span class="text-danger"><b>This is currently for demo purpose only!</b></span>
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; <a href="javascript:"><b>School</b>MATE</a>.</strong> All rights reserved.
    </footer>

    @include('layouts.partials.control-sidebar')

</div>  
  <!-- REQUIRED JS SCRIPTS -->

    <script src="{{ asset ("/js/app.js") }}"></script>

    <!-- adding optional page lavel scripts -->
    @yield('page-scripts')


    <!-- AdminLTE App -->
    <!-- this should be the last to be loaded -->
    <script src="{{ asset ("/bower_components/AdminLTE/dist/js/app.min.js") }}" type="text/javascript"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/dist/js/demo.js") }}" type="text/javascript"></script>
</body>
</body>
</html>
