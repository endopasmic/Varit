<h1>Main Page</h1>
<script type="text/javascript">
//load AJAX
$(document).ready(function(){
	function startRefresh(){
			//get json file
			$.getJSON( "/CakePHP/twitter/main.json", function( data ) {
				//console.dir(data.json);
			  var items = [];
			  //seperate json in to normal form 
			  $.each( data.json, function(key,value) {

			  	//sperated json into value 
			  	var username = value.Twitter_post.username;
			  	var id = value.Twitter_post.id;
			  	var tweet = value.Twitter_post.tweet;

			    items.push(
			    			"<div>"
			    				   +id+"  "
			    				   +username+"  said: "
			    				   +tweet+"<br/>"+
			    				   
			    			"</div>"
			    		);
			    if(username=="<?php echo $username ?>")
			    {
			    	items.push(
			    		"<a href='/CakePHP/twitter/main?id="+id+"'"+">DELETE</a>"
			    		);
			    }
			    else if(username!="<?php $username ?>")
			    {
			    	items.push("REPLY");
			    }

			  });//end each		 
			  $("#display").html( items.join("") );

			});
setTimeout(startRefresh, 1000);
}
startRefresh();
update();
});

//for tweet update
function update()
{
	var message = $("#Twitter_postTweet").val();
	console.log(message);
	var user_id = 1;
	//if message is null
	if($.trim($("#Twitter_postTweet").val())=='' )
	{
		//$("#update").html('<font color=red>何か書いてよ</font>');
		return false;
	}

}
</script>

<u>This message will show </u>
<br/>
<div id="display"></div>
<div id="update"></div>

<br/>
<?php echo "@$username"; ?>


<?php
	//create form will save to Twitter_post database
		
	echo $this->Form->create('Twitter_post');
	echo $this->Form->input('tweet',array(
									'rows' => '3',
									'label' => false));
	echo $this->Form->end('Tweet');

	echo $this->Html->link($this->Form->button('Logput'), 
							array('action' => 'index'), 
							array('escape'=>false,'title' => "Click to logout")
						   );//create link button

?>

