<div id="annual-report">
	<div class="text-center">
		<h1 style="margin-bottom: 1px">{{$institution->name}}</h1>
		<h2 style="margin-bottom: 1px; margin-top: 1px">{{$institution->address}}</h2>
		<p><strong>Motto:</strong> {{$institution->motto}}</p>
	</div>

	<div class="text-center" style="margin-bottom: 4px;">
		<h2><u>Annual Student Report</u></h2>
	</div>
	<table class="table table-bordered table-condensed table-responsive">
		<thead>
			<tr>
				<th scope="row" colspan="2" class="text-center">Student Name</th>
				<td colspan="9">{{$student->first_name." ".$student->middle_name." ".$student->surname}}</td>
			</tr>
			<tr>
				<th scope="row" colspan="2" class="text-center">Grade</th>
				<td colspan="4">{{$student->grade->name}}</td>

				<th scope="row" class="text-right" colspan="2">Date</th>
				<td colspan="3">{{$date->toFormattedDateString()}}</td>
			</tr>
			<tr>
				<th colspan="5" class="text-center">First Semester</th>
				<th colspan="6" class="text-center">Second Semester</th>
			</tr>
			<tr>
				<th class="text-center">Subject</th>
				@foreach($terms as $term)
		            <th>{{$term}}</th>
		        @endforeach
		        <th class="text-center">Average</th>
			</tr>
		</thead>
		<tbody>
			@foreach($scoreTable as $subject => $scores)
		        <tr>
		            <td>{{$subject}}</td>
		            @foreach($terms as $term)
		            	@if($scores[$term] <= 69)
							<td style="color: red;">{{$scores[$term]}}</td>
						@else 
							<td>{{$scores[$term]}}</td>
						@endif
		            @endforeach
		            <!-- subjects averages -->
		            <td class="text-center">
		            	@if((App\Score::subjectAnnualAvg($subject, $student->id)) > 0 && (App\Score::subjectAnnualAvg($subject, $student->id )) <= 69)
		            		<strong class="failure" style="color: red;">
		            			{{round( App\Score::subjectAnnualAvg($subject, $student->id), 1)}}
		            		</strong>
		            	@elseif((App\Score::subjectAnnualAvg($subject, $student->id)) == 0)
		            		<span></span>
		            	@else 
		            		<strong>
			            		{{round( App\Score::subjectAnnualAvg($subject, $student->id), 1)}}
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
	            		@if((App\Score::periodicAvg($id, $student->id)) > 0 && (App\Score::periodicAvg($id, $student->id)) <= 69)
		            		<strong class="failure" style="color: red;">
		            			{{round( App\Score::periodicAvg($id, $student->id), 1)}}
		            		</strong>
		            	@elseif((App\Score::periodicAvg($id, $student->id)) == 0)
		            		<span></span>
		            	@else 
		            		<strong>{{round( App\Score::periodicAvg($id, $student->id), 1)}}</strong>
		            	@endif
	            	</td>
	            @endforeach
	            <td></td>
	        </tr>

	        <tr>
	        	<!-- annual avg -->
	        	<th class="text-right">Annual Avg.</th>
	        	<td colspan="9" class="text-right">
	        		@if((App\Score::annualAvg($student->id)) > 0 && (App\Score::annualAvg($student->id)) <= 69)
	        			<span class="failure" style="color: red;">
	        				{{round(App\Score::annualAvg($student->id), 1)}}
	        			</span>
	        		@elseif((App\Score::annualAvg($student->id)) == 0)
	        			<span></span>
	        		@else
	        			<strong>{{round(App\Score::annualAvg($student->id), 1)}}</strong>
	        		@endif
	        		
	        	</td>
	        	<td></td>
	        </tr>
		</tbody>
	</table>
</div>
