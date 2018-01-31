<div class="row">
	@foreach($students as $student)
	    <div class="col-md-4">
	        <!-- Widget: user widget style 1 -->
	        <div class="box box-widget widget-user-2">
	          	<!-- Add the bg color to the header using any of the bg-* classes -->
	          	<div class="widget-user-header bg-aqua-active">
		            <div class="widget-user-image">
		              @if($student->photo)
		                  <img src="{{ asset("images/".$student->photo) }}" class="img-circle" alt="Student photo"/>
		              @else
		                  <img src="{{ asset("images/default.png") }}" class="img-circle" alt="Student photo"/>
		              @endif
		            </div>
		            <!-- /.widget-user-image -->
		            <h3 class="widget-user-username">{{$student->full_name}}</h3>
		            <h5 class="widget-user-desc">
		              @if($student->enrollments->where('academic_id', $academic->id)->count() > 0)
	                    @foreach($student->enrollments->where('academic_id', $academic->id) as $enrollment)

	                      	@if($enrollment->enrollment_status == "Enrolled")
	                          {{$enrollment->present_grade->name}} <span class="badge bg-green">{{$enrollment->enrollment_status}}</span>
	                        @elseif($enrollment->enrollment_status == "Pending")
	                          {{$enrollment->present_grade->name}} <span class="badge label-info">{{$enrollment->enrollment_status}}</span>
	                        @elseif($enrollment->enrollment_status == "Expelled")
	                          {{$enrollment->present_grade->name}} <span class="badge label-danger">{{$enrollment->enrollment_status}}</span>
	                        @elseif($enrollment->enrollment_status == "Suspended")
	                         {{$enrollment->present_grade->name}} <span class="badge label-warning">{{$enrollment->enrollment_status}}</span>
	                        @elseif($enrollment->enrollment_status == "Dropped")
	                          {{$enrollment->present_grade->name}} <span class="badge label-default">{{$enrollment->enrollment_status}}</span>
	                        @endif

	                    @endforeach
	                  @else
	                    <span class="badge bg-green">Not enrolled this year.</span>
	                  @endif
		            </h5>
		        </div>
		        <div class="box-footer no-padding">
		            <ul class="nav nav-stacked">
		              <li><a href="javascript:void(0)">Age<span class="pull-right badge bg-yellow">{{$student->age()}}</span></a></li>

		              <li><a href="javascript:void(0)">Birth Date <span class="pull-right badge bg-aqua">{{$student->date_of_birth->toFormattedDateString()}}</span></a></li>
		              <li><a href="javascript:void(0)">Code<span class="pull-right badge label-primary">{{$student->student_code}}</span></a></li>
		            </ul>
	          	</div>
	        </div>
	        <!-- /.widget-user -->
	    </div>
	    <!-- /.col -->
  	@endforeach
</div>