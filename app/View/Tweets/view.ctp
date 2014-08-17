<?php

echo $this->fetch('title');
echo $this->fetch('content');

?>

<div class="action">
	<h3>Related action</h3>
	<ul>
	<?php echo $this->fetch('sidebar') ?>
	</ul>
</div>