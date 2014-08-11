
<?php
//this is view
echo $this->Session->flash();

echo $this->Html->link(
	'現在マップを保存',	
	array(
		'controller' => 'Location',
		'action' => 'SaveLocation'	
	)
);
?>
<br/>

<?php 
echo $this->Html->link(
	'日記を表示',
	array(
		'action' => 'show'
	)	
);


?>