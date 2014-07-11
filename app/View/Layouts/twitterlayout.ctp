
<!--this is layuout -->

<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $this->fetch('title'); ?></title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

<!-- import AJAX -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="http://jquery.offput.ca/js/jquery.timers.js">
  </script>

  <?php 
// Jsヘルパーが生成するJSを出力させる
echo $this->Js->writeBuffer( array( 'inline' => 'true'));
?>
<!-- Include external files and scripts here (See HTML helper for more info.) -->
<?php
	echo $this->Html->charset();
	echo $this->Html->css('index.css');
	echo $this->Html->script('ajaxupload.js');

	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
?>

</head>
<body>
<!-- If you'd like some sort of menu to
show up on all of your views, include it here -->
<div id="header">
    <div id="menu"></div>
</div>

<!-- Here's where I want my views to be displayed -->
<?php echo $this->fetch('content'); ?>

<!-- Add a footer to each displayed page -->
<div id="footer"></div>

</body>
</html>