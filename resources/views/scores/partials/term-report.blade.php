<div id="period-report">
	<div class="row">
		<div class="col-md-12 text-center">
			<h3 style="margin-bottom: 0px">{{$institution->name}}</h2>
			<h4 style="margin-bottom: 0px; margin-top: 0px">{{$institution->address}}</h4>
			<h4 style="margin-bottom: 0px; margin-top: 0px">Email: {{$institution->email}}</h4>
		</div>
		<div class="col-md-12" style="margin-top: 10px;">
			<span class="pull-left"><b>{{$term->name}}</b> STUDENT REPORT</span>
			<span class="pull-right">Courtesy of School<b>MATE &copy;</b></span>
			<hr style="width: 100%;">
		</div>
	</div> 
	<table class="table table-bordered table-condensed table-responsive">
		<thead>
			<tr>
				<th scope="row">Name</th>
				<td colspan="2">{{$student->full_name}}</td>

				<th scope="row">Acad. Yr</th>
				<td colspan="2">{{$academic->full_year}}</td>

			</tr>
			<tr>
				<th scope="row">Grade/Class</th>
				<td>
					@foreach($student->enrollments->where('academic_id', $academic->id) as $enrollment)
						{{$enrollment->present_grade->name}}
                    @endforeach
				</td>

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
					@if($average > 0 && $average <= 69)
						<strong class="failure" style="color: red;">{{$average}}</strong>
					@elseif($average == 0)
						<span></span>
					@else 
						<strong>{{$average}}</strong>
					@endif
					
				</td>
			</tr>
		</tbody>
	</table>
	
</div>
<p  class="no-print">
	<b>Printing Title</b>: 
	<input type="text" readonly="" disabled="" class="title" value="{{$student->first_name}}-{{$student->surname}}-{{$academic->year_start}}-{{$academic->year_end}}-{{$term->name}}-report">
</p>