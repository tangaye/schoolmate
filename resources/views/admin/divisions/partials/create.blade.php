<form class="form-horizontal" action="" method="post" id='add-form'>
    {{csrf_field()}}

    <!-- div to display errors returned by server -->
    <div class="alert alert-danger alert-dismissable hidden" style="opacity: 0.8;">
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
            <i class='glyphicon glyphicon-remove-circle'></i>
        </button>
        <b><i class='glyphicon glyphicon-ban-circle'></i>Alert! </b>
        <span class="errors"></span>
    </div>


    <div class="form-group">
        <label class="col-sm-2 control-label" for="name">Name</label>
        <div class="col-md-8">
            <input class="form-control" name="name" id="name" type="text" placeholder="Division Name" required="true">
            <p class="name-error text-danger hidden"></p>
        </div>   
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button name="add-btn" id="insert-division" type="submit" class="btn btn-info btn-flat btn-submit" >Save Division</button>
        </div>
    </div>

</form>