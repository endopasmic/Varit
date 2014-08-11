<?php
//this is controller

class LocationController extends AppController{
	//set layout for all action in this controller
	var $layout = 'seichichanLayout';
	//set helper
	public $helpers = array('Html', 'Form', 'Js','Text' );
	//set object model
	var $uses = array('Location');
	
	
	public function index(){
		$this->Model->setDataSource('seichichan');
		$this->redirect(array('action' => 'SaveLocation'));
	}
	
	public function SaveLocation(){

		if($this->request->is('post'))
		{
			$Latitude =$_POST['latitude'];
			$Longitude =$_POST['longitude'];
			
			$this->Location->create();
			$this->Location->save(array(
				'LocationName' => 'TESTLOCATION',
				'LocationMemo' => 'TESTMEMO',
				'Latitude' => $Latitude,
				'Longitude' => $Longitude,
				'CheckinDate' => date('Y-m-d G:i:s')				
			));
			
			$this->Session->setFlash('Already saved map');
			
			$this->redirect(array(
					'controller' => 'Article',
					'action' => 'home'
			));
		}
			
	}
}


?>