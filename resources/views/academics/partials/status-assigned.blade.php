<div class="form-group" id="status-check">

	{{-- 
      * The code here do its best to avoid the situation wherein a user 
      * tries to make an academic yeaer active when there is another
      * that is already set to active
    --}}
	@if ($status_active == true && $status == 1)
		@foreach($statuses as $name => $value)
			<label class="radio-inline">
	  			<input type="radio" name="status" required="" {{$status === $value ? 'checked' : ''}} value="{{$value}}">{{$name}}
			</label>
		@endforeach
	@elseif ($status_active == true && $status == 0)
		<label class="radio-inline">
  			<input type="radio" name="status" required="" readonly="" checked="" value="{{$status}}"> Inactive
		</label>
		<br>
		<span class="text-muted">There is an academic year that is already set to active. To make this active please change the status of the academic year that is set to <b>active</b></span>
	@else 
		@foreach($statuses as $name => $value)
			<label class="radio-inline">
	  			<input type="radio" name="status" required="" {{$status === $value ? 'checked' : ''}} value="{{$value}}">{{$name}}
			</label>
		@endforeach
	@endif
</div>