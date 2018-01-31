<div class="form-group" id="status-check">
	@foreach($statuses as $name => $value)
		<label class="radio-inline">
  			<input type="radio" name="status" required="" {{$value == $academic->status ? 'checked' : ''}} value="{{$value}}">{{$name}}
		</label>
	@endforeach
</div>