
<style type="text/css">

	#profile_container
	{
		margin-left: 22%;
	}
	.submit
	{
		float: left;
	}	

</style>

<div id="profile_container">

<h1>Profile Setting</h1>

<?php

	echo $this->Form->create('Twitter_users',array(
			'enctype' => 'multipart/form-data',
		));
	echo $this->Form->input('username',array(
			'value' => $user_data['Twitter_users']['username']
		));
	echo $this->Form->input('password',array(
			'value' => $user_data['Twitter_users']['password']
		));
	echo $this->Form->input('name', array(
			'value' => $user_data['Twitter_users']['name']
		));
	echo $this->Form->input('email', array(
			'value' => $user_data['Twitter_users']['email']
		));
?>
	
	Display image<br/>	
	<input type="file" name="display_image" />
	<br/>
	Presently Display image<br/>
	<img src="<?php echo $user_data['Twitter_users']['display_image'] ?>">
	<br/>wall image<br/>
	<input type="file" name="wall_image" />
	<br/>Presently Wall Image<br/>
	<img src="<?php echo $user_data['Twitter_users']['wall_image'] ?>">

	<div id="button" ><?php echo $this->Form->end('Save changes'); ?></div>
	<?php
		echo $this->Html->link($this->Form->button('Home'), 
								array('controller' => 'Tweets','action' => 'getTweet'), 
								array('escape'=>false,'title' => "Go to my home")
							   );//create link button
	?>

</div>