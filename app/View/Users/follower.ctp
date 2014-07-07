<h1>Follower</h1>

<h1>This is <?php  echo "@".$page_data['Twitter_users']['username']; ?> page</h1>

<?php	
	foreach ($follower_data as $follower_data) 
	{
		if($follower_data['follow']['follow_user']==$page_data['Twitter_users']['username']&&
			$follower_data['follow']['username']!=$page_data['Twitter_users']['username'])
		{	
		echo $follower_data['follow']['username'];
		echo "<br/>";
		}
	}


?>