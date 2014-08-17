<style type="text/css">
	
img
{
	max-width: 600px;

}
#status_main
{
	margin-left: 22%;
}

</style>

<div id="status_main">
		<?php 
			$id = $status_data['Twitter_post']['id'];
			$image = $status_data['Twitter_post']['imagelink'];
			$user_image = $user_data['Twitter_users']['display_image'];
		?>


		<div id="get_data"></div>
</div>

<!-- load json  -->
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
var i;
var checkTag;
var tweet_ori;

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
		  		  tweet_ori = value.Twitter_post.tweet;
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
				    "<div id='tweet_block'>"
				    +"<div class='profile'><img id='display_image' src='"+use_display_image+"'></div>"+"  "+retweet_status+
				    				   "<span id='username" + id+ "'><a href='/CakePHP/Users/usersPage/"+post_username+"'>"+use_name+"@" 
				    				   +post_username+"</a></span> <br/>"+
				    				 "<span>"+tweet+"</span>"+image_data+"<br/>"+
				    				    "<button id='reply' onclick=\"reply_tweet(" + id + ", '" + post_username+"');\">REPLY</button>"
				     +"<div id='reply"+id+"'></div>"+
				    "</div>"
				    		);
				   //retweet
				if(post_username !="<?php echo $username; ?>" && retweet_id==0)
              {
     		  items.push("<form action='/CakePHP/Tweets/retweet' id='retweet' method='post' enctype='multipart/form-data'><input type='hidden'name='retweet_id' value='"+id+"' ><input type='hidden' name='imagelink' value='"+imagelink+"'><input type='hidden' name='tweet' value='"+tweet+"'><input type='hidden'name='retweet_username' value='"+post_username+"' ><button type='button' onclick=\"retweet('" + post_username + "', '" + tweet+"');\">RETWEET</button></form>");
              }
					              //delete
              if(post_username =="<?php echo $username ?>" || retweet_id!=0)
              {
                items.push("<form id='delete' method='post' action='/CakePHP/Tweets/delete_tweet'><button type='button' onclick='delete_tweet()' >DELETE</button></input><input type='hidden' value='"+id+"' name='delete_id'></input></form>");
              }

				}//end if 

			  	 if(id == "<?php echo $id ?>")
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

						         //retweet
			              if(post_username !="<?php echo $username; ?>" && retweet_id==0)
			              {
			                      items.unshift("<form action='/CakePHP/Tweets/retweet' id='retweet' method='post' enctype='multipart/form-data'><input type='hidden'name='retweet_id' value='"+id+"' ><input type='hidden' name='imagelink' value='"+imagelink+"'><input type='hidden' name='tweet' value='"+tweet+"'><input type='hidden'name='retweet_username' value='"+post_username+"' ><button type='button' onclick=\"retweet('" + post_username + "', '" + tweet+"');\">RETWEET</button></form>");
			              }


              //delete
              if(post_username =="<?php echo $username ?>" || retweet_id!=0)
              {
                items.unshift("<form id='delete' method='post' action='/CakePHP/Tweets/delete_tweet'><button type='button' onclick='delete_tweet()' >DELETE</button></input><input type='hidden' value='"+id+"' name='delete_id'></input></form>");
              }


				              items.unshift(
		                "<div id='tweet_block'>"
		                     +"<div class='profile'><img id='display_image' src='"+use_display_image+"'></div>"+"  "+retweet_status+
		                     "<span id='username" + id+ "'><a href='/CakePHP/Users/usersPage/"+post_username+"'>"+use_name+"@" 
		                     +post_username+"</a></span> <br/>"+
		                   "<span>"+tweet+"</span>"+image_data+"<br/>"+
		                      "<button id='reply' onclick=\"reply_tweet(" + id + ", '" + post_username+"');\">REPLY</button>"
		                     +"<div id='reply"+id+"'></div>"+
		                "</div>"
		              );
              
				    		
			  	}// end if 
			 
			  });//end each		 
			  $("#get_data").html( items.join("") );
			});

});


</script>


<script type="text/javascript">
	
	function reply_tweet(id,username)
{
	$("#reply"+id).html("<br/><form action='/CakePHP/Tweets/reply_tweet' method='post'><br/><textarea name='reply_tweet'>@"+username+"</textarea><br/><input value='Tweet' type='submit'></input><input type='hidden' name='id' value='"+id+"'></input><input type='hidden' name='reply_username' value='"+username+"'></input> </form><br/>");
}

function retweet(username,tweet)
{
  var check = confirm("Retweet this to your follower? \n"+"@"+username+"\n"+tweet_ori);
  if(check===false){
    //e.preventDefault();
    //alert('FALSE');
  }
  else{
    //alert('TRUE');
    $("form#retweet").submit();
  }
       
}

function delete_tweet()
{
  var check = confirm("Are you sure to delete?");
  if(check===false)
  {}
  else{
    $("form#delete").submit();
  }
}
</script>




