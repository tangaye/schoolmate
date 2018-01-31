<!-- ************************************************************************** -->
<!-- ************************** Students Enrollment model ********************* -->
<!-- ************************************************************************** -->

<div class="modal fade" id="enrollment-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><b>{{$current_academic->year_start."/".$current_academic->year_end}}</b> Student Enrollment Form</h4>
            </div>

            <div class="modal-body">

                @component('components.loader')
                @endcomponent

                <form action="" method="PUT" id='enrollment-form'>
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
                            <label class="control-label" for="student">Students</label>
                            <select class="form-control student" style="width: 100%;" id="student" name="student_id" >
                                <option value="" selected="">Select Students</option>
                            </select>
                            <p class="student-error text-danger hidden"></p>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Last Grade</label>
                            <select class="form-control" disabled="" id="last_grade" name="last_grade">
                                @foreach($grades as $grade)
                                    <option value="{{$grade->id}}">{{$grade->name}}</option>
                                @endforeach 
                            </select>       
                        </div>

                        <div class="form-group">
                            <label class="control-label">Current Grade</label>
                            <select class="form-control" disabled="" id="current_grade" name="current_grade">
                                @foreach($grades as $grade)
                                    <option value="{{$grade->id}}">{{$grade->name}}</option>
                                @endforeach 
                            </select>  
                        </div>

                        <div class="form-group">
                            <label class="control-label">Student Type</label>
                            <input type="text" disabled="" id="student_type" name="student_type" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Enrollment Status</label>
                            <select class="form-control enrollment_status"  disabled=""  name="enrollment_status">
                                <option value="" selected="">Select Enrollment Status</option>
                                @foreach($statuses as $status)
                                    <option value="{{$status}}">{{$status}}</option>
                                @endforeach 
                            </select>
                        </div>
                    </div>
                    

                </form>
            </div>
            <div class="modal-footer">
                <button name="save-btn" disabled="" class="btn btn-primary save-enrollment"> 
                    <i class="glyphicon glyphicon-ok"></i> 
                    Enroll Student
                </button>

                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Close</button>
            </div>
        </div>
    </div>  
</div>