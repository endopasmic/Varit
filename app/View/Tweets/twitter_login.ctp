
<!-- this is view of twitter index -->
<h1>Welcome to twitter</h1>

Please login or register

<?php
	echo $this->Form->create('Twitter_users', array(
											'type' => 'post'));
	echo $this->Form->input('Username');//create textfeild
	echo $this->Form->input('password');
	echo $this->Form->end('Login');//End form
	echo $this->Html->link($this->Form->button('Register'), 
							array('action' => 'register'), 
							array('escape'=>false,'title' => "Click to view somethin")
						   );//create link button

?>
<br/><br/>
List of registered 
<br/>
<?php
	foreach ($user_data as $Tweet) {
		echo $Tweet['Twitter_users']['username'];
		echo "<br/>";
	}
?>