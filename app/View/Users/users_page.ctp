<!-- this is view -->
<h1>This is <?php  echo "@".$page_data['Twitter_users']['username']; ?> page</h1>

<!--//follow and unfollow button -->
<?php
$check_follow="Follow";
	echo $this->Form->create('follow');

	echo "<input type='hidden' name='username' value='".$page_data['Twitter_users']['username']."'/>";
	echo $this->Js->submit( $check_follow, array(

	'url' => '/Users/follow',    
    'id' => 'submit',
    'complete' => 'update();'
  
	)); 
	echo $this->Form->end();

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
var username;
var use_user_id;
var user_regis;
var follow_user;
$(document).ready(function(){
			//get json file
			$.getJSON( "/CakePHP/Tweets/getTweet.json", function( data ) {
			  var items = [];
			  //seperate json in to normal form 

			  	//get tweet data
			  	$.each( data.json, function(key,value) {
			  	//sperated json into value 	  	
			  	id = value.Twitter_post.id;
			  	username = value.Twitter_post.username;
			  	var tweet = value.Twitter_post.tweet;
			  	
			  	//get user data
			  	$.each( data.json_user, function(key,value) {
			  	
			  	var user_id = value.Twitter_users.user_id;
			  	user_regis = value.Twitter_users.username; 
			  	if(user_regis==username)
			  	 {use_user_id=user_id;}

			 	 });
			  	
			  	//get follow data
			  	$.each( data.json_follow, function(key,value) {
			  	
			  	var follow_id = value.follow.id;
			  	 follow_byuser = value.follow.follow_user;
			  	 follow_user = value.follow.username;

			  	if("<?php echo $page_data['Twitter_users']['username']; ?>"==username)
			  	{
			    	items.push(
			    			"<div>"
			    				   +"  "+
			    				   "<span id='username" + id+ "'><a href='/CakePHP/Users/usersPage/"+username+"'>@" 
			    				   +username+"</a></span> <br/>"
			    				   +"<span name=''>"+tweet+"</span><br/>"+
			    				    "<button onclick=\"reply_tweet(" + id + ", '" + username+"');\">REPLY</button>"
			    				   +"<div id='reply"+id+"'></div>"+
			    			"</div>"
			    		);
				
					    //delete
					    if(username=="<?php echo $username ?>")
					    {
					    	items.push("<form method='post' action='/CakePHP/Tweets/delete_tweet'><input type=submit value='DELETE'></input><input type='hidden' value='"+id+"' name='delete_id'></input></form>");
					    }
				}
				});		
			  });//end each		 
			  $("#get_data").html( items.join("") );
			});
	/*
	$('input').click(function(){
		update();
	});	
	*/	
});	

function reply_tweet(id,username)
{
	$("#reply"+id).html("<form action='/CakePHP/Tweets/reply_tweet' method='post'><textarea name='reply_tweet'>@"+username+"</textarea><br/><input value='Tweet' type='submit'></input><input type='hidden' name='id' value='"+id+"'></input> </form>");

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