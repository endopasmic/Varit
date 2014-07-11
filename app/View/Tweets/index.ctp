Welcome to Twitter 

<?php echo $this->Html->link('Please login', array('action' => 'twitter_login')) ?>


<br/><br/><br/><br/><br/>
<?php


$sampleText = "Hello #worldsdsdf #dd sdf  sss   sdfsdffo   sdfsd fdsf  ching";
$sampleSprilt = explode(" ", $sampleText);
$countSpace = substr_count($sampleText, ' ');

$tagPoint = strpos($sampleSprilt[0],'#');

for($i=0;$i<=$countSpace;$i++)
{

$findtag = strpos($sampleSprilt[$i], '#');

	if($findtag===FALSE)
	{
		echo "<br/>This is not tag";
		echo $sampleSprilt[$i];
	}
	else if($findtag==0)
	{
		
		echo "<br/>this is tag";
		echo $sampleSprilt[$i];
	}


}
echo "<br/><br/><br/><br/><br/>";

//echo $countSpace; 
//echo $findtag = strpos($sampleText, '#');

//echo $tagPoint;


?> 