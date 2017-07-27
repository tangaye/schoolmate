<table class="table table-bordered table-condensed table-responsive" id="term-table">
	<thead>
		<th>Name</th>
		<th>Class</th>
		<th>Subject</th>
		<th>Term</th>
		<th>Score</th>
		<th>Actions</th>
	</thead>
	<tbody>
		@foreach($students as $student)
			<tr class="score{{$student->score_id}}">
				<td>{{$student->first_name." ".$student->surname}}</td>
				<td>{{$student->grade}}</td>
				<td>{{$student->subject}}</td>
				<td>{{$student->term}}</td>
				@if($student->score <= 69)
					<td style="color: red;">{{$student->score}}</td>
				@else 
					<td>{{$student->score}}</td>
				@endif
				<td>
					<a class="edit-score" data-name="{{$student->first_name." ".$student->surname}}" data-grade="{{$student->grade}}" data-subject="{{$student->subject}}" data-score="{{$student->score}}" data-id="{{$student->score_id}}" data-studentid="{{$student->student_id}}" data-gradeid={{$student->grade_id}} data-subjectid="{{$student->subject_id}}" data-termid="{{$student->term_id}}" data-toggle="tooltip" title="Edit" href="#" role="button">
						<i class="glyphicon glyphicon-edit text-info"></i>
					</a> &nbsp;

					<a class="delete-score" data-id="{{$student->score_id}}" data-toggle="tooltip" title="Delete" href="#" role="button">
						<i class="glyphicon glyphicon-trash text-danger"></i>
					</a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>