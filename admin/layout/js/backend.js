$(function () {

	'use strict';

	$(".cat h3").click(function () {
		$(this).next(".full-view").fadeToggle();
	});
	function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
}
	
	//selectBoxIt

	$("select").selectBoxIt({
		autoWidth:false
	});


	//hide placeholder on form focus

	$('[placeholder]').focus(function () {
		$(this).attr('data-text',$(this).attr('placeholder'));
		$(this).attr('placeholder','');
	}).blur(function () {
		$(this).attr("placeholder",$(this).attr('data-text'));
	});

	//add astrisk in requird field
	$('input').each(function () {
		if ($(this).attr('required')==='required') {
			$(this).after('<span class="astrisk">*</span>')
		}
	}); 
	//convert password field to text

	$(".show").hover(function () {
		$(".password").attr("type","text");
	},function () {
		$(".password").attr("type","password");
	
	});

	//confirmation message on delete button

	$(".confirm").click(function () {
		return confirm("Are You Sure?");
	});

	//category-view-option
	
	// chart.js
	var ctx = document.getElementById("myChart").getContext('2d');
	var myChart = new Chart(ctx, {
	    type: 'bar',
	    data: {
	        labels: ["Sat", "Sun", "Mon", "Tus", "Thur", "Wed", "Fri"],
	        datasets: [{
	            label: 'Rate',
	            data: [19, 12, 3, 5, 7, 11, 1],
	            backgroundColor: [
	                '#636548',
	                '#636548',
	                '#636548',
	                '#636548',
	                '#636548',
	                '#636548',
	                '#636548'
	            ],
	            
	        }]
	    },
	    options: {
	        scales: {
	            yAxes: [{
	                ticks: {
	                    beginAtZero:true
	                }
	            }]
	        },
	        title:{
	        	display:true,
	        	text:'Clients Rate',
	        	fontSize:25
	        },
	        legend:{
	        	display:false
	        }
	    }
	});
	var ctxPie = document.getElementById("myPieChart").getContext('2d');
	var myChart2 = new Chart(ctxPie, {
	    type: 'pie',
	    data: {
	        labels: ["Sat", "Sun", "Mon", "Tus", "Thur", "Wed", "Fri"],
	        datasets: [{
	            label: 'Votes',
	            data: [19, 12, 13, 15, 17, 11, 21],
	            backgroundColor: [
	                '#b5bf2d',
	                '#8e44ad',
	                '#693f3a',
	                '#b3b58a',
	                '#ec8400',
	                '#ebecc6',
	                '#636548'
	            ],
	            
	        }]
	    },
	    options: {
	        scales: {
	            yAxes: [{
	                ticks: {
	                    beginAtZero:true
	                }
	            }]
	        },
	        title:{
	        	display:true,
	        	text:'Clients Rate',
	        	fontSize:25
	        }
	        
	    }
	});

	

 });
