
Data from Controller
<br/><br/>
<?php 
echo $Latitude = "Latitude: ".$LocationData['Location']['Latitude']."<br/>";
echo $Longitude = "Longitude: ".$LocationData['Location']['Longitude']."<br/>";
?>

<!-- Geolocation set current location script -->
<?php 
echo $this->Html->script('ResultMap', array('inline' => false));
 ?>
 
 <!-- show map -->
<div id="map-canvas"></div>






















