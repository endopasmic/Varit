
<h1>Main Page</h1>
<script type="text/javascript">
//load json 
var username;
var use_user_id;
var user_regis;
$(document).ready(function(){

			//get json file
			$.getJSON( "/CakePHP/Tweets/getTweet.json", function( data ) {
			  var items = [];
			  //seperate json in to normal form 

			  	$.each( data.json, function(key,value) {
			  	//sperated json into value 
			  	username = value.Twitter_post.username;			  	
			  	id = value.Twitter_post.id;
			  	var tweet = value.Twitter_post.tweet;
			  	console.log(username);

			  	$.each( data.json_user, function(key,value) {
			  	
			  	var user_id = value.Twitter_users.user_id;
			  	user_regis = value.Twitter_users.username; 
			  	if(user_regis==username)
			  	 {use_user_id=user_id;}

			 	 });
			    items.push(
			    			"<div>"
			    				   +"  "+
			    				   "<span id='username" + id+ "'><a href='/CakePHP/Users/usersPage/"+use_user_id+"'>@" 
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
			  //seperate json in to normal form 
			  $.each( data.json, function(key,value) {
			  	//sperated json into value 
			  	username = value.Twitter_post.username;
			  	id = value.Twitter_post.id;
			  	var tweet = value.Twitter_post.tweet;
			  	console.log(username);

			  	$.each( data.json_user, function(key,value) {			  	
			  	var user_id = value.Twitter_users.user_id;
			  	user_regis = value.Twitter_users.username; 
			  	if(user_regis==username)
			  	 {use_user_id=user_id;}

			 	 });

			    items.push(
			    			"<div>"
			    				   +"  "+
			    				   "<span id='username" + id+ "'><a href='/CakePHP/Users/usersPage/"+use_user_id+"'>@" 
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

	'url' => '/Tweets/js_submit_form',    
    'update' => '#result-js-submit',
    'id' => 'submit'
  
	)); 
	echo $this->Form->end();

	echo $this->Html->link($this->Form->button('Logout'), 
							array('action' => 'index'), 
							array('escape'=>false,'title' => "Click to logout")
						   );//create link button

?>


