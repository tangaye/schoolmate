<div class="modal fade" id="attendence-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Edit Attendence</h4>
			</div>

			<div class="modal-body">

				@component('components.loader')
          		@endcomponent

				<!-- div to display errors returned by server-->
            	<div class="errors alert alert-danger hidden">
            	</div>
            	<!-- end of errors div -->

				<form action="" method="PUT" id="attendence-form">
				
					<div class="form-group">
						<label class="control-label">Student Name</label>
						<input readonly="true" disabled="true" type="text" class="form-control" id="edit-name">
					</div>

					<div class="form-group">
						<label class="control-label">Grade</label>
						<input readonly="true" disabled="true" type="text" class="form-control" id="edit-grade">
					</div>

					<div class="form-group">
						<label class="control-label">Subject</label>
						<input readonly="true" disabled="true" type="text" class="form-control" id="edit-subject">
					</div>

					<div class="form-group">
						<label class="control-label">Date</label>
						<input readonly="true" disabled="true" type="text" class="form-control" id="edit-date">
					</div>

					<div class="form-group">
						<label class="control-label">Status</label>
						<select  class="form-control" id="edit-status" name="status"></select>
					</div>

					<div class="form-group">
						<label class="control-label">Remarks</label>
						<textarea class="form-control" id="edit-remarks" name="remarks"></textarea>
					</div>

					<!-- hidden ids values to be sent to edit student score -->
                    <div class="form-group hidden">
                        <input disabled="" type="number" name="attendence_id" id="attendence-id" class="form-control">
                    </div>
                    <!-- /.end of hidden values -->

				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-success" id="update-attendence">Update Attendence</button>
			</div>
		</div>
	</div>
</div>