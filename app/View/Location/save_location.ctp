
<!-- Geolocation set current location script -->
<?php echo $this->Html->script('CurrentMap', array('inline' => false)); ?>

    <div id="map-canvas"></div>
    <h2>Show position detail</h2>

    
   <form method="post" >
     
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

    echo "<br/>".date('Y-m-d');
    
   ?>
