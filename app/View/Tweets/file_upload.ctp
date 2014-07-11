<?php
    echo $this->Form->create('Tweet',array('action' => 'FileUpload', 'type' => 'file')).PHP_EOL;
 
    echo $this->Form->input(false,array(
        'type' => 'file',
        'label' => '画像選択',
    )).PHP_EOL;
 
    echo $this->Form->input('fileName', array(
        'type' => 'text',
        'label' => '画像名',
        'required' => true,
        )).PHP_EOL;
 
    echo $this->Form->submit('upload',array('id' => 'img')).PHP_EOL;
    echo $this->Form->end().PHP_EOL;
?>