
<table class="table table-bordered table-condensed table-responsive" id="scores-table">

	<div class="text-center">
		<h2 style="margin-bottom: 0px"><strong>{{$grade}}</strong></h2>
		<h3 style="margin-top: 0px"><strong> <u>{{$term}} <span class="text-primary">{{$subject}}</span> Scores</u> </strong></h3>
	</div>
	
	<thead>
		<th>Name</th>
		<th>Score</th>
	</thead>
	<tbody>
		@foreach($students as $student)
			<tr>
				<td>{{$student->first_name." ".$student->surname}}</td>
				@if($student->score <= 69)
					<td style="color: red;">{{$student->score}}</td>
				@else 
					<td>{{$student->score}}</td>
				@endif
			</tr>
		@endforeach
	</tbody>
</table>