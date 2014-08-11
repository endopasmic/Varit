<?php
//this is controller

class ArticleController extends AppController{
	
	public $helpers = array('Html', 'Form', 'Js','Text' );
	
	public function index(){
		
		return $this->redirect(
			array('action' => 'home')
		);
	}
	
	public function home(){

	}
	
}


?>