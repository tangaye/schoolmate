<div id="semester-report">
	<div class="text-center">
		<h2 style="margin-bottom: 1px">{{$institution->name}}</h2>
		<h3 style="margin-bottom: 1px; margin-top: 1px">{{$institution->address}}</h3>
		<p><strong>Motto:</strong> {{$institution->motto}}</p>
	</div>

	<div class="text-center">
		<h3><u>{{$semester->name}} Student Report</u></h3>
	</div> <br>
	<table class="table table-bordered table-condensed table-responsive">
		<thead>
			<tr>
				<th scope="row" colspan="2" class="text-center">Student Name</th>
				<td colspan="4">{{$student->first_name." ".$student->middle_name." ".$student->surname}}</td>
			</tr>
			<tr>
				<th scope="row">Grade</th>
				<td>{{$student->grade->name}}</td>

				<th scope="row">Semester</th>
				<td colspan="">{{$semester->name}}</td>

				<th scope="row" class="text-right">Date</th>
				<td>{{$date->toFormattedDateString()}}</td>
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
		            	@if((App\Score::subjectAvg($subject, $student->id, $semester->id)) > 0 && (App\Score::subjectAvg($subject, $student->id, $semester->id)) <= 69)
		            		<span class="failure" style="color: red;">
		            			{{round( App\Score::subjectAvg($subject, $student->id, $semester->id), 1)}}
		            		</span>
		            	@elseif((App\Score::subjectAvg($subject, $student->id, $semester->id)) == 0)
		            		<span></span>
		            	@else 
		            		<strong>
			            		{{round( App\Score::subjectAvg($subject, $student->id, $semester->id), 1)}}
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
		            		<span class="failure" style="color: red;">
		            			{{round( App\Score::periodicAvg($id, $student->id), 1)}}
		            		</span>
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
	        	<!-- semester avg -->
	        	<th class="text-right">Semester Avg.</th>
	        	<td colspan="5" class="text-right">
	        		@if((App\Score::semesterAvg($student->id, $semester->id)) > 0 && (App\Score::semesterAvg($student->id, $semester->id)) <= 69)
	        			<span class="failure" style="color: red;">
	        				{{round(App\Score::semesterAvg($student->id, $semester->id), 1)}}
	        			</span>
	        		@elseif((App\Score::semesterAvg($student->id, $semester->id)) == 0)
	        			<span></span>
	        		@else
	        			<strong>{{round(App\Score::semesterAvg($student->id, $semester->id), 1)}}</strong>
	        		@endif
	        		
	        	</td>
	        </tr>
		</tbody>
	</table>
</div>
