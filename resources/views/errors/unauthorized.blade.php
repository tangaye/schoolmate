<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name') }} | Unauthorized</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- Bootstrap 3.3.2 -->
  <link href="{{ asset("/css/app.css") }}" rel="stylesheet" type="text/css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  

  <!-- Theme style -->
  <link href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />

<style>
    body {
        font-family: 'Source Sans Pro', sans-serif;
    }
    .well {
        margin: 50px auto;
        text-align: center;
        padding: 25px;
        max-width: 600px;
    }
    h1, h2, h3, p {
        margin: 0;
    }
    p {
        font-size: 17px;
        margin-top: 25px;
    }
    p a.btn {
        margin: 0 5px;
    }
    h1 .glyphicon {
        vertical-align: -5%;
        margin-right: 5px;
    }
    </style>

</head>
<body>

    <div class="container">
        <div class="well">
            <h1><div class="glyphicon glyphicon-ban-circle text-danger"></div> 403 Forbidden</h1>
            <p>Sorry! You don't have access permissions for this page.</p>
            <p>
                <a class="btn btn-primary btn-lg" href="/home">Take Me Home!</a>
            </p>
        </div>
    </div>

</body>
</html>
<script src="{{ asset ("/js/app.js") }}"></script>
