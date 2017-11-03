<!-- this modal is used a view to edit student scores -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Score</h4>
            </div>

            <div class="modal-body">

                <form action="" method="PUT" id='score-form'>
                	
                    <div class="box-body">
                    	<!-- div to display errors returned by server-->
                    	<div class="errors alert alert-danger hidden">
                    	</div>
                    	<!-- end of errors div -->

                        <div class="form-group">
                            <label for="edit-name">Name</label>
                            <input readonly="true" disabled="true" class="form-control" id="edit-name" type="text">
                        </div>
                        <div class="form-group">
                            <label for="edit-grade">Grade/Class</label>
                            <input readonly="true" disabled="true" class="form-control" id="edit-grade" type="text">
                        </div>
                        <div class="form-group">
                            <label for="edit-subject">Subject</label>
                            <input readonly="true" disabled="true" class="form-control" id="edit-subject" type="text">
                        </div>
                        <div class="form-group">
                            <label for="edit-score">Score</label>
                            <input class="form-control" id="edit-score" maxlength="3" max="100" min="59" name="score" type="number" required="true">
                        </div>

                        <!-- hidden ids values to be sent to edit student score -->
                        <div class="form-group hidden">
                            <input disabled="" type="number" name="score_id" id="score-id" class="form-control">
                        </div>
                        <div class="form-group hidden">
                            <input type="number" name="student_id" id="student-id" class="form-control hidden">
                        </div>
                        <!-- /.end of hidden values -->

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button name="edit-btn" id="update-score" class="btn btn-success"> Update</button>
            </div>
        </div>
	</div>  
</div>