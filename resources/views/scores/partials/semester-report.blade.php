
<table class="table table-bordered table-condensed table-responsive">
	<thead>
		<tr>
			<th scope="row">Name</th>
			<td colspan="2">{{$student->first_name." ".$student->middle_name." ".$student->surname}}</td>

			<th scope="row">Grade</th>
			<td>{{$student->grade->name}}</td>
		</tr>
		<tr>
			<th scope="row">Semester</th>
			<td colspan="2">{{$semester}}</td>

			<th scope="row">Date</th>
			<td>{{$date->toFormattedDateString()}}</td>
		</tr>
		<tr>
			<th class="text-center">Subject</th>
			@foreach($terms as $term)
	            <th>{{$term}}</th>
	        @endforeach
		</tr>
	</thead>
	<tbody>
		@foreach($scoreTable as $subject => $scores)
	        <tr>
	            <td>{{$subject}}</td>
	            @foreach($terms as $term)
	            	@if($scores[$term] <= 69)
						<td style="color: red;">{{$scores[$term]}}</td>
					@else 
						<td>{{$scores[$term]}}</td>
					@endif
	            @endforeach
	        </tr>
	    @endforeach
	</tbody>
</table>