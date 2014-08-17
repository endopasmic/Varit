
<!--this is layuout -->
<?php
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())



?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $this->fetch('title'); ?></title>

<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="/CakePHP/css/woodButton.css" type="text/css" />

<!-- import AJAX -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="http://jquery.offput.ca/js/jquery.timers.js">
  </script>

<style type="text/css">
    @font-face
    {
      font-family: ThaiSans Neue;
      src:url(http://endopasmic.azurewebsites.net/co-op/font/ThaiSansNeue-Light.otf);
    }
	  @import url("/CakePHP/css/960.css") screen and (min-width : 960px);
  
  	  body{
      font-family: ThaiSans Neue;
      padding: 30px 0 0 0;
      font-size: 20pt;


    }
</style>

<?php 
// Jsヘルパーが生成するJSを出力させる
echo $this->Js->writeBuffer( array( 'inline' => 'true'));
?>
<!-- Include external files and scripts here (See HTML helper for more info.) -->
<?php
	echo $this->Html->charset();

	echo $this->Html->css('login');
	echo $this->Html->script('ajaxupload.js');
	echo $this->Html->script('header.js');



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