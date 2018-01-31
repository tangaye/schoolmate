<div class="col-md-12">
	<div class="panel">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-12 text-center">
					<h3 style="margin-bottom: 0px">{{$institution->name}}</h2>
					<h4 style="margin-bottom: 0px; margin-top: 0px">{{$institution->address}}</h4>
					<h4 style="margin-bottom: 0px; margin-top: 0px">Email: {{$institution->email}}</h4>
				</div>
				<div class="col-md-12" style="margin-top: 10px;">
					<span class="pull-left">STUDENT TRANSCRIPT</span>
					<span class="pull-right">Courtesy of School<b>MATE &copy;</b></span>
					<hr style="width: 100%;">
				</div>
			</div> 
			<div class="row">
				<table class="table table-responsive table-condensed table-bordered">
					<thead>
						<tr>
							<th>Name:</th>
							<td>{{$student->full_name}} ({{$student->student_code}})</td>

							<th>Period Attended:</th>
							<td>{{$student->attendence_period->min('year_start')}} - {{$student->attendence_period->max('year_end')}}</td>

							<th>Conduct:</th>
							<td>{{$conduct}}</td>
						</tr>
						<tr>
							<th>Promotted To:</th>
							<td></td>

							<th>Retained In:</th>
							<td></td>

							<th>Reason for leaving:</th>
							<td>{{$leaving_reason}}</td>
						</tr>
					</thead>
				</table>

				<table class="table table-bordered table-condensed table-responsive">
					<thead>

						<tr>
							<th class="text-center">Academic Years</th>
							@foreach($academics as $academic)
								<th class="text-center">{{$academic->full_year}}</th>
							@endforeach
						</tr>
						<tr>
							<th>Subjects</th>
							@foreach($grades as $grade)
					            <th>{{$grade}}</th>
					        @endforeach
						</tr>
					</thead>
					<tbody>
						@foreach($transcriptTable as $subject => $averages)
							<tr>
								<td>{{$subject}}</td>

					            @foreach($grades as $grade)

					            	@if($averages[$grade] <= 69)
										<td class="failure" style="color: red;">{{$averages[$grade]}}</td>
									@else 
										<td>{{$averages[$grade]}}</td>
									@endif

					            @endforeach
							</tr>
				        @endforeach
				        <tr>
				        	<!-- annual avg -->
				        	<th class="text-right">Average</th>
				        	@foreach($academics as $academic)
				        		<td class="text-right">
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
				        	@endforeach
				        </tr>
					</tbody>
				</table>
				<strong>RECOMMENDATION:</strong> 
				<span>
					@if($student->gender == "Male")
						We are please to introduce and recommend <b>{{$student->full_name}}</b> to you. {{$student->first_name}} attended <u>{{$institution->name}}</u> during the period specified above. While at <u>{{$institution->name}}</u>, he has observed to be respectful and determined to learn. We wholeheartedly recommend him and would appreciate any assistance you may render him to continue his education.
					@else
						We are please to introduce and recommend <b>{{$student->full_name}}</b> to you. {{$student->first_name}} attended <u>{{$institution->name}}</u> during the period specified above. While at <u>{{$institution->name}}</u>, she has observed to be respectful and determined to learn. We wholeheartedly recommend her and would appreciate any assistance you may render her to continue her education.
					@endif 
				</span><br>

				<strong>PLEASE NOTE:</strong> <span>This Official Transcript is only valid if properly signed by the Registrar and approved by the Director/Principal and stamped with the seal of the school. Any erasure or change of any part of this transcript makes to void.</span>
			</div>
			<div class="row">
				<div class="pull-left">
					<span>Appproved:___________________________<br>
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
						DIRECTOR/PRINCIPAL
					</span>
				</div>
				<div class="pull-right">
					<span>SIGNED:___________________________<br>
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
					    REGISTRAR
					</span>
				</div>
			</div>
		</div>
		<p  class="no-print">
			<b>Printing Title</b>: 
			<input type="text" readonly="" disabled="" class="title" value="{{$student->first_name}}-{{$student->surname}}-transcript">
		</p>
	</div>
</div>
