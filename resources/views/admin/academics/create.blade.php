<form class="form-horizontal" role="form" method="POST" action="/academics">

  <!-- div to display errors returned by ajax request-->
  <div class="errors alert alert-danger hidden">
  </div>
  <!-- end of errors div -->
  
	{{ csrf_field() }}
	<div class="form-group{{$errors->has('year_start') ? ' has-error' : '' }}">
  	<label class="col-sm-2 control-label">School Year Start</label>

  	<div class="col-sm-8">
      <div class="input-group date">
    		<input type="text" class="form-control date-start" name="year_start" value="{{ old('year_start') }}" required readonly="">
        <span class="input-group-addon">
            <i class="glyphicon glyphicon-calendar"></i>
        </span>
      </div>

      {{--javascript error block--}}
      <span class="date-start-error text-danger hidden"></span> <br>

      {{--ajax error block--}}
      <span class="date-start-duplicate text-danger hidden"></span>

      @if ($errors->has('year_start'))
          <span class="help-block">
              <strong>{{ $errors->first('year_start') }}</strong>
          </span>
      @endif
  	</div>
	</div>
  {{-- close of date start--}}

	<div class="form-group{{$errors->has('year_end') ? ' has-error' : '' }}">
  	<label class="col-sm-2 control-label">School Year End</label>

  	<div class="col-sm-8">
      <div class="input-group date">
    		<input type="text" class="form-control date-end" name="year_end" value="{{ old('year_end') }}" required required="" readonly="" disabled="">

        <span class="input-group-addon">
            <i class="glyphicon glyphicon-calendar"></i>
        </span>
      </div>

      {{--javascript error block--}}
      <span class="date-end-error text-danger hidden"></span> <br>

      {{--ajax error block--}}
      <span class="date-end-duplicate text-danger hidden"></span>

      @if ($errors->has('year_end'))
        <span class="help-block">
            <strong>{{ $errors->first('year_end') }}</strong>
        </span>
      @endif
 		</div>
	</div>
  {{-- close of date end--}}

	<div class="form-group">
		<label class="control-label col-sm-2">Academic Status</label>

    <div class="col-sm-8">
      <label class="radio-inline">
          <input type="radio" name="status" id="statusActive" class="status" required="" value="1" disabled=""> Active
        </label>

        <label class="radio-inline">
          <input type="radio" name="status" required="" class="status" id="statusInactive" value="0" disabled=""> Inactive
        </label>
    </div>
	</div>
  {{-- close of academic status --}}

  <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary btn-submit" disabled="">Save</button>
      </div>
  </div>
</form>