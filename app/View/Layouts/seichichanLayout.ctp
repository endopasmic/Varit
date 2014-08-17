<html>
<head>
<?php
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!-- import Geolocation V3 -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>

<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<meta charset="utf-8">
</head>

<body>

<?php 
echo $this->Html->css('cake.generic');
echo $this->Html->css('Location'); 
echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');
?> 

<div id="container">

		<div id="header">
			<h1><?php echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
		</div>
		
		<div id="content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
		</div><!-- end of content -->	
			
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
				);
			?>
			<p>
				<?php echo $cakeVersion; ?>
			</p>
		</div><!-- end of #footer -->
		
</div><!--end of #container  -->
	<?php echo $this->element('sql_dump'); ?>

</body>
</html>