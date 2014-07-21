

<style type="text/css">
	
#follower_container
{
	margin-left: 22%;
}


</style>

<div id="follower_container">
<h1>Follower</h1>



<?php

	foreach ($follower_data as $follower_data) 
	{
		foreach ($user_data as $user) 
		{
			
			if($follower_data['follow']['follow_user']==$page_data['Twitter_users']['username']&&
			$follower_data['follow']['username']!=$page_data['Twitter_users']['username']&&
				 $user['Twitter_users']['username']==$follower_data['follow']['username'])
				
			{	

			?>
			<!--////////////////////////////////////////////////////////////////// -->
			<!--Pattern HTML-->
			  <div id="pattern" class="pattern">
			  	<ul class="list img-list">

							<a href="/CakePHP/Users/usersPage/<?php echo $follower_data['follow']['username']; ?>" class="inner">
								<div class="li-img">
									<img width="100" height="" src="<?php echo $user['Twitter_users']['display_image']; ?>" alt="Image Alt Text" />
								</div>
								<div class="li-text">
									<h4 class="li-head"><?php echo $user['Twitter_users']['name'].'@'.$follower_data['follow']['username']; ?></h4>

								</div>
							</a>

					</ul>
				</div>

			<!--End Pattern HTML-->
			<!--///////////////////////////////////////////////////////////// -->

<?php	
				
			}//end  id
		}//end foreach
	}//end foreach


//echo $following_data['follow']['follow_user'];
?>
</div>





