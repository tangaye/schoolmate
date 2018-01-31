<h4 class="text-center print-title"><b>{{$academic}}</b> {{$grade}} <u>{{$subject}}</u> score(s) for {{$term}}</h4> <br>
<table class="table table-bordered table-condensed table-responsive" id="scores-table">
	
	<thead>
		<th>Code</th>
		<th>Name</th>
		<th>Score</th>
	</thead>
	<tbody>
		@foreach($students as $student)
			<tr>
				<td><a href="javascript:void(0)">{{$student->code}}</a></td>
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