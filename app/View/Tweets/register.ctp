<h1>This is Register page</h1> 

<?php

	echo $this->Form->create('Twitter_users');
	echo $this->Form->input('username');
	echo $this->Form->input('password');
	echo $this->Form->input('email');
	echo $this->Form->end('Register');

?>