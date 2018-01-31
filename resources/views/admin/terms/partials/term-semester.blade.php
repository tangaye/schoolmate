
<div id="semester-select">
	<select class="form-control" id="semester_id" name="semester_id">
		 @foreach($semesters as $semester)
		 	<option  value="{{$semester->id}}" {{in_array($semester->id, $term_semester) ? 'selected=""' :  ''}}>{{$semester->name}}</option>

	    @endforeach
	</select>
</div>
