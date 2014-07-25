<!-- this is view -->
<style type="text/css">
	 a:hover 
    {
      color:#4FC1E9 !important;
    }
    .profile_detail
   {
   	margin-left: 27%;
   }

</style>


<div class="container_12">

<div class="profile_detail">


<!--//follow and unfollow button -->
<?php
//自分のページではFollowボタンがない

if($username == $page_data['Twitter_users']['username'] )
{
 //echo "<h4>This is my page</h4>";
/*	
 echo $this->Html->link('profile setting',array(
 		'action' => 'profile'
 		));

	*/
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
<br/><br/>
<img style="width:100%;height:100%;margin-left:0;" class="profile square" src="<?php echo $page_data['Twitter_users']['wall_image'] ?>">

<div><img style="max-width: 100px;max-height: 100px;" src="<?php echo $page_data['Twitter_users']['display_image'] ?>"></div>

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
<h3><?php  echo "@".$page_data['Twitter_users']['username']; ?> page</h3>
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

</div>

<!-- /////////////////////////////////////////////////-->

<!--get tweet by jQuery getJSON -->

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
			  //seperate json in to normal form 

			  	//Twitter_post  
			  	$.each( data.json, function(key,value) {
	
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
			  	
			  	//Twitter_users
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
			  	
			  	//follow
			  	$.each( data.json_follow, function(key,value) {
			  	
			  	var follow_id = value.follow.id;
			  	 follow_byuser = value.follow.follow_user;
			  	 follow_user = value.follow.username;
			  	 follow_status = value.follow.status;
			  	 });	

			  	if("<?php echo $page_data['Twitter_users']['username']; ?>"==post_username)
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
			  $("#get_data").html( items.join("") );
			  
			  if("<?php echo $follow_id['follow']['status']; ?>" == "TRUE")			 
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

function retweet(username,tweet)
{
	//confirm to user before goto ajax
	if(confirm("Retweet this to your follower? \n"+"@"+username+"\n"+tweet)==false)
	{
		
		$("form#retweet").submit(function(){
			$.ajax({
				type: "POST",
				async: false,
				cache: false,
				contentType: false,
				processData: false
			});

			return false;
		});
	
		return;
		
	}
}
</script>

<?php 
if($username == $page_data['Twitter_users']['username'] )
{ 
?>

      <div id="tweetArea">

      <br/><br/>

      <div id="sending-js-submit"></div>
      <div id="result-js-submit"></div>

      <span style="font-size:30pt;"><?php echo "@$username"; ?></span>



      <form id="data" method="post" enctype="multipart/form-data">
        <textarea id='textarea' name="text"></textarea>
        <br/>
        <input class="custom-file-input" style="margin-left: 16%;" type="file" name="image" />
        <br/>
        <button onclick="refresh()" style="margin-left: 23%;">Submit</button>
      </form>
      <br/>

      </div><!-- end tweet area -->




<?php } ?>

<div class="timeline"> <div id="get_data"></div> </div>
<div id="get_data"></div>
<div id="sending-js-submit"></div>
<div id="result-js-submit"></div>


<?php 
if($username == $page_data['Twitter_users']['username'] )
{ 
?>


<?php


/*
<form method='post' action='#'>
<input type='submit' id='follow' onclick='update()' value='test'>
<input type='hidden' name='user_id' value='<?php echo $page_data['Twitter_users']['user_id']; ?>'>
</form>

*/

?>
<!-- ツイートするところ。自分のページしかみえない -->



<script>


function refresh()
{
			//get json file
			$.getJSON( "/CakePHP/Tweets/getTweet.json", function( data ) {
			  var items = [];
			  //seperate json in to normal form 

			  	//Twitter_post  
			  	$.each( data.json, function(key,value) {
	
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
			  	
			  	//Twitter_users
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
			  	
			  	//follow
			  	$.each( data.json_follow, function(key,value) {
			  	
			  	var follow_id = value.follow.id;
			  	 follow_byuser = value.follow.follow_user;
			  	 follow_user = value.follow.username;
			  	 follow_status = value.follow.status;
			  	 });	

			  	if("<?php echo $page_data['Twitter_users']['username']; ?>"==post_username)
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
			  $("#get_data").html( items.join("") );
			  
			  if("<?php echo $follow_id['follow']['status']; ?>" == "TRUE")			 
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
}



</script>
<div class="container_12">

<?php } ?>

<script>

	$("form#data").submit(function(){
		var formData = new FormData ($(this)[0]);

		$.ajax({
			url: "/CakePHP/Tweets/tweetUpdate",
			type: "POST",
			data: formData,
			async: false,
			success: function(data){
				alert("already submit")
			},
			cache: false,
			contentType: false,
			processData: false
		});
       $('textarea').val('');
		return false;

	});

</script>
