<h1>Main Page</h1>
<style type="text/css">
	
img
{
 max-width: 400px;
 max-height: 400px;

}

</style>
<script type="text/javascript">
//load json 
var username;
var use_user_id;
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

				//get follow data
			  	$.each( data.json_follow, function(key,value) {

			  	var follow_id = value.follow.id;
			  	 follow_byuser = value.follow.follow_user;
			  	 follow_user = value.follow.username;
			  	 follow_status = value.follow.status;


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
			  	imagelink = value.Twitter_post.imagelink;


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
			    				 "<span><a href='"+reply_tweet_username+"'>"+tweet+"</a></span><br/><a href='tag/"+tagLink+"'>"+tag_name+"</a><br/><img src="+imagelink+" ><br/>"+
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

<?php echo "@$username"; ?>

<?php
	print_r($_POST);
	print_r($_FILES);
?>

<form id="data" method="post" enctype="multipart/form-data">
	<input type="text" name="text" />
	<br/>
	<input type="file" name="image" />
	<br/>
	<button>Submit</button>
</form>

<script>

	$("form#data").submit(function(){

		var formData = new FormData ($(this)[0]);

		$.ajax({
			url: "/CakePHP/Tweets/tweetUpdate",
			type: "POST",
			data: formData,
			async: false,
			success: function(data){
				alert(data)
			},
			cache: false,
			contentType: false,
			processData: false
		});

		return false;
	});

</script>
