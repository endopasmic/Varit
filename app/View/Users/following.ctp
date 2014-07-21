<style type="text/css">
	
#following_container
{
	margin-left: 22%;
}


</style>

<div id="following_container">
<h1>Following</h1>


<?php

	foreach ($following_data as $following_data) 
	{
		foreach ($user_data as $user) 
		{
			
			if($following_data['follow']['username']==$page_data['Twitter_users']['username']&&
				 $following_data['follow']['follow_user']!=$following_data['follow']['username']&&
				 $user['Twitter_users']['username']==$following_data['follow']['follow_user'])
				
			{	

			?>
			<!--////////////////////////////////////////////////////////////////// -->
			<!--Pattern HTML-->
			  <div id="pattern" class="pattern">
			  	<ul class="list img-list">

							<a href="/CakePHP/Users/usersPage/<?php echo $following_data['follow']['follow_user']; ?>" class="inner">
								<div class="li-img">
									<img width="100" height="" src="<?php echo $user['Twitter_users']['display_image']; ?>" alt="Image Alt Text" />
								</div>
								<div class="li-text">
									<h4 class="li-head"><?php echo $user['Twitter_users']['name'].'@'.$following_data['follow']['follow_user']; ?></h4>

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

