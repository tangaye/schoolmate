
<div class="col-md-12">
	<div class="well">
		<form id="transcript_form">

			{{csrf_field()}}

			<div class="row">
				<div class="col-md-12">
					<legend>Transcript Setup</legend>
				</div>
			</div>

			<input type="" hidden="" name="student_id" value="{{$student_id}}">

			<div class="row">
				<div class="form-group col-md-4">
					<label class="control-label">Conduct</label>
					<select name="conduct" class="form-control">
						<option value="Excellent">Excellent</option>
						<option value="Very Good">Very Good</option>
						<option value="Good">Good</option>
						<option value="Fair">Fair</option>
						<option value="Poor">Poor</option>
						<option value="Very Poor">Very Poor</option>
					</select>
				</div>

				<div class="form-group col-md-4">
					<label class="control-label">Reason for leaving</label>
					<select name="leaving_reason" class="form-control">
						<option value="Graduated">Graduated</option>
						<option value="Travelling">Travelling</option>
						<option value="Relocating">Relocating</option>
						<option value="Not Stated">Not Stated</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12">

					<label class="control-label">Grades Student have been enrolled in:</label>
					<p>
						<strong class="text-danger">Note:</strong> If the grades shown below <span class="glyphicon glyphicon-hand-down"></span> is more than three(3) please be aware that you're allow to select only three(3) or less. You won't be allow to generate transcript for four(4) or more grades.
					</p>
					@foreach($grades as $key => $value)
					 	<label class="checkbox-inline">
					      <input class="grade-checkbox" type="checkbox" name="grades_id[{{$value}}]" value="{{$value}}">{{$key}}
					    </label>
					@endforeach
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<button class="btn btn-success generate_transcript" disabled="true">
						<i class="glyphicon glyphicon-send"></i> 
						Generate Transcript
					</button>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>
<div id="transcript">
	
</div>