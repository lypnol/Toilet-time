var toilets = [];
var toiletIconPath = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=|';

function updateActivity(key){
	$.get("data.php?activity="+key,function(data){
		// console.log(data);
		$("#activity-container").html(data);
		setTimeout(updateActivity(key),2000);
	});
}

function showInfo(id){
	$("#preloader").show();
	$("#modal-body").hide();
	$("#modal-title").hide();
	$("#modal").modal("show");
	$.get("data.php?info="+id,function(data){
		var response = JSON.parse(data);
		$("#modal-body").html(response.info);
		$("#modal-title").html(response.name);
		$("#preloader").hide();
		$("#modal-body").fadeIn();
		$("#modal-title").fadeIn();
	});
} 

function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
	center: {lat: -34.397, lng: 150.644},
	zoom: 18
  });
  
  // Try HTML5 geolocation.
  if (navigator.geolocation) {
	navigator.geolocation.getCurrentPosition(function(position) {
	  var pos = {
		lat: position.coords.latitude,
		lng: position.coords.longitude
	  };

	  map.setCenter(pos);
	  
	  var myMarker = new google.maps.Marker({
		position: pos,
		map: map,
		icon: 'img/my.png'
	  });
	  
	  $.get("data.php?positions",function(data){
		console.log(data);
		var toiletMarkers = JSON.parse(data);
		
		for(var i = 0; i<toiletMarkers.length; i++){
			var pos = {lat: parseFloat(toiletMarkers[i].position.split(",")[0]),lng: parseFloat(toiletMarkers[i].position.split(",")[1])};
			// console.log(pos);
			toilets[i] = {};
			toilets[i].marker = new google.maps.Marker({
				position: pos,
				map: map,
				icon: toiletIconPath+toiletMarkers[i].color+'|000000'
			});
			var toilet_id = toiletMarkers[i].key;
			toilets[i].key = toilet_id;
			toilets[i].marker.addListener('click', function(){
				$("#preloader").show();
				$("#modal-body").hide();
				$("#modal-title").hide();
				$("#modal").modal("show");
				$.get("data.php?info="+toilet_id,function(info){
					console.log(info);
					var response = JSON.parse(info);
					$("#activity-container").html(response.info);
					$("#modal-title").html(response.name);
					$("#preloader").hide();
					$("#modal-body").fadeIn();
					$("#modal-title").fadeIn();
				});
			});
		}
		updateColor();
		if (toilets.length > 0) { 
            updateActivity(toilets[0].key);
        }
	  });
	}, function() {
	  handleLocationError(true, infoWindow, map.getCenter());
	});
  } else {
	// Browser doesn't support Geolocation
	handleLocationError(false, infoWindow, map.getCenter());
  }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(browserHasGeolocation ?
						'Error: The Geolocation service failed.' :
						'Error: Your browser doesn\'t support geolocation.');
}

function updateColor(){
	$.get("data.php?color="+toilets[0].key,function(color){
		toilets[0].marker.setIcon(toiletIconPath+color+'|000000');
		setTimeout(updateColor,1000);
	});
}