<h1>Main Page</h1>
<script type="text/javascript">
//load json 
var username;
var use_user_id;
var user_regis;
var follow_user;
var tagName;
var tagUser;
var tag;
var tagLink;
var tag_status;
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

			  	//get user data
			  	$.each( data.json_user, function(key,value) {

			  	var user_id = value.Twitter_users.user_id;
			  	user_regis = value.Twitter_users.username; 
			  	if(user_regis==post_username)
			  	 {use_user_id=user_id;}

			 	 });

				//get follow data
			  	$.each( data.json_follow, function(key,value) {

			  	var follow_id = value.follow.id;
			  	 follow_byuser = value.follow.follow_user;
			  	 follow_user = value.follow.username;
			  	 follow_status = value.follow.status;

			  	//get tag data
			  	$.each(data.json_tag, function(key,value){
			  		tagName = value.tag.tagname;
			  		tagUser = value.tag.username;

			  	});

			  	if(follow_byuser==post_username)
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
			    	 	tagName="#"+tagName;
			    	 	tagLink = tagName.substring(1);
			    	 }	 		
			    		items.push(
			    			"<div>"
			    				   +"  "+
			    				   "<span id='username" + id+ "'><a href='/CakePHP/Users/usersPage/"+post_username+"'>@" 
			    				   +post_username+"</a></span> <br/>"+
			    				 "<span><a href='"+reply_tweet_username+"'>"+tweet+"</a></span><br/><a href='tag/"+tagLink+"'>"+tagName+"</a><br/>"+
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
				});		
			  });//end each		 
			  $("#get_data").html( items.join("") );
			});
	$('input').click(function(){
		update();
	});		
});

function update()
{
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

			  	//get user data
			  	$.each( data.json_user, function(key,value) {

			  	var user_id = value.Twitter_users.user_id;
			  	user_regis = value.Twitter_users.username; 
			  	if(user_regis==post_username)
			  	 {use_user_id=user_id;}

			 	 });

				//get follow data
			  	$.each( data.json_follow, function(key,value) {

			  	var follow_id = value.follow.id;
			  	 follow_byuser = value.follow.follow_user;
			  	 follow_user = value.follow.username;
			  	 follow_status = value.follow.status;

			  	//get tag data
			  	$.each(data.json_tag, function(key,value){
			  		tagName = value.tag.tagname;
			  		tagUser = value.tag.username;

			  	});

			  	if(follow_byuser==post_username)
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
			    	 	tagName="#"+tagName;
			    	 	tagLink = tagName.substring(1);
			    	 }	 		
			    		items.push(
			    			"<div>"
			    				   +"  "+
			    				   "<span id='username" + id+ "'><a href='/CakePHP/Users/usersPage/"+post_username+"'>@" 
			    				   +post_username+"</a></span> <br/>"+
			    				 "<span><a href='"+reply_tweet_username+"'>"+tweet+"</a></span><br/><a href='tag/"+tagLink+"'>"+tagName+"</a><br/>"+
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
				});		
			  });//end each		 
			  $("#get_data").html( items.join("") );
			});
}


function reply_tweet(id,username)
{
	$("#reply"+id).html("<form action='/CakePHP/Tweets/reply_tweet' method='post'><textarea name='reply_tweet'>@"+username+"</textarea><br/><input value='Tweet' type='submit'></input><input type='hidden' name='id' value='"+id+"'></input> </form>");

}

</script>

<u>This message will show </u>
<br/>
<div id="get_data"></div>
<div id="sending-js-submit"></div>
<div id="result-js-submit"></div>

<br/>
<?php echo "@$username"; ?>


<?php

	echo $this->Form->create('Twitter_post',array(
				'onclick' => 'update()'
		));
	echo $this->Form->textarea('tweet_detail',array(
				'rows' => '3'
		));

	echo $this->Js->submit( 'tweet', array(

	'url' => '/Tweets/tweetUpdate',    
    'update' => '#result-js-submit',
    'id' => 'submit'
  
	)); 
	echo $this->Form->end();

	echo $this->Html->link($this->Form->button('Logout'), 
							array('action' => 'index'), 
							array('escape'=>false,'title' => "Click to logout")
						   );//create link button

?>