
<!-- this is view of twitter index -->
<style type="text/css">
	#flashMessage{
		color: red;
		font-weight: bold;
	}
</style>
<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Open+Sans:400,300'>
<div id="login">

			<h1><strong>Welcome.</strong> Please login.</h1>

			<fieldset>
			<?php
			echo $this->Session->flash();

				echo $this->Form->create('Twitter_users', array(
														'type' => 'post'));
				echo $this->Form->input('Username',array('id' => 'text',
														'value' => 'Username',
														'label' => false
														));//create textfeild
				echo $this->Form->input('password',array('type' => 'password',
												  'style' => 'margin-top:10px;',	
												   'value' => 'Password',
												   'label' => false		
								));
			?>
			
			<br/><br/>

			<?php	
				echo $this->Form->input(' Login ',array(
					'type' => 'submit',
					'id' => 'submit',
					'label' => false

					));
				echo $this->Form->end();//End form 
			?>

			<p><span class="btn-round">or</span></p>
			
			<button id="submit">
			<?php

				echo $this->Html->link('Register',array(
					'action' => 'register',
				));//create link button

			?>
			</button>

</div>



<!-------------->
