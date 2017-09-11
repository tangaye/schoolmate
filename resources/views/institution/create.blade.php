@extends('layouts.master')

@section('page-title', 'Institution')

@section('meta')
    <meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('page-css')
<!-- Animate css -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />

<!-- date picker -->
<link href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header', 'School Information')


@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Enter School Information</div>
                <div class="panel-body">
                    <form method="POST" action="/institution" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-12">
                                <label for="name" class="control-label">Name</label>

                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="name" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group{{ $errors->has('date_established') ? ' has-error' : '' }} col-md-12">
                                <label for="date_established" class="control-label">Date Established</label>
                                <input id="date_established" type="text" class="form-control date" name="date_established" value="{{ old('date_established') }}" required autofocus>

                                @if ($errors->has('date_established'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date_established') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="row">

                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }} col-md-12">
                                <label for="phone" class="control-label">Phone Number</label>

                                <input data-inputmask='"mask": "(9999) 999-999"' data-mask id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required autofocus>

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
                            <div class="form-group{{ $errors->has('motto') ? ' has-error' : '' }} col-md-12">
                                <label for="motto" class="control-label">Motto</label>

                                <input name="motto" id="motto" type="text" class="form-control"  value="{{ old('motto') }}" required autofocus>

                                @if ($errors->has('motto'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('motto') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} col-md-12">
                                <label for="email" class="control-label">E-Mail Address</label>

                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }} logoWarning col-md-12">
                                <label for="logo" class="control-label">Logo</label>
                                <input type="file" class="form-control logo" name="logo">

                                @if ($errors->has('logo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('logo') }}</strong>
                                    </span>
                                @endif

                                <span class="help-block hidden logoWarningMsg">
                                    <strong class="logoWarningMsg"></strong>
                                </span>
                            </div>
                        </div>



                        <div class="form-group">
                            <button type="submit" class="btn btn-primary form-control">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('page-scripts')
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
    <script src="{{ asset ("/bower_components/AdminLTE/plugins/input-mask/jquery.inputmask.js") }}"></script>

    <script type="text/javascript">
        //Date picker
        $('#date_established').datepicker({
          autoclose: true
        });

        $("[data-mask]").inputmask();

        // check if student picture is greater than 2mb
        // If it is avoid upload of such large file by 
        // removing the image choosen by the user
        // and display an warning message
        $('.logo').on('change', function(event) {
            event.preventDefault();
            /* Act on the event */

            var LogoSize = this.files[0].size/1024/1024// in MB

            if (LogoSize > 2) {
                $('.logoWarning').addClass('has-warning');
                $('.logoWarningMsg').removeClass('hidden');
                $('.logoWarningMsg').html('Please choose an image less than 2mb.');
                $('.logo').val(null);
               // $(file).val(''); //for clearing with Jquery
            } else {
                $('.logoWarning').removeClass('has-warning');
                $('.logoWarningMsg').addClass('hidden');
                $('.logoWarningMsg').html(null);
            }
        });

    </script>
@endsection
