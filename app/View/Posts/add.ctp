<!-- File: /app/View/Posts/add.ctp -->

<h1>Add Post</h1>
<?php
echo $this->Form->create('Post');// create form POST method
echo $this->Form->input('title');// create textfeild 
echo $this->Form->input('body', array('rows' => '3'));// create textarea
echo $this->Form->end('Save Post');// end the form and generate button name Save Post
?>