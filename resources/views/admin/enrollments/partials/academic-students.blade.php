<div class="row col-md-12">
	<table class="table table-bordered table-condensed table-responsive" id="enrollments">
		<thead>
			@if($academic->status)
				<th class="text-right" colspan="8">
					<button class="btn btn-primary btn-sm pull-right new_enrollment">
						<i class="glyphicon glyphicon-plus"></i> New Enrollment
					</button>
				</th>
			@endif
			<tr>
				<th>Code</th>
				<th>Name</th>
				<th>Last Grade</th>
				<th>Grade</th>
				<th>Student Type</th>
				<th>Enrollment Status</th>
				<th>Acad. Yr.</th>
				@if($academic->status)
					<th class="actions">Actions</th>
				@endif
			</tr>
		</thead>
		<tbody>
			@foreach($students as $student)
				<tr class="enrollment{{$student->enrollment_id}}">
					<td><a href="/students/edit/{{$student->student_id}}">{{$student->student_code}}</a></td>
					<td>{{$student->first_name." ".$student->surname}}</td>
					<td>{{$student->last_grade}}</td>
					<td>{{$student->current_grade}}</td>
					<td>{{$student->student_type}}</td>
					<td>
						@if($student->enrollment_status == "Enrolled")
							<span class="label label-success">{{$student->enrollment_status}}</span>
						@elseif($student->enrollment_status == "Pending")
							<span class="label label-info">{{$student->enrollment_status}}</span>
						@elseif($student->enrollment_status == "Expelled")
							<span class="label label-danger">{{$student->enrollment_status}}</span>
						@elseif($student->enrollment_status == "Suspended")
							<span class="label label-warning">{{$student->enrollment_status}}</span>
						@elseif($student->enrollment_status == "Dropped")
							<span class="label label-default">{{$student->enrollment_status}}</span>
						@endif
					</td>

					<td>{{$academic->year_start."/".$academic->year_end}}</td>
					@if($academic->status)
						<td>
							<a class="edit btn btn-info btn-sm" href="/enrollments/edit/{{$student->enrollment_id}}" role="button">
								 Edit
							</a>
						</td>
					@endif
				</tr>
			@endforeach
		</tbody>
		<tfoot>
		</tfoot>
	</table>
</div>


