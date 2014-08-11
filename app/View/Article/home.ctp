
<?php
//this is view

echo $this->Html->link(
	'現在マップを保存',	
	array(
		'controller' => 'Location',
		'action' => 'SaveLocation'	
	)
);


?>