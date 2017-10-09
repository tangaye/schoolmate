<div id="period-report">
	<div class="text-center">
		<h1 style="margin-bottom: 1px">{{$institution->name}}</h1>
		<h2 style="margin-bottom: 1px; margin-top: 1px">{{$institution->address}}</h2>
		<p><strong>Motto:</strong> {{$institution->motto}}</p>
	</div>

	<div class="text-center">
		<h2><u>{{$term->name}} Student Report</u></h2>
	</div> <br>
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
						<td class="failure" style="color: red;" colspan="4">{{$score->score}}</td>
					@else 
						<td colspan="4">{{$score->score}}</td>
					@endif
				</tr>
			@endforeach
			<tr>
				<th scope="row" colspan="2" class="text-right">Average</th>
				<td colspan="4" class="text-right">
					@if($average <= 69)
						<strong class="failure" style="color: red;">{{round($average, 1)}}</strong>
					@else 
						<strong>{{round($average, 1) }}</strong>
					@endif
					
				</td>
			</tr>
		</tbody>
	</table>
	
</div>
