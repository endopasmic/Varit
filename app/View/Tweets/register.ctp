<h1>This is Register page</h1> 

<?php

	echo $this->Form->create('Twitter_users',array(
			'enctype' => 'multipart/form-data',
		));
	echo $this->Form->input('username');
	echo $this->Form->input('password');
	echo $this->Form->input('name');
	echo $this->Form->input('email');
?>
	
	Display image<br/>	
	<input type="file" name="display_image" />
	<br/>wall image<br/>
	<input type="file" name="wall_image" />

<?php
	echo $this->Form->end('Register');
?>