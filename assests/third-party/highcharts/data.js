$(function() {
	var months = [];
	var days = [];
	var switch1 = true;
	$.get('index.php?action=getSearch_Chart', function(data) {
		data = data.split('/');
		for (var i in data) {
			if (switch1 == true) {
				months.push(data[i]);
				switch1 = false;
			} else {
				days.push(parseFloat(data[i]));
				switch1 = true;
			}

		}
		months.pop();
        
		$('#chart').highcharts({
			chart : {
				type : 'spline'
			},
			title : {
				text : 'Number of Searches per day '
			},
			subtitle : {
				text : 'Search stats'
			},
			xAxis : {
				title : {
					text : 'Date'
				},
				categories : months
			},
			yAxis : {
				title : {
					text : 'Total Number of Searches'
				},
				labels : {
					formatter : function() {
						return this.value + ''
					}
				}
			},
			tooltip : {
				crosshairs : true,
				shared : true,
				valueSuffix : ''
			},
			plotOptions : {
				spline : {
					marker : {
						radius : 4,
						lineColor : '#666666',
						lineWidth : 1
					}
				}
			},
			series : [{

				name : ' Seaches',
				data : days 
			}]
		});
	});
}); 
    
