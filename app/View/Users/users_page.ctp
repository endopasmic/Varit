<!-- this is view -->
<h1>This is <?php  echo "@".$page_data['Twitter_users']['username']; ?> page</h1>


<!--//follow and unfollow button -->
<?php
//自分のページではFollowボタンがない

if($username == $page_data['Twitter_users']['username'] )
{
 echo "<h4>This is my page</h4>";
}
else if($username != $page_data['Twitter_users']['username'] )
{
	//$check_follow="Follow";
	echo $this->Form->create('follow');

	echo "<input type='hidden' name='username' value='".$page_data['Twitter_users']['username']."'/>";
	echo $this->Js->submit( 'Follow', array(

	'url' => '/Users/follow',    
    'id' => 'submit',
    'complete' => 'update();'
  
	)); 
	echo $this->Form->end();
}
?>

<script type="text/javascript">

	function update()
	{
		if($('#submit').val()=='Follow')
		{		
			$('input:hidden[name="username"]').attr('name', 'unfollow');
			$('#submit').val('Unfollow');
		}
		else if($('#submit').val()=='Unfollow')
		{
			$('input:hidden[name="unfollow"]').attr('name', 'username');
			$('#submit').val('Follow');
		}
	}

</script>
<hr/>
<!-- create menu Following followers -->
<?php

echo $this->Form->create('usersPage',array(
		'type' => 'post'
	));
echo $this->Form->button('Following',array(
		'name' => 'following',
		'value' => 'following'
	));
echo $this->Form->button('Follower',array(
		'name' => 'follower',
		'value' => 'follower'		
	));
echo $this->Form->end();


?>

<?php
//show username
 echo "<br/>";
 echo "<b>show username</b>";
 echo "<br/>";
 echo "@".$page_data['Twitter_users']['username'];
?>	

<br/>
<?php
echo "<b>show tweet</b>";
?>
<!--get tweet by jQuery getJSON -->

<script type="text/javascript">
//load json 
var post_username;
var use_user_id;
var user_regis;
var follow_user;
var follow_status;
var reply_tweet_id;
var reply_tweet_username;
$(document).ready(function(){
			//get json file
			$.getJSON( "/CakePHP/Tweets/getTweet.json", function( data ) {
			  var items = [];
			  //seperate json in to normal form 

			  	//Twitter_post  
			  	$.each( data.json, function(key,value) {
	
			  	id = value.Twitter_post.id;
			  	post_username = value.Twitter_post.username;
			  	var tweet = value.Twitter_post.tweet;
			  	reply_tweet_id = value.Twitter_post.reply_tweet_id;
			  	reply_tweet_username = value.Twitter_post.reply_tweet_username;
			  	
			  	//Twitter_users
			  	$.each( data.json_user, function(key,value) {
			  	
			  	var user_id = value.Twitter_users.user_id;
			  	user_regis = value.Twitter_users.username; 
			  	if(user_regis==post_username)
			  	 {use_user_id=user_id;}

			 	 });
			  	
			  	//follow
			  	$.each( data.json_follow, function(key,value) {
			  	
			  	var follow_id = value.follow.id;
			  	 follow_byuser = value.follow.follow_user;
			  	 follow_user = value.follow.username;
			  	 follow_status = value.follow.status;
			  	 });	

			  	if("<?php echo $page_data['Twitter_users']['username']; ?>"==post_username)
				{
					if(!reply_tweet_username)
						{reply_tweet_username=document.URL;}
			    	items.push(
			    			"<div>"
			    				   +"  "+
			    				   "<span id='username" + id+ "'><a href='/CakePHP/Users/usersPage/"+post_username+"'>@" 
			    				   +post_username+"</a></span> <br/>"+
			    				 "<span><a href='"+reply_tweet_username+"'>"+tweet+"</a></span><br/>"+
			    				    "<button onclick=\"reply_tweet(" + id + ", '" + post_username+"');\">REPLY</button>"
			    				   +"<div id='reply"+id+"'></div>"+
			    			"</div>"
			    		);
				
					    //delete
					    if(post_username=="<?php echo $username ?>")
					    {
					    	items.push("<form method='post' action='/CakePHP/Tweets/delete_tweet'><input type=submit value='DELETE'></input><input type='hidden' value='"+id+"' name='delete_id'></input></form>");
					    }


				}

			  });//end each		  
			  $("#get_data").html( items.join("") );
			  
			  if(follow_status=="TRUE"&&follow_byuser=="<?php echo $page_data['Twitter_users']['username'];  ?>")
			 
			 	{
			 		$('#submit').val('Unfollow');
			 		$('input:hidden[name="username"]').attr('name', 'unfollow');
			 	}	
	  			else
	  			{
	  				$('#submit').val('Follow');
	  				$('input:hidden[name="unfollow"]').attr('name', 'username');
	  			}					

			});
	/*
	$('input').click(function(){
		update();
	});	
	*/	
});	
//this is for reply
function reply_tweet(id,post_username)
{
	$("#reply"+id).html("<form action='/CakePHP/Tweets/reply_tweet' method='post'><textarea name='reply_tweet'>@"+username+"</textarea><br/><input value='Tweet' type='submit'></input><input type='hidden' name='id' value='"+id+"'></input><input type='hidden' name='reply_username' value='"+username+"'></input> </form>");


}

</script>

<div id="get_data"></div>
<div id="sending-js-submit"></div>
<div id="result-js-submit"></div>

<?php
echo "<br/>";
echo $this->Html->link($this->Form->button('Home'), 
							array('controller' => 'Tweets','action' => 'getTweet'), 
							array('escape'=>false,'title' => "Go to my home")
						   );//create link button

/*
<form method='post' action='#'>
<input type='submit' id='follow' onclick='update()' value='test'>
<input type='hidden' name='user_id' value='<?php echo $page_data['Twitter_users']['user_id']; ?>'>
</form>

*/

?>