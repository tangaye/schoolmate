<div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Enter Subject</h4>
            </div>

            <div class="modal-body">

                <form action="" method="post" id='add-form'>
                	{{csrf_field()}}
                	
                    <div class="box-body">
                    	<!-- div to display errors returned by server -->
                    	<div class="errors alert alert-danger hidden">
                    	</div>
                    	<!-- end of errors div -->

                        <div class="form-group">
                            <label for="name">Name</label>
                            <p class="name-error text-danger hidden"></p>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-book"></i>
                                </span>
                                <input class="form-control" name="name" id="name" type="text" placeholder="Subject name" required="true">
                            </div>   
                        </div>

                        <div class="form-group">
                            <label for="division">Grades/Classes</label>
                            <p class="text-muted">Please select the grades/class(es) the subject is taught within.</p>
                            <select class="form-control select2" multiple="multiple" data-placeholder="Select grade(s)" style="width: 100%;" id="grade_id" name="grade_id[]" >
                                @foreach($grades as $grade)
                                    <option value="{{$grade->id}}">{{$grade->name}}</option>
                                @endforeach 
                            </select>                           
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                        	<button name="add-btn" id="insert-subject" class="btn btn-primary form-control"> <i class="glyphicon glyphicon-save"></i> Save</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
	</div>  
</div>