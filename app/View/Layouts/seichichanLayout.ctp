<html>
<head>
<?php
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
</head>

<body>


<?php echo $this->fetch('content'); ?> 
</body>
</html>