<?php
//this is controller
class LocationController extends AppController{
	
	public function index(){
		$this->redirect(array('action' => 'SaveLocation'));
	}
	
	public function SaveLocation(){
		$this->layout = ('seichichanLayout');
	}
}


?>