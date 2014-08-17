<!-- this is view -->

<h1>upload test</h1>
<?php echo $this->Form->create('FileUpload',array('name'=>'uploadForm','id'=>'uploadForm','type'=>'file'));?>
<?php echo $this->Form->input('upload_file',array('label'=>'Upload Text File ','type'=>'file'));?>
<?php echo $this->Form->button('アップロード',array
    ('onClick'=>'$("#uploadForm").ajaxSubmit({target: "#uploadFile",url: "/users/upload"}); return false;'));

echo $this->Form->end();
?>

<div id="uploadFile"></div>