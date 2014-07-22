<!-- this is view -->


<?php echo $this->Session->flash(); ?>

<style type="text/css">
      a:hover 
    {
      color:#4FC1E9 !important;;
    }




</style>

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
			    				 "<span><a href='"+reply_tweet_username+"'>"+tweet+"</a></span>"+image_data+"<br/><a href='tag/"+tagLink+"'>"+tag_name+"</a><br/>"+
			    				    "<button id='reply' onclick=\"reply_tweet(" + id + ", '" + post_username+"');\">REPLY</button>"
			    				   +"<div id='reply"+id+"'></div>"+
			    			"</div>"
			    		);
			    		
				}
				});		
			  });//end each		 
			  $("#get_data").html( items.join(""));
			});
});

function update()
{
  $('#text').val(" ");

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
                   "<span><a href='"+reply_tweet_username+"'>"+tweet+"</a></span>"+image_data+"<br/><a href='tag/"+tagLink+"'>"+tag_name+"</a><br/>"+
                      "<button id='reply' onclick=\"reply_tweet(" + id + ", '" + post_username+"');\">REPLY</button>"
                     +"<div id='reply"+id+"'></div>"+
                "</div>"
              );
  
        }
        });   
        });//end each    
        $("#get_data").html( items.join(""));
      });
}


function reply_tweet(id,username)
{
	$("#reply"+id).html("<br/><form action='/CakePHP/Tweets/reply_tweet' method='post'><br/><textarea name='reply_tweet'>@"+username+"</textarea><br/><input value='Tweet' type='submit'></input><input type='hidden' name='id' value='"+id+"'></input><input type='hidden' name='reply_username' value='"+username+"'></input> </form><br/>");
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


<div class="container_12 ">

      <div id="tweetArea">

      <br/><br/>

      <div id="sending-js-submit"></div>
      <div id="result-js-submit"></div>

      <span style="font-size:30pt;"><?php echo "@$username"; ?></span>

      <form id="data" method="post" enctype="multipart/form-data">
        <textarea id='textarea'  name="text"></textarea>
        <br/>
        <input class="custom-file-input" style="margin-left: 16%;" type="file" name="image" id="image" />
        <br/>
        <button onclick="update()" style="margin-left: 23%;">Submit</button>
      </form>
      <br/>

      </div><!-- end tweet area -->
<div class="timeline"> <div id="get_data"></div> </div>
</div><!-- end container 12  -->

<?php
/*
echo $this->Html->link($this->Form->button('Logout'), 
                            array('action' => 'logout'), 
                            array('escape'=>false,'title' => "Click to logout")
                           );//create link button
*/
?>

<script>

	$("form#data").submit(function(){
		var formData = new FormData ($(this)[0]);

		$.ajax({
			url: "/CakePHP/Tweets/tweetUpdate",
			type: "POST",
			data: formData,
			async: false,
			success: function(data){
         update();	
         		$('form#data').each(function(){
                  this.reset();
              });
			},
			cache: false,
			contentType: false,
			processData: false
		});
      
		return false;

	});

</script>


