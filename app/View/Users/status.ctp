<style type="text/css">
	
img
{
	max-width: 400px;
	max-height: 400px;
}

</style>
<?php 
	echo "id is ".$status_data['Twitter_post']['id'];
	$id = $status_data['Twitter_post']['id'];
?>
<br/>
<h1>This is Status Page</h1>

Username is
<?php echo $page_data['Twitter_users']['username']; ?>
<br/>
Imagename is
<?php echo $status_data['Twitter_post']['imagetitle']; ?>

<?php

echo "@".$status_data['Twitter_post']['username'];
echo "<br/>";
echo $status_data['Twitter_post']['tweet'];
echo "<br/>";
echo $status_data['Twitter_post']['tagname'];
?>

<img src="<?php echo $status_data['Twitter_post']['imagelink']; ?>">
<hr/>
<br/>

<script type="text/javascript">

//load json 
var username;
var user_regis;
var follow_user;
var tag_ame;
var tagUser;
var tag;
var tagLink;
var tag_status;
var imagelink;
var imageTitle;
var image_data;
var tweet;
var retweet_id;
var retweet_username;
var retweet_status="";

var user_id;var use_user_id;
var name;var use_name;
var display_image;var use_display_image;
$(document).ready(function(){

			//get json file
			$.getJSON( "/CakePHP/Tweets/getTweet.json", function( data ) {
			  var items = [];

			  	//get tweet data
			  	$.each( data.json, function(key,value) {
			  	//sperated json into value 	  	
		  		id = value.Twitter_post.id;
			  	post_username = value.Twitter_post.username;
			  	var tweet = value.Twitter_post.tweet;
			  	reply_tweet_id = value.Twitter_post.reply_tweet_id;
			  	reply_tweet_username = value.Twitter_post.reply_tweet_username;
			  	tag_status = value.Twitter_post.tag_status;
			  	tag_name = value.Twitter_post.tagname;
			  	imagelink = value.Twitter_post.imagelink;
			  	imageTitle = value.Twitter_post.imagetitle;
			  	//get user data
			  	$.each( data.json_user, function(key,value) {

			  	var user_id = value.Twitter_users.user_id;
			  	user_regis = value.Twitter_users.username; 
			  	if(user_regis==post_username)
			  	 {use_user_id=user_id;}

			 	 });

		
			  	if(reply_tweet_id　== "<?php echo $id; ?>")
			  	{
			   		//debug reply link
			    	if(!reply_tweet_username)
					{reply_tweet_username=document.URL;}
					
					//debug no tag tweet
			    	if(tag_status=='FALSE')
			    		{tagName=" ";}
			    	if(tagUser!=post_username)
			    	 	{tagName=" ";}
			    	if(tag_status!='FALSE')
			    	 {
			    	 	tag_name="#"+tag_name;
			    	 	tagLink = tag_name.substring(1);
			    	 }

			    	 //image			    		
			    	if(imagelink!="")
			    	{
			    			image_data="<br/><a href='/CakePHP/Users/usersPage/"+post_username+"/"+imageTitle+"'>imageLink</a><br/><img src="+imagelink+" ><br/>"
			    	}
			    	else
			    	{
			    		image_data="";
			    	}
			    		

			    		items.push(
			    			"<div>"
			    				   +"  "+
			    				   "<span id='username" + id+ "'><a href='/CakePHP/Users/usersPage/"+post_username+"'>@" 
			    				   +post_username+"</a></span> <br/>"+
			    				 "<span><a href='"+reply_tweet_username+"'>"+tweet+"</a></span>"+image_data+"<br/><a href='tag/"+tagLink+"'>"+tag_name+"</a><br/>"+
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
			});

});

function reply_tweet(id,username)
{
	$("#reply"+id).html("<form action='/CakePHP/Tweets/reply_tweet' method='post'><textarea name='reply_tweet'>@"+username+"</textarea><br/><input value='Tweet' type='submit'></input><input type='hidden' name='id' value='"+id+"'></input><input type='hidden' name='reply_username' value='"+username+"'></input> </form>");
}
	
</script>

<div id="get_data"></div>

<?php
echo $this->Html->link($this->Form->button('Home'), 
							array('controller' => 'Tweets','action' => 'getTweet'), 
							array('escape'=>false,'title' => "back to home")
						   );//create link button

?>

