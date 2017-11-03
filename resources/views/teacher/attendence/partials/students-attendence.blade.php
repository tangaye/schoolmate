<table class="table table-condensed table-responsive table-striped table-bordered">
	<thead>
		<tr>
			<th>Student Code</th>
			<th>Name</th>
			<th>Status</th>
			<th>Remarks</th>
		</tr>
	</thead>
	<tbody>
		@foreach($attendences as $attendence)
			<tr class="attendence{{$attendence->id}}">
				<td class="text-right"><a href="/students/edit/{{$attendence->student_id}}" title="View student" data-toggle="tooltip">{{$attendence->student_code}}</a></td>

				<td>{{$attendence->first_name." ".$attendence->middle_name." ".$attendence->surname}}</td>

				@if($attendence->status === "Present")
					<td><span class="badge label-success">{{$attendence->status}}</span></td>
				@else
					<td><span class="badge label-danger">{{$attendence->status}}</span></td>
				@endif

				<td>{{$attendence->remarks}}</td>
			</tr>
		@endforeach
	</tbody>
</table>