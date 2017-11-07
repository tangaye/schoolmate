<table class="table table-condensed table-responsive table-striped table-bordered">
	<thead>
		<tr>
			<th>Student Code</th>
			<th>Name</th>
			<th>Status</th>
			<th>Remarks</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		@foreach($attendences as $attendence)
			<tr class="attendence{{$attendence->id}}">
				<td><a href="/students/edit/{{$attendence->student_id}}" title="View student" data-toggle="tooltip">{{$attendence->student_code}}</a></td>

				<td>{{$attendence->first_name." ".$attendence->middle_name." ".$attendence->surname}}</td>

				@if($attendence->status === "Present")
					<td><span class="badge label-success">{{$attendence->status}}</span></td>
				@else
					<td><span class="badge label-danger">{{$attendence->status}}</span></td>
				@endif

				<td>{{$attendence->remarks}}</td>
				<td>
					<a class="edit-attendence" data-name="{{$attendence->first_name." ".$attendence->middle_name." ".$attendence->surname}}" data-subject="{{$attendence->subject}}" data-grade="{{$attendence->grade}}" data-remarks="{{$attendence->remarks}}" data-date="{{$date->toFormattedDateString()}}" data-id="{{$attendence->id}}" data-toggle="tooltip" title="Edit" href="#" role="button">
						<i class="glyphicon glyphicon-edit text-info"></i>
					</a> &nbsp;
					<a class="delete-attendence" data-id="{{$attendence->id}}" data-toggle="tooltip" title="Delete" href="#" role="button">
						<i class="glyphicon glyphicon-trash text-danger"></i>
					</a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>