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
	public function usersPage($user_id = null)
	{
		//set layout,username
		$this->layout = ('twitterlayout');
		$username = $this->Session->read('username');
		$this->set('username',$username);
		//setdata
		$this->set('page_data',$this->Twitter_users->findByuser_id($user_id));
		$this->set('page_id',$user_id);

		//set json
		$json = $this->Twitter_post->find(array(
				'condition' => array('Twitter_post.username' => $username)
			));
		$this->set(compact("json",'json_user'));
		$this->set('_serialize', array('json') );


		if ($this->request->is('post')) 
		 {
		 	return $this->redirect(array('action' => 'tweet'));
		 }

	}

///////////////////////////////////////////////////////////////////////////////////////////////

	//this is follow system 
	public function follow()
	{
		$this->layout = ('twitterlayout');
		//POSTでセーブ

		$user_id=$_POST['user_id'];
			$this->follow->create();
			$this->follow->save(array(
				'follow_user' => $user_id
				));
			//echo "<script>alert('登録成功');</script>";		

		


	
	}

////////////////////////////////////////////////////////////////////////////////////////////////

	//this is unfollow system
	public function unfollow()
	{

	}

/////////////////////////////////////////////////////////////////////////////////////////////////	
}// end class

?>