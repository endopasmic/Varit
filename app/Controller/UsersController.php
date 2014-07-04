<?php
//This is controller
class UsersController extends AppController{

	//Cakephp ヘルパーをActivateする
	public $helppers = array('Html','Form','Js');
	//Prepare for AJAX
	public $components = array('RequestHandler');
	//import model
	var $uses = array('Twitter_users','Twitter_post','follow');

	public function index()
	{
     
	}

//////////////////////////////////////////////////////////////////////////////////////////////

	//this is userpage system create page by user_id and send user data to view
	public function usersPage($pageuser= null)
	{
		//set layout,username
		$this->layout = ('twitterlayout');
		$username = $this->Session->read('username');
		$this->set('username',$username);

		//setdata
		$this->set('page_data',$this->Twitter_users->findByusername($pageuser));
		$this->set('follow_id',$this->follow->findByid($pageuser));


	}

///////////////////////////////////////////////////////////////////////////////////////////////

	//this is follow system 
	public function follow()
	{
		$this->layout = ('twitterlayout');
		$username = $this->Session->read('username');
		$this->set('username',$username);

			if($user=$_POST['username'])
			{	
				$this->follow->create();
				$this->follow->save(array(
					'username' => $username,
					'follow_user' => $user,
					'status' => 'TRUE'
					));
			}

			//unfollow
			else if($user=$_POST['unfollow'])
			{
					$this->follow->deleteAll(array(
						'follow.follow_user' => $user
					));
			}
	}

////////////////////////////////////////////////////////////////////////////////////////////////

	//this is unfollow system
	public function unfollow()
	{
	$this->follow->deleteAll(array(
						'follow.username' => 'endopasmic'
					));
	}

/////////////////////////////////////////////////////////////////////////////////////////////////	
}// end class

?>