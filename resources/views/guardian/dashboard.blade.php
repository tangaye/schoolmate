@extends('layouts.master')

@section('page-title', 'Home')

@section('page-header', 'Home')

@section('page-description', 'Guardian Control Panel')

@section('page-css')

<!-- Animate css -->
  <link href="{{ asset("/bower_components/AdminLTE/plugins/animate/animate.min.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('user-logout')
  @component('components.user-logout')
      @slot('user_name')
          {{Auth::guard('guardian')-> user()->user_name}}
      @endslot
      {{route('guardian.logout')}}
  @endcomponent
@endsection

@section('breadcrumb')
    <li><a href="#"><i class="fa fa-dashboard"></i> Home </a></li>
    <li class="active">Dashboard</li>
@endsection



@section('sidebar-navigation')
<!-- Sidebar Menu -->
<ul class="sidebar-menu">
  <li class="header">MAIN NAVIGATION</li>
  <li class="active">
    <a href="{{route('guardian.dashboard')}}"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
    </a>
  </li>
  <!-- reports -->
  <li class="treeview">
    <a href="#">
      <i class="fa fa-folder-open-o"></i>
      <span>Scores Reports</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="/guardian/students/term"><i class="fa fa-file-text-o"></i>Term Report</a></li>
      <li><a href="/guardian/students/semester"><i class="fa fa-file-text-o"></i>Semester Report</a></li>
      <li><a href="/guardian/students/annual"><i class="fa fa-file-text-o"></i>Annual Report</a></li>
    </ul>
    <li>
      <a href="{{route('guardian.attendence')}}"><i class="glyphicon glyphicon-stats"></i> <span>Students Attendence</span>
      </a>
    </li>
  </li>
</ul>
<!-- /.sidebar-menu -->
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
            @if($logged_in_guardian->gender === "Male")
              <h3> <span>Good day! </span> <strong>Mr. {{$logged_in_guardian->full_name}} </strong></h3>
            @else
              <h3><span>Good day! </span> <strong> Mrs/Ms.{{$logged_in_guardian->full_name}}</strong></h3>
            @endif
            
        </div>

        <div class="panel-body">

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Academic Years</label>
                <select class="form-control" id="academic_years">
                  @if(count($academics) > 0)
                    <option selected="" value="">Select Academic Year</option>
                    @foreach($academics as $academic)
                      @if($academic->status)
                        <option class="text-danger" selected="" style="font-weight: bold;" value="{{$academic->id}}">
                          {{$academic->full_year}}
                          <span>- Current Academic Year</span>
                        </option>
                      @else 
                        <option value="{{$academic->id}}">{{$academic->full_year}}</option>
                      @endif
                    @endforeach
                  @else
                    <option selected="" value="">Seems like students assigned to you are not enrolled yet.</option>
                  @endif
                </select>
              </div>
            </div>
          </div>
          <div id="result">
            
          </div>
        </div>
        <div class="panel-footer">
          <p><strong>Guardian Ward</strong></p>
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

  <script type="text/javascript">

    $(document).ready(function($) {

      var academic_id = $("#academic_years").val();

      if (academic_id != "") {

        $.ajax({
          url: '/guardian/students/dashboard/'+academic_id,
          type: 'GET',
        })
        .done(function(data) {

          if (data.none) {
            $("#result").html(data.none);
          } else {
            $("#result").html(data);
          }
        })
        .fail(function() {
          $("#result").html("An error occur! Please try again, and if problem persists contact administrator.");
        });
        
      } else {
        $("#result").html('');
      }

      $(document).on('change', '#academic_years', function(event) {
        event.preventDefault();
        /* Act on the event */

        var academic_id = $("#academic_years").val();

        if (academic_id != "") {

          $.ajax({
            url: '/guardian/students/dashboard/'+academic_id,
            type: 'GET',
          })
          .done(function(data) {

            if (data.none) {
              $("#result").html(data.none);
            } else {
              $("#result").html(data);
            }
          })
          .fail(function() {
            $("#result").html("An error occur! Please try again, and if problem persists contact administrator.");
          });
          
        } else {
          $("#result").html('');
        }
      });
    });
   
  </script>
@endsection