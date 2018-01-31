<!-- ************************************************************************** -->
<!-- ************************** Grades Sponsor Modal ********************* -->
<!-- ************************************************************************** -->

<div class="modal fade" id="sponsor_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><b>{{$current_academic->year_start."/".$current_academic->year_end}}</b> Grade Sponsor Form</h4>
            </div>

            <div class="modal-body">

                @component('components.loader')
                @endcomponent

                <form action="" method="PUT" id='sponsor_grade_form'>

                    {{csrf_field()}}
                    
                    <div class="box-body">
                        <!-- div to display errors returned by server-->
                        <div class="errors alert alert-danger alert-dismissable hidden">
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
                                <i class='glyphicon glyphicon-remove-circle'></i>
                            </button>
                            <b><i class='glyphicon glyphicon-ban-circle'></i>Alert! </b>
                            <span class="errors"></span>
                        </div>
                        <!-- end of errors div -->

                        <div class="hidden">
                            <input type="text" name="academic_id" id="academic_id" class="hidden" value="{{$current_academic->id}}" disabled="true">
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="student">Teachers</label>
                            <select class="form-control teacher" style="width: 100%;" id="teacher_id" name="teacher_id" >
                            </select>
                            <p class="teacher-error text-danger hidden"></p>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Sponsor Grade</label>
                            <select class="form-control" disabled="" id="grade_id" name="grade_id">
                            </select>  
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button name="save-btn" disabled="" class="btn btn-primary new_sponsor_btn"> 
                    <i class="glyphicon glyphicon-ok"></i> 
                    Assign Sponsor
                </button>

                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Close</button>
            </div>
        </div>
    </div>  
</div>