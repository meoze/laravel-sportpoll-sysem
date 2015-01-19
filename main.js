/***********************************************************
 *   file : main.js                                        *
************************************************************/
	// Get sport value on change select box and post value to ge team data
	$("#sport").change(function () { 
		var sport = $('#sport').val();

		if (sport == 'default') {
			$('#team').empty();
		} else {
			
			$.ajax({
				url:'getteams',
				type:'POST',
				data: {sport : sport}
			}).success(function(data){	
				$('#team').html(data);
			});
		}
	});

	// Get sport name to post and retreive responses for sport value
	$("#responseSport").change(function () { 
		var responseSport = $('#responseSport').val();

		$.ajax({
			url:'getresponse',
			type:'POST',
			data: {ressport : responseSport}
		}).success(function(data){	
			$('#responselog').html(data);
		});
	});	
