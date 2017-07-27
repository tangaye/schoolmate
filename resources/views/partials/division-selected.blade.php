
<div id="grade-select">
	<select class="form-control" id="division_id" name="division_id">
		 @foreach($divisions as $division)
		 	<option  value="{{$division->id}}" {{in_array($division->id, $grade_divisions) ? 'selected=""' :  ''}}>{{$division->name}}</option>

	    @endforeach
	</select>
</div>