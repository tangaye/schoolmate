<!-- Info boxes -->
<div class="row">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Students</span>
        <span class="info-box-number">{{$students_total}}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.close of student count -->

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-education"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Teachers</span>
        <span class="info-box-number">{{$teachers_total}}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>

  <!-- fix for small devices only -->
  <div class="clearfix visible-sm-block"></div>
  
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-female"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Guardians</span>
        <span class="info-box-number">{{$guardians_total}}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->


  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fa fa-user-plus"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Users</span>
        <span class="info-box-number">{{$users_total}}</span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->