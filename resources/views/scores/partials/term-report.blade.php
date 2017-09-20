
<table class="table table-bordered table-condensed table-responsive">
	<thead>
		<tr>
			<th scope="row" colspan="1">Name</th>
			<td colspan="5">{{$student->first_name." ".$student->middle_name." ".$student->surname}}</td>
		</tr>
		<tr>
			<th scope="row">Grade/Class</th>
			<td>{{$student->grade->name}}</td>

			<th scope="row">Term</th>
			<td>{{$term->name}}</td>

			<th scope="row">Date</th>
			<td>{{$date->toFormattedDateString()}}</td>
		</tr>
		<tr>
			<th class="text-center" colspan="2">Subject</th>
			<th class="text-center" colspan="4">Score</th>
		</tr>
	</thead>
	<tbody>
		@foreach($scores as $score)
			<tr>
				<td scope="row" colspan="2">{{$score->subject}}</td>
				@if($score->score <= 69)
					<td style="color: red;" colspan="4">{{$score->score}}</td>
				@else 
					<td colspan="4">{{$score->score}}</td>
				@endif
			</tr>
		@endforeach
	</tbody>
</table>