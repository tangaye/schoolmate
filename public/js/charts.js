$(document).ready(function() {
	$.ajaxSetup({
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
	});

	// student gender chart
	$.get('/charts/gender') 
	.done(function(data) {
		/*optional stuff to do after success */
		var gender = [];
		var sum = [];

		for(var index in data){
		  gender.push(data[index].gender);
		  sum.push(data[index].total);
		}

		var ctx = document.getElementById('genderPieChart').getContext('2d');
		var chart = new Chart(ctx, {
		  	// The type of chart we want to create
			type: 'pie',

			  	// The data for our dataset
			  	data: {
			      	labels: gender,
			      	datasets: [{
			          	label: "Student Gender Chart",
			          	backgroundColor: ["#2ecc71","#3498db"],
			          	data: sum,
			      	}]
			  	},
			  	// Configuration options go here
			  	options: {
			    	title: {
			        display: true,
			        text: 'Student Gender Chart'
			    }
			}
		}); 
	})
	.fail(function(){
		console.log('Error loading gender chart');
	});


  	// grades population chart
	$.get('/charts/grades') 
	.done(function(data) {
		/*optional stuff to do after success */
		var name = [];
		var students = [];

		for(var index in data){
			name.push(data[index].name);
			students.push(data[index].students);
		}

		var ctx = document.getElementById('gradesBarChart').getContext('2d');

		var chart = new Chart(ctx, {
			// The type of chart we want to create
			type: 'bar',

			// The data for our dataset
			data: {
			  labels: name,
			  datasets: [{
			     backgroundColor: [
			      'rgba(255, 99, 132, 0.2)',
			      'rgba(54, 162, 235, 0.2)',
			      'rgba(255, 206, 86, 0.2)',
			      'rgba(153, 102, 255, 0.2)',
			      'rgba(75, 192, 192, 0.2)',
			      'rgba(255, 159, 64, 0.2)'
			    ],
			      data: students,
			  }]
			},
			// Configuration options go here
			options: {
				scales: {
				    yAxes: [{
				      ticks: {
				          beginAtZero:true
				      }
				    }],
				    xAxes: [{
				      categoryPercentage: 0.9,
				      barPercentage: 1.0
				    }]
				},
				legend: {display: false }
			}
		}); 
	})
	.fail(function(){
		console.log('Error loading grades bar chart');
	});

});