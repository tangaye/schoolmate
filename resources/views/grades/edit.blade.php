
<!-- ************************************************************************** -->
<!-- ************************** EDIT GRADES MODAL **************************** -->
<!-- ************************************************************************** -->


<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Subject</h4>
            </div>

            <div class="modal-body">

                <form action="" method="PUT" id='edit-form'>
                	{{csrf_field()}}
                	
                    @component('components.loader')
                    @endcomponent
                    
                    <div class="box-body">
                    	<!-- div to display errors returned by server-->
                    	<div class="errors alert alert-danger hidden">
                    	</div>
                    	<!-- end of errors div -->

                        <div class="hidden">
                            <input type="text" name="edit-id" id="edit-id" class="hidden" disabled="true">
                        </div>

                        <div class="form-group">
                            <label for="edit-name">Name</label>
                            <p class="name-error text-danger hidden"></p>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-book"></i>
                                </span>
                                <input class="form-control" name="name" id="edit-name" type="text" required="true">
                            </div>   
                        </div>

                        <div class="form-group">

                            <label>Division</label>
                            <p class="text-muted">Please select the division the class is found in.</p>

                            <div class="division-select">
                                
                            </div>
                
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                        	<button name="edit-btn" id="update-grade" class="btn btn-success form-control"> <i class="glyphicon glyphicon-edit"></i> Update</button>
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