<table class="table table-bordered table-responsive table-condensed table-striped">
<thead>
	<tr>
		<th>Grade/Class</th>
		<th>Subject</th>
		<th>Action</th>
	</tr>
</thead>
<tbody>
	@foreach($grade_teacher as $teacher)
		<tr>
			<td>{{$teacher->grade}}</td>
			<td>{{$teacher->subject}}</td>
			<td>
				<button class="delete-grade-teacher btn btn-danger btn-sm" data-id="{{$teacher->id}}">
					<i class="glyphicon glyphicon-remove-sign"></i>
					Unassigned
				</button>
			</td>
		</tr>
	@endforeach
</tbody>
<tfoot>
	<tr>
		<td colspan="3" class="text-center">Showing grades and subjects assigned to <b>{{$instructor->full_name}}</b> for the academic year <b>{{$academic->full_year}}</b></td>
	</tr>
</tfoot>
</table>