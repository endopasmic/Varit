<h1>Following</h1>

<h1>This is <?php  echo "@".$page_data['Twitter_users']['username']; ?> page</h1>


<?php

	foreach ($following_data as $following_data) 
	{
		if($following_data['follow']['username']==$page_data['Twitter_users']['username']&&
			 $following_data['follow']['follow_user']!=$following_data['follow']['username'])
		{	
		echo $following_data['follow']['follow_user'];
		echo "<br/>";
		}
	}


//echo $following_data['follow']['follow_user'];


?>