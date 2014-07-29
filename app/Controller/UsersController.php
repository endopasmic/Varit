<?php
//This is controller
class UsersController extends AppController{

	//Cakephp ヘルパーをActivateする
	public $helppers = array('Html','Form','Js');
	//Prepare for AJAX
	public $components = array('RequestHandler');
	//import model
	var $uses = array('Twitter_users','Twitter_post','follow','tag');

	public function index()
	{
     
	}

//////////////////////////////////////////////////////////////////////////////////////////////

	//this is userpage system create page by user_id and send user data to view
	public function usersPage($pageuser= null,$userImage = null)
	{
		//set layout,username
		$this->layout = ('userpageLayout');
		$username = $this->Session->read('username');
		$this->set('username',$username);

		//setdata
		$this->set('page_data',$this->Twitter_users->findByusername($pageuser));
		$this->set('follow_id',$this->follow->findByfollow_user($pageuser));

        //if click button render to following or follower
        if(isset($_POST['following']))
        {
            $this->layout = ('followLayout');

            $this->set('following_data',$this->follow->find('all'));
            $this->set('user_data',$this->Twitter_users->find('all'));
            $this->render('following');
        }
        if(isset($_POST['follower']))
        {
            $this->layout = ('followLayout');

            $this->set('follower_data',$this->follow->find('all'));
            $this->set('user_data',$this->Twitter_users->find('all'));
            $this->render('follower');
        }

        //if click image link goto status view
        if($pageuser && $userImage != null)
        {
            $this->set('status_data',$this->Twitter_post->findByimagetitle($userImage));
            $status_data = $this->Twitter_post->findByimagetitle($userImage);
            $this->set('user_data',$this->Twitter_users->findByusername($status_data['Twitter_post']['username']));

            $this->render('status');
        }

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
///////////////////////////////////////////////////////////////////////////////////////////////////////

    public function profile()
    {
        $this->layout = ('twitterlayout');
        $username = $this->Session->read('username');
        $this->set('username',$username);

        $this->set('user_data',$this->Twitter_users->findByusername($username));
        $user_data = $this->Twitter_users->findByusername($username);

        if($this->request->is('post'))
        {
            if($this->request->data['Twitter_users']['username'] == ""
                ||$this->request->data['Twitter_users']['password'] == ""
                ||$this->request->data['Twitter_users']['name'] == ""
                ||$this->request->data['Twitter_users']['email'] == "")
            {
                $this->Session->setFlash('Every field must not empty ');
                $this->redirect(array('action' => 'profile'));
            }

            if(!is_uploaded_file($_FILES['display_image']) || !is_uploaded_file($_FILES['wall_image'])  )
            {
                $this->Session->setFlash('Please upload image files');
                $this->redirect(array('action' => 'profile'));
            }

            $new_username = $this->request->data['Twitter_users']['username'];
            //update text data
            $this->Twitter_users->id = $user_data['Twitter_users']['id'];
            $this->Twitter_users->save($this->request->data);

            if($_FILES['display_image'] || $_FILES['wall_image'])
            {
                error_reporting(0);

                //update image
                $display_filename = '/files/'.$new_username.'_display.jpg';
                $imagelink=rename($_FILES['display_image']['tmp_name'],WWW_ROOT.$display_filename);

                $wall_filename = '/files/'.$new_username.'_wall.jpg';
                $imagelink=rename($_FILES['wall_image']['tmp_name'],WWW_ROOT.$wall_filename);

            }


            $feilds = array(
                'username' => "'$new_username'"
            );
            $conditions = array(
                'username' => "$username"
            );

            $this->follow->updateAll(
                array('follow_user' => "'$new_username'"),
                array('follow_user' => "$username")
            );
            $this->follow->updateAll(
                array('username' => "'$new_username'"),
                array('username' => "$username")
            );
            $this->Twitter_post->updateAll($feilds, $conditions);
            $this->tag->updateAll($feilds, $conditions);



            $this->Session->write('username', $new_username);
        }

    }

}// end class
