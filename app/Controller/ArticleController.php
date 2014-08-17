<?php
//this is controller
class ArticleController extends AppController{
	
	//set layout for all action in this controller
	var $layout = 'seichichanLayout';
	//set helper
	public $helpers = array('Html', 'Form', 'Js','Text' );
	//set object model
	var $uses = array('Location');
	//set JSON
	public $components = array('RequestHandler');
	
	public function index(){
		
		return $this->redirect(
			array('action' => 'home')
		);
	}
	
	public function home(){

	}
	
	public function show(){
		$this->set('LocationData',$this->Location->findByLocationId(10));
		
		$LocationJSON = $this->Location->find('all');
		$this-> set(compact('LocationJSON'));
		$this->set('_serialize',array('LocationJSON'));
	}
	
}


?>