
<style type="text/css">
	
#text
{
	margin-top: 10px;
}


</style>

<div id="login">
<h1><strong>Register</strong></h1>
<?php

	echo $this->Form->create('Twitter_users',array(
			'enctype' => 'multipart/form-data',
		));
	echo $this->Form->input('username',array(
			'id' => 'text',
		));
	echo $this->Form->input('password',array(
			'style' => 'margin-top:10px;'
		));
	echo $this->Form->input('name',array(
			'id' => 'text'
		));
	echo $this->Form->input('email',array(
			'id' => 'text'
		));
?>
	
	Display image<br/>	
	<input type="file" name="display_image" />
	<br/>wall image<br/>
	<input type="file" name="wall_image" />

<?php
	echo $this->Form->end('Register');
?>

</div>