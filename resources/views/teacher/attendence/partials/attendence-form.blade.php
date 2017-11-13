<form id="attendence-form">
	
	<table class="table table-responsive table-condensed table-striped table-bordered">
		<thead>
			<tr>
				<th>Code</th>
				<th>Name</th>
				<th>Status <span class="text-danger">*</span></th>
				<th>Remarks</th>
			</tr>
		</thead>
		<tbody>
			@foreach($students as $student)
				<tr>
					{{-- student id, subject id, grade id, term id to be sent but are hidden --}}
					<td class="hidden">
						<input class="student" type="text" name="rows[{{$student->id}}][student_id]" value="{{$student->id}}">
					</td>

					<td class="hidden">
						<input class="grade" type="text"  name="rows[{{$student->id}}][grade_id]" value="{{$student->grade_id}}">
					</td>

					<td class="hidden">
						<input class="subject" type="text"  name="rows[{{$student->id}}][subject_id]" value="{{$subject->id}}">
					</td>

					<td  class="hidden">
						<input class="date" type="text"  name="rows[{{$student->id}}][date]" value="{{$date}}">
					</td>

					{{-- end of hidden values to be sent--}}
					<td>
						<a href="javascript:void(0)" title="View student" data-toggle="tooltip">{{$student->student_code}}</a>
					</td>

					<td>
						{{$student->first_name." ".substr($student->middle_name, 0, 1)." ".$student->surname}}
					</td>
					<td>
						<select class="form-control" name="rows[{{$student->id}}][status]" class="status" id="status" required="true">
							@foreach($statuses as $status)
								<option value="{{$status}}">{{$status}}</option>
							@endforeach
						</select>
					</td>
					<td>
						<textarea required="" class="form-control remarks" name="rows[{{$student->id}}][remarks]"></textarea>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	<button type="submit" class="btn btn-primary save-attendence">Save Attendence</button>
	
</form>
