<table class="table table-bordered table-responsive table-condensed">
	<thead>
		@if($academic->status)
			<tr>
				<th colspan="5" class="text-right">
					<button class="btn btn-primary pull-right btn-sm new_sponsor">
						<i class="glyphicon glyphicon-plus"></i> New Sponsor
					</button>
				</th>
			</tr>
		@endif
		<tr>
			<th>Teacher</th>
			<th>Sponsor Grade</th>
			<th>Academic Year</th>
			@if($academic->status)
				<th colspan="2" class="text-center">Actions</th>
			@endif
		</tr>
	</thead>
	<tbody>
		@foreach($sponsors as $sponsor)
			<tr>
				<td>{{$sponsor->first_name}} {{$sponsor->surname}}</td>
				<td>{{$sponsor->grade_name}}</td>
				<td>{{$sponsor->year_start}}/{{$sponsor->year_end}}</td>
				@if($academic->status)
					<td class="text-center">
						<a href="/admin/sponsor/edit/{{$sponsor->id}}" class="btn btn-info btn-sm edit_sponsor" title="Edit">
							<i class="glyphicon glyphicon-edit"></i>
						</a>
					</td>
					<td class="text-center">
						<button title="Delete" data-id="{{$sponsor->id}}" class="btn btn-danger btn-sm delete_sponsor">
							<i class="glyphicon glyphicon-remove"></i>
						</button>
					</td>
				@endif
			</tr>
		@endforeach
	</tbody>
</table>