
//getJSON
var Latitude;
var Longitude;

$(document).ready(function(){
	$.getJSON("/CakePHP/Article/show.json", function(data){
		
		$.each(data.LocationJSON, function(key,value) {

      Latitude = value.Location.Latitude;
      Longitude = value.Location.Longitude;
			
		});//end each function	

	});//end getJSON function
});//end ready function

///////////////////////////////////////////////////////////

//set geolocation map
var map;
var latitude;
var longitude;
function initialize() {
  var mapOptions = {
    zoom: 15
  };
  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  // Try HTML5 geolocation
  if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = new google.maps.LatLng(Latitude,Longitude);

      var infowindow = new google.maps.InfoWindow({
        map: map,
        position: pos,
        content: 'testlocation'
      });

      map.setCenter(pos);
      latitude = position.coords.latitude;
      longitude = position.coords.longitude;

    }, function() {
      handleNoGeolocation(true);
    });
       
  } else {
    // Browser doesn't support Geolocation
    handleNoGeolocation(false);
  }
}

function handleNoGeolocation(errorFlag) {
  if (errorFlag) {
    var content = 'Error: The Geolocation service failed.';
  } else {
    var content = 'Error: Your browser doesn\'t support geolocation.';
  }

  var options = {
    map: map,
    position: new google.maps.LatLng(60, 105),
    content: content
  };

  var infowindow = new google.maps.InfoWindow(options);
  map.setCenter(options.position);
}

google.maps.event.addDomListener(window, 'load', initialize);

