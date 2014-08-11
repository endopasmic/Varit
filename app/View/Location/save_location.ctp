
    <title>Geolocation</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <meta charset="utf-8">
    <style>
      html, body {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      #map-canvas
      {
        height: 50%;
      }

    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>

    <script>
// Note: This example requires that you consent to location sharing when
// prompted by your browser. If you see a blank space instead of the map, this
// is probably because you have denied permission for location sharing.

var map;
var latitude;
var longitude;
function initialize() {
  var mapOptions = {
    zoom: 10
  };
  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  // Try HTML5 geolocation
  if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = new google.maps.LatLng(position.coords.latitude,
                                       position.coords.longitude);

      var infowindow = new google.maps.InfoWindow({
        map: map,
        position: pos,
        content: 'testlocation'
      });

      map.setCenter(pos);
      latitude = position.coords.latitude;
      longitude = position.coords.longitude;
      $('input:hidden[name="latitude"]').attr('value',latitude);
      $('input:hidden[name="longitude"]').attr('value',longitude);


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

    </script>
  </head>
  <body> 
    <div id="map-canvas"></div>
    <h2>Show position detail</h2>

   <form method="post">
     
    <input type="hidden" name="latitude" value="0">
    <input type="hidden" name="longitude" value="0">

    <input type="submit">

   </form>

   <hr/>

   <h2>POST DATA</h2>

   <?php
    echo "Current Latitude= ".$_POST['latitude'];
    echo "<br/>";
    echo "Current Longtitude= ".$_POST['longitude'];

   ?>
  </body>
