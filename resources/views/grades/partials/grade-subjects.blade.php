<div class="subjects-control">
	@foreach($subjects as $subject)
		<option value="{{$subject->id}}">{{$subject->name}}</option>
	@endforeach
</div>