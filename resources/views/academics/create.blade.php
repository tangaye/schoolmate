<form class="form-horizontal" role="form" method="POST" action="/academics">
	{{ csrf_field() }}
	<div class="form-group{{$errors->has('date_start') ? ' has-error' : '' }}">
  	<label class="col-sm-2 control-label">School Date Start</label>

  	<div class="col-sm-8">
      <div class="input-group date" data-provide="datepicker" data-date-format="yyyy/mm/dd">
    		<input type="text" class="form-control date-start" name="date_start" value="{{ old('date_start') }}" required readonly="">
        <span class="input-group-addon">
            <i class="glyphicon glyphicon-calendar"></i>
        </span>
      </div>

      {{--javascript error block--}}
      <span class="date-start-error text-danger hidden"></span> <br>

      {{--ajax error block--}}
      <span class="date-start-duplicate text-danger hidden"></span>

      @if ($errors->has('date_start'))
          <span class="help-block">
              <strong>{{ $errors->first('date_start') }}</strong>
          </span>
      @endif
  	</div>
	</div>
  {{-- close of date start--}}

	<div class="form-group{{$errors->has('date_end') ? ' has-error' : '' }}">
  	<label class="col-sm-2 control-label">School Date End</label>

  	<div class="col-sm-8">
      <div class="input-group date" data-date-format="yyyy/mm/dd">
    		<input type="text" class="form-control date-end" name="date_end" value="{{ old('date_end') }}" required required="" readonly="" disabled="">

        <span class="input-group-addon">
            <i class="glyphicon glyphicon-calendar"></i>
        </span>
      </div>

      {{--javascript error block--}}
      <span class="date-end-error text-danger hidden"></span> <br>

      {{--ajax error block--}}
      <span class="date-end-duplicate text-danger hidden"></span>

      @if ($errors->has('date_end'))
        <span class="help-block">
            <strong>{{ $errors->first('date_end') }}</strong>
        </span>
      @endif
 		</div>
	</div>
  {{-- close of date end--}}

	<div class="form-group">
		<label class="control-label col-sm-2">Academic Status</label>

    <div class="col-sm-8">
      {{-- 
      * If an academic year is set to active
      * this avoid the user from making the another academic year active
      --}}
      @if(count($academics) > 0)
        @foreach($academics as $academic)
          @if($academic->status)
            <label class="radio-inline">
              <input type="radio" name="status" required="" readonly="" checked="" class="status" id="statusInactive" value="0" disabled=""> Inactive
            </label>
            <p class="text-warning text-muted">There is already a current academic year that is <b>Active</b>. So, this is set to Inactive by default</p>
            @break
          @else
            <label class="radio-inline">
              <input type="radio" name="status" id="statusActive" class="status" required="" value="1" disabled=""> Active
            </label>

            <label class="radio-inline">
              <input type="radio" name="status" required="" class="status" id="statusInactive" value="0" disabled=""> Inactive
            </label>
            @break
          @endif
        @endforeach
      @else
        <label class="radio-inline">
          <input type="radio" name="status" id="statusActive" class="status" required="" value="1" disabled=""> Active
        </label>

        <label class="radio-inline">
          <input type="radio" name="status" required="" class="status" id="statusInactive" value="0" disabled=""> Inactive
        </label>
      @endif
      
    </div>
	</div>
  {{-- close of academic status --}}

  <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-info btn-flat btn-submit" disabled="">Save</button>
      </div>
  </div>
</form>