
<table class="table table-responsive table-condensed table-striped table-bordered">
	<thead>
		<tr>
			<th>Student</th>
			<th>Score</th>
			<th>Operations</th>
		</tr>
	</thead>
	<tbody>
		@foreach($students as $student)
			<form class="score-form" method="post">
				<tr>
					{{-- student id, subject id, grade id, term id to be sent but are hidden --}}
					<td class="hidden"><input class="student" type="number" disabled="" name="student_id" value="{{$student->id}}"></td>

					<td class="hidden"><input class="grade" type="number" disabled="" name="grade_id" value="{{$student->grade}}"></td>

					<td class="hidden"><input class="subject" type="number" disabled="" name="subject_id" value="{{$subject->id}}"></td>

					<td class="hidden"><input class="term" type="number" disabled="" name="term_id" value="{{$term->id}}"></td>

					{{-- end of hidden values to be sent--}}

					<td>{{$student->first_name." ".substr($student->middle_name, 0, 1)." ".$student->surname}}</td>
					<td><input class="score form-control" max="100" min="59" type="number" name="score"></td>

					<td><input class="btn btn-info btn-flat save-score" type="submit" value="Save" name="save"></td>
				</tr>
			</form>
		@endforeach
	</tbody>
	<tfoot>
		<td colspan="3" class="text-center">Enter <strong>{{$grade}} <u>{{$subject->name}}</u></strong> scores for <strong>{{$term->name}}</strong></td>
	</tfoot>
</table>