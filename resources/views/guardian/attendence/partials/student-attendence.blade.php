<table class="table table-condensed table-responsive table-striped table-bordered">
	<thead>
		<tr>
			<th>Subject</th>
			<th>Status</th>
			<th>Remarks</th>
		</tr>
	</thead>
	<tbody>
		@foreach($attendences as $attendence)
			<tr>
				<td>{{$attendence->subject}}</td>

				@if($attendence->status === "Present")
					<td>
						<span class="badge label-success">{{$attendence->status}}</span>
					</td>
				@else
					<td>
						<span class="badge label-danger">{{$attendence->status}}</span>
					</td>
				@endif

				<td>{{$attendence->remarks}}</td>
			</tr>
		@endforeach
	</tbody>
	<tfoot>
		<td class="text-center" colspan="3">Showing attendence recorded for: <strong>{{$student}}</strong> on <strong>{{$date}}</strong> </td>
	</tfoot>
</table>