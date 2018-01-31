
<div id="grade-check" class="form-group">
	<select class="form-control select2" multiple="multiple" data-placeholder="Select grade(s)" style="width: 100%;" id="grade_id" name="grade_id[]" >
        @foreach($grades as $grade)
            <option {{in_array($grade->id, $subject_grades) ? 'selected=""' :  ''}} value="{{$grade->id}}">{{$grade->name}}</option>
        @endforeach 
    </select>
</div>