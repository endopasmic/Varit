<h1>This is Tag page</h1>

Tag Name is
<?php

echo $tagName['tag']['tagname'];

?>
<hr/>

<?php

echo $tagName['tag']['tagname']."<br/>";

	foreach ($tagData as $tagData)
	{
		echo $tagData['tag']['username']."  ".$tagData['tag']['tag_tweet']."<br/>";
	} 


?>