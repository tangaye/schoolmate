<div id="annual-report">
	<div class="row">
		<div class="col-md-12 text-center">
			<h3 style="margin-bottom: 0px">{{$institution->name}}</h2>
			<h4 style="margin-bottom: 0px; margin-top: 0px">{{$institution->address}}</h4>
			<h4 style="margin-bottom: 0px; margin-top: 0px">Email: {{$institution->email}}</h4>
		</div>
		<div class="col-md-12" style="margin-top: 10px;">
			<span class="pull-left"><b>ANNUAL</b> STUDENT REPORT</span>
			<span class="pull-right">Courtesy of School<b>MATE &copy;</b></span>
			<hr style="width: 100%;">
		</div>
	</div> 
	<table class="table table-bordered table-condensed table-responsive">
		<thead>
			<tr>
				<th scope="row" class="text-center">Name</th>
				<td colspan="5">{{$student->full_name}}</td>

				<th scope="row">Acad. Yr</th>
				<td colspan="4">{{$academic->full_year}}</td>
			</tr>
			<tr>
				<th scope="row" colspan="2" class="text-center">Grade</th>
				<td colspan="4">
					@foreach($student->enrollments->where('academic_id', $academic->id) as $enrollment)
						{{$enrollment->present_grade->name}}
                    @endforeach
				</td>

				<th scope="row" class="text-right" colspan="2">Date</th>
				<td colspan="3">{{$date->toFormattedDateString()}}</td>
			</tr>
			<tr>
				<th colspan="5" class="text-center">1<sup>st</sup> Semester</th>
				<th colspan="6" class="text-center">2<sup>nd</sup> Semester</th>
			</tr>
			<tr>
				<th class="text-center">Subject</th>
				@foreach($terms as $term)
		            <th>{{$term}}</th>
		        @endforeach
		        <th class="text-center">Avg.</th>
			</tr>
		</thead>
		<tbody>
			@foreach($scoreTable as $subject => $scores)
		        <tr>
		            <td>{{$subject}}</td>
		            @foreach($terms as $term)
		            	@if($scores[$term] <= 69)
							<td class="failure" style="color: red;">{{$scores[$term]}}</td>
						@else 
							<td>{{$scores[$term]}}</td>
						@endif
		            @endforeach
		            <!-- subjects averages -->
		            <td class="text-center">
		            	@if((App\Repositories\ScoresRepository::subject_annual_avg($subject, $student->id, $academic->id)) > 0 && (App\Repositories\ScoresRepository::subject_annual_avg($subject, $student->id, $academic->id)) <= 69)
		            		<strong class="failure" style="color: red;">
		            			{{App\Repositories\ScoresRepository::subject_annual_avg($subject, $student->id, $academic->id)}}
		            		</strong>
		            	@elseif((App\Repositories\ScoresRepository::subject_annual_avg($subject, $student->id, $academic->id)) == 0)
		            		<span></span>
		            	@else 
		            		<strong>
			            		{{App\Repositories\ScoresRepository::subject_annual_avg($subject, $student->id, $academic->id)}}
			            	</strong>
		            	@endif
		            	
		            </td>
		            
		        </tr>
		    @endforeach

		    <!-- periodic averages -->
		    <tr>
	        	<th scope="row" class="text-right">Periodic Avg.</th>
	        	@foreach($terms as $id => $name)
	            	<td class="text-right">
	            		@if((App\Repositories\ScoresRepository::periodic_avg($id, $student->id, $academic->id)) > 0 && (App\Repositories\ScoresRepository::periodic_avg($id, $student->id, $academic->id)) <= 69)
		            		<strong class="failure" style="color: red;">
		            			{{App\Repositories\ScoresRepository::periodic_avg($id, $student->id, $academic->id)}}
		            		</strong>
		            	@elseif((App\Repositories\ScoresRepository::periodic_avg($id, $student->id, $academic->id)) == 0)
		            		<span></span>
		            	@else 
		            		<strong>{{App\Repositories\ScoresRepository::periodic_avg($id, $student->id, $academic->id)}}</strong>
		            	@endif
	            	</td>
	            @endforeach
	            <td></td>
	        </tr>

	        <tr>
	        	<!-- annual avg -->
	        	<th class="text-right">Annual Avg.</th>
	        	<td colspan="9" class="text-right">
	        		@if((App\Repositories\ScoresRepository::annual_avg($student->id, $academic->id)) > 0 && (App\Repositories\ScoresRepository::annual_avg($student->id, $academic->id)) <= 69)
	        			<span class="failure" style="color: red;">
	        				{{App\Repositories\ScoresRepository::annual_avg($student->id, $academic->id)}}
	        			</span>
	        		@elseif((App\Repositories\ScoresRepository::annual_avg($student->id, $academic->id)) == 0)
	        			<span></span>
	        		@else
	        			<strong>{{App\Repositories\ScoresRepository::annual_avg($student->id, $academic->id)}}</strong>
	        		@endif
	        		
	        	</td>
	        	<td></td>
	        </tr>
		</tbody>
	</table>
</div>

<p  class="no-print">
	<b>Printing Title</b>: 
	<input type="text" readonly="" disabled="" class="title" value="{{$student->first_name}}-{{$student->surname}}-{{$academic->year_start}}-{{$academic->year_end}}-annual-report">
</p>

