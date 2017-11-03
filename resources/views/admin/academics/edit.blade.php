

<!-- ************************************************************************** -->
<!-- ************************** EDIT Academic MODAL **************************** -->
<!-- ************************************************************************** -->


<div class="modal fade" id="academic-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Academic</h4>
            </div>

            <div class="modal-body">

                <form action="" method="PUT" id='edit-form'>
                	{{csrf_field()}}
                	
                    <div class="box-body">
                    	<!-- div to display errors returned by server-->
                    	<div class="errors alert alert-danger hidden">
                    	</div>
                    	<!-- end of errors div -->

                        <div class="hidden">
                            <input type="text" id="academic-id" class="hidden" disabled="true">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Date Start</label>
                            <ul>
                                <li class="edit-date-start-error text-danger hidden"></li>
                                {{--ajax error block--}}
                                <li class="edit-date-start-duplicate text-danger hidden"></li>
                            </ul>
                            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy/mm/dd">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                </span>
                                <input type="text" data-date-format="yyyy/mm/dd" id="edit-start" class="form-control edit-dates" name="date_start" required>
                            </div>   
                        </div>

                        <div class="form-group">
                            <label class="control-label">Date End</label>
                            <ul>
                                <li class="edit-date-end-error text-danger hidden"></li>
                                {{--ajax error block--}}
                                <li class="edit-date-end-duplicate text-danger hidden"></li>
                            </ul>

                            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy/mm/dd">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                </span>
                                <input type="text" data-date-format="yyyy/mm/dd" id="edit-end" class="form-control edit-dates" name="date_end" required>
                            </div>   
                        </div>

                        <div class="form-group">
                            <label class="control-label">Status</label>
                            <div id="status-check">
                                
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                        	<button name="edit-btn" id="update-academic" class="btn btn-success form-control"> <i class="glyphicon glyphicon-edit"></i> Update</button>
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