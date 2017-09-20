<table class="table table-bordered table-condensed table-responsive" id="term-table">
	<thead>
		<th>Name</th>
		<th>Class</th>
		<th>Subject</th>
		<th>Term</th>
		<th>Score</th>
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
			</tr>
		@endforeach
	</tbody>
</table>