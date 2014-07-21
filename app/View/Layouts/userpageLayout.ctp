
<!--this is layuout -->
<?php
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())



?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $this->fetch('title'); ?></title>

<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="/CakePHP/css/woodButton.css" type="text/css" />

<!-- import AJAX -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="http://jquery.offput.ca/js/jquery.timers.js">
  </script>

<style type="text/css">
    @font-face
    {
      font-family: ThaiSans Neue;
      src:url(http://endopasmic.azurewebsites.net/co-op/font/ThaiSansNeue-Light.otf);
    }
	  @import url("/CakePHP/css/960.css") screen and (min-width : 960px);
  
  	  body{
      font-family: ThaiSans Neue;
      padding: 30px 0 0 0;
      font-size: 20pt;
      margin-top: 80px;
      margin-left: 0px;

    }


    
#tweet_block{
  margin-top: 60px;
}
.custom-file-input::-webkit-file-upload-button {
  visibility: hidden;
    width: 126px;
    margin-left: 18%;
}
.custom-file-input::before {

  content: 'Select some files';
  display: inline-block;
  background: -webkit-linear-gradient(top, #f9f9f9, #e3e3e3);
  border: 1px solid #999;
  border-radius: 3px;
  padding: 5px 8px;
  outline: none;
  white-space: nowrap;
  -webkit-user-select: none;
  cursor: pointer;
  text-shadow: 1px 1px #fff;
  font-weight: 700;
  font-size: 10pt;
}
.custom-file-input:hover::before {
  border-color: black;
}
.custom-file-input:active::before {
  background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
}

/*import responsive css*/
@media only screen and (max-width : 960px){
    

    a{
      color: #3BAFDA;
    }
    a:hover
    {
      color:#4FC1E9;
    }
    img
    {
     max-width: 400px;
     max-height: 400px;

    }
    img#display_image
    {
     max-width: 100px;
     max-height: 100px;
    }

    #tweetArea
    {
      margin-left: 22%;
      //background-color: red;
    }
    #reply
    {
      float: left;
      margin-right: 30px;
    }
    #textarea
    {
      font-size: 14pt;
      height: 127px;
      width: 70%;
       display: block;
       font-weight: bold;


      border-radius: 5px;
      box-shadow: inset 0 1px 2px rgba(0,0,0, .55), 0px 1px 1px rgba(255,255,255,.5);
      border: 1px solid #666;
    }
    .timeline
    {
      margin-left: 32%;
    }


    #container_12
    {

        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        -webkit-transform: rotateZ(1deg);
        -o-transform: rotate(1deg);
        transform: rotateZ(1deg);
        z-index: -1;
        left: 10px;
        top: 7px;
    }
    button
    {
        height:45px;
        appearance: none;
        opacity: .99;
        width:120px;
        background: #08c;
        box-shadow: inset 0 1px 2px #4FC1E9, 0px 1px 6px rgba(0,246,255,.5);
        border: 1px solid #0a5378;
        border-radius: 4px;
        color: #eee;
        cursor: pointer;
        text-shadow:0px -1px 0px rgba(0,0,0,.5);
        margin-right: 10px;
    }
    button:hover
    {
           background: #08c;
      width:120px;
      border: 1px solid #0a5378;
      border-radius: 3px;
      box-shadow: inset 0px 3px 16px #4FC1E9,0px 1px 10px rgba(255,255,255,.5),inset 0px -1px 2px rgba(255,255,255,.35);
      text-shadow:0px 1px 1px rgba(0,0,0,.65);
      -webkit-transition: all 0.40s ease-out;
      transition: all 0.40s ease-out;
    }
    input[type=submit]{
             height:45px;
        appearance: none;
        opacity: .99;
        width:120px;
        background: #08c;
        box-shadow: inset 0 1px 2px #4FC1E9, 0px 1px 6px rgba(0,246,255,.5);
        border: 1px solid #0a5378;
        border-radius: 4px;
        color: #eee;
        cursor: pointer;
        text-shadow:0px -1px 0px rgba(0,0,0,.5);
        margin-right: 10px;
    }

    button:active {
        box-shadow: inset 0px 0px 0px 1px rgba(0,0,0,0.2),
                inset 0px -2px 0px 0px rgba(0,0,0,0.3),
              inset 0px 2px 0px 0px rgba(255,255,255,0.5);
        top: 3px;
    }




}

@media only screen and (min-width : 960px) {
 

    a{
      color: #3BAFDA;
    }
    a:hover 
    {
      color:#4FC1E9 !important;;
    }
    img
    {
     max-width: 400px;
     max-height: 400px;

    }
    img#display_image
    {
     max-width: 100px;
     max-height: 100px;
    }

    #tweetArea
    {
      margin-left: 22%;
      //background-color: red;
    }
    #reply
    {
      float: left;
      margin-right: 30px;
    }
    #textarea
    {
      font-size: 14pt;
      height: 127px;
      width: 70%;
       display: block;
       font-weight: bold;


      border-radius: 5px;
      box-shadow: inset 0 1px 2px rgba(0,0,0, .55), 0px 1px 1px rgba(255,255,255,.5);
      border: 1px solid #666;
    }
    .timeline
    {
      margin-left: 32%;
    }


    #container_12
    {

        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        -webkit-transform: rotateZ(1deg);
        -o-transform: rotate(1deg);
        transform: rotateZ(1deg);
        z-index: -1;
        left: 10px;
        top: 7px;
    }
    button
    {
        height:45px;
        appearance: none;
        opacity: .99;
        width:120px;
        background: #08c;
        box-shadow: inset 0 1px 2px #4FC1E9, 0px 1px 6px rgba(0,246,255,.5);
        border: 1px solid #0a5378;
        border-radius: 4px;
        color: #eee;
        cursor: pointer;
        text-shadow:0px -1px 0px rgba(0,0,0,.5);
        margin-right: 10px;
    }
    button:hover
    {
           background: #08c;
      width:120px;
      border: 1px solid #0a5378;
      border-radius: 3px;
      box-shadow: inset 0px 3px 16px #4FC1E9,0px 1px 10px rgba(255,255,255,.5),inset 0px -1px 2px rgba(255,255,255,.35);
      text-shadow:0px 1px 1px rgba(0,0,0,.65);
      -webkit-transition: all 0.40s ease-out;
      transition: all 0.40s ease-out;
    }
    input[type=submit]{
             height:45px;
        appearance: none;
        opacity: .99;
        width:120px;
        background: #08c;
        box-shadow: inset 0 1px 2px #4FC1E9, 0px 1px 6px rgba(0,246,255,.5);
        border: 1px solid #0a5378;
        border-radius: 4px;
        color: #eee;
        cursor: pointer;
        text-shadow:0px -1px 0px rgba(0,0,0,.5);
        margin-right: 10px;
    }

    button:active {
        box-shadow: inset 0px 0px 0px 1px rgba(0,0,0,0.2),
                inset 0px -2px 0px 0px rgba(0,0,0,0.3),
              inset 0px 2px 0px 0px rgba(255,255,255,0.5);
        top: 3px;
    }
    a{
      line-height: 0;
      border-style: none !important;
    }
}
    

</style>
<div class="header">
 <label for="main-nav-check" class="toggle-menu">  
    <img id="header_image" src="/CakePHP/files/Twitter_logo.png" width="70" height="48">
 </label>   
 <label> 
  <a href="/CakePHP/Users/profile">
  <img id="setting" src="/CakePHP/files/setting_logo.png" width="35" height="35">
  </a>
 </label>

</div>


<?php 
// Jsヘルパーが生成するJSを出力させる
echo $this->Js->writeBuffer( array( 'inline' => 'true'));
?>
<!-- Include external files and scripts here (See HTML helper for more info.) -->
<?php
	echo $this->Html->charset();
	echo $this->Html->css('mini.css');
	echo $this->Html->css('header.css');
	echo $this->Html->css('twitterIcon');
	echo $this->Html->css('fileButton');
	echo $this->Html->css('profileImage');
	echo $this->Html->css('toggleMenu');
  echo $this->Html->css('userpage');


	echo $this->Html->script('ajaxupload.js');
	echo $this->Html->script('header.js');



	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
?>

</head>
<body>
<!-- If you'd like some sort of menu to
show up on all of your views, include it here -->
<div id="header">
    <div id="menu"></div>
</div>

<!-- Here's where I want my views to be displayed -->
<?php echo $this->fetch('content'); ?>

<!-- Add a footer to each displayed page -->
<div id="footer"></div>



    <input type="checkbox" class="main-nav-check" id="main-nav-check" checked=checked/> <!--checkbox note: la checkbox est coché par defaut -->
    <nav class="main-nav" id="main-nav">                    <!--NAV-->
      
      <label for="part-nav-check" class="toggle-menu" id="ss_part_toggle">  <!--SYMBOLE OU MOT QUI SERVIRA DE BOUTTON POUR LE SOUS-MENU-->
        Section1
      </label>
      <input type="checkbox" class="part-nav-check" id="part-nav-check" />  <!--checkbox du sous-menu-->

      <div id="other_links">                         
         <?php echo $this->Html->link('Home',array('controller' => 'Tweets','action' => 'getTweet')); ?>
        
        <a href="/CakePHP/Users/usersPage/<?php echo $username; ?>">My Page</a>
           <?php echo $this->Html->link('Profile setting',array('controller' => 'Users','action' => 'profile')); ?> 

       <?php echo $this->Html->link('Logout',array('controller' => 'Tweets','action' => 'logout')); ?>
      </div>
      <div id="effet_ombre"></div>
    </nav>                                    <!--FIN NAV-->
    
    <div class="page-wrap">                           <!--La page-->

</body>


</html>