<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name') }} | Reset Password</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{csrf_token()}}">

  <!-- Bootstrap 3.3.2 -->
  <link href="{{ asset("/css/app.css") }}" rel="stylesheet" type="text/css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

  <!-- Theme style -->
  <link href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />



  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>School</b>MATE</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Enter E-Mail Address To Reset Password</p>

    <form role="form" method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}
          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
            <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" placeholder="email" required autofocus>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary form-control">Send Password Reset Link</button>
          </div>
          <div class="row">
              <a class="btn btn-link pull-left" href="/">Back</a>
          </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
</body>
</html>

