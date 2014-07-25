<div id="tweet_main">

<h2>
Result for
<?php

echo "#".$tagName['tag']['tagname'];

?>
</h2>

<?php

	foreach ($tagData as $tagData)
	{
		//echo $tagData['tag']['username']."  ".$tagData['tag']['tag_tweet']."<br/>";

	} 
?>


<div id="get_data"></div>

</div>


<script type="text/javascript">
//load json 
var username;
var user_regis;
var follow_user;
var tag_name;
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
var tweet_id;


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
			  	tweet = value.Twitter_post.tweet;
			  	reply_tweet_id = value.Twitter_post.reply_tweet_id;
			  	reply_tweet_username = value.Twitter_post.reply_tweet_username;
			  	tag_status = value.Twitter_post.tag_status;
			  	tag_name = value.Twitter_post.tagname;
			  	imagelink = value.Twitter_post.imagelink;
			  	imageTitle = value.Twitter_post.imagetitle;
			  	retweet_id = value.Twitter_post.retweet_id;
			  	retweet_username = value.Twitter_post.retweet_username;

			  	
			  	//get user data
			  	$.each( data.json_user, function(key,value) {

			  	user_id = value.Twitter_users.user_id;
			  	user_regis = value.Twitter_users.username; 
			  	name = value.Twitter_users.name;
			  	display_image = value.Twitter_users.display_image;
			  	wall_image = value.Twitter_users.wall_image;

				  	//check username
				  	if(user_regis==post_username)
				  	 {
				  	 	use_user_id=user_id;
				  	 	use_name = name;
				  	 	use_display_image = display_image;
				  	 }


			 	 });




			  	if(id == "<?php echo $tagData['tag']['tweet_id']; ?>")
			  	{
			  		   		//debug reply link
			    	if(!reply_tweet_username)
					{reply_tweet_username=document.URL;}
					else
					{reply_tweet_username="/CakePHP/Users/usersPage/"+reply_tweet_username}
					
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
			    	
			    	//retweet
			    	if(retweet_id != 0 )
			    	{
			    		//show Retweet status text
			    		retweet_status = "Retweeted by <a href='/CakePHP/Users/usersPage/"+post_username+"'>"+ use_name + "</a><br/>";
			    		
			    		//change @username to retweet user but in DB still correct 
			    		post_username=retweet_username;
			    		use_name = name;
			    	}
			    	else
			    	{
			    		retweet_status="";
			    	}	


			            //add link to tweet in tag case
			            checkTag = tweet.search("#");

			            if(checkTag>=0)
			            {            
			              tweet = tweet.split(" ");
			              length = tweet.length;
			              for(i=0;i<length;i++)
			              {
			                checkTag = tweet[i].search("#");
			                if(checkTag==0)
			                {
			                  tweet[i] = "<a href=/CakePHP/Tweets/tag/"+tweet[i].substring(1)+">"+tweet[i]+"</a>";
			                } 

			              }//end loop
			            }//end if
			            else if(checkTag<0)
			            {}
			            tweet = tweet.toString();
			            tweet = tweet.replace(/,/g, ' ');
           
              //retweet
              if(post_username !="<?php echo $username; ?>" && retweet_id==0)
              {
                items.unshift("<form action='/CakePHP/Tweets/retweet' id='retweet' method='post' enctype='multipart/form-data'><input type='hidden'name='retweet_id' value='"+id+"' ><input type='hidden' name='imagelink' value='"+imagelink+"'><input type='hidden' name='tweet' value='"+tweet+"'><input type='hidden'name='retweet_username' value='"+post_username+"' ><button onclick=\"retweet('" + post_username + "', '" + tweet+"');\">RETWEET</button></form>");
              }

              //delete
              if(post_username =="<?php echo $username ?>" || retweet_id!=0)
              {
                items.unshift("<form method='post' action='/CakePHP/Tweets/delete_tweet'><input type=submit value='DELETE'></input><input type='hidden' value='"+id+"' name='delete_id'></input></form>");
              }

			    		items.unshift(
			    			"<div id='tweet_block'>"
			    				   +"<div class='profile'><img id='display_image' src='"+use_display_image+"'></div>"+"  "+retweet_status+
			    				   "<span id='username" + id+ "'><a href='/CakePHP/Users/usersPage/"+post_username+"'>"+use_name+"@" 
			    				   +post_username+"</a></span> <br/>"+
			    				 "<span>"+tweet+"</span><br/>"+
			    				    "<button id='reply' onclick=\"reply_tweet(" + id + ", '" + post_username+"');\">REPLY</button>"
			    				   +"<div id='reply"+id+"'></div>"+
			    			"</div>"
			    		);
					
			    		
				}

	
			  });//end each		 
			  $("#get_data").html( items.join(""));
			});
});

</script>