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

/////////////////////////////////////////////////////////////////////////////////////////////////
    //Twitter Login system
    public function twitter_login(){

        //set
        $this->layout = ('loginLayout');
        $this->set('user_data', $this->Twitter_users->find('all'));

        //Count DB
        $rows = $this->Twitter_users->find('count');
        $data =	$this->Twitter_users->find('all');

        //if form go post
        if($this->request->is('post'))
        {
            $this->follow->create();
            $this->follow->save(array(
                'username' => $this->request->data['Twitter_users']['Username'],
                'follow_user' => $this->request->data['Twitter_users']['Username']
            ));

            $user = $this->Twitter_users->find( 'all');

            $username= $this->request->data['Twitter_users']['Username'];
            $password= $this->request->data['Twitter_users']['password'];

            $this->Session->write('username', $username);


            for($i=0;$i<$rows;$i++)
            {
                //echo $user[$i]['Twitter']['username'];
                echo "</br>";
                //if username in POST and DB are MATCH goto Twitter_login
                if($user[$i]['Twitter_users']['username']==$username&&
                    $user[$i]['Twitter_users']['password']==$password)
                {
                    return $this->redirect(array(
                            'controller' => 'Tweets',
                            'action' => 'getTweet'
                        ));
                }
                else if($user[$i]['Twitter_users']['username']!=$username&&
                    $user[$i]['Twitter_users']['password']!=$password)
                {
                    $this->Session->setFlash('Username or password is are incorrect');

                }
            }
        }
    }//end .twitter_login

//////////////////////////////////////////////////////////////////////////////////////////////

    public function logout()
    {
        $this->follow->deleteALL(array(
            'follow.status' => ""
        ));

        return $this->redirect(array('action' => 'twitter_login'));

    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //system for register twitter
    public function register() {
        //set layout
        $this->layout = ('loginLayout');
        $randomName = intval(rand());

        if($this->request->is('post'))
        {
            if($this->request->data['Twitter_users']['username'] == ""
                ||$this->request->data['Twitter_users']['password'] == ""
                ||$this->request->data['Twitter_users']['name'] == ""
                ||$this->request->data['Twitter_users']['email'] == "")
            {
                $this->Session->setFlash('Every field must not empty ');
                $this->redirect(array('action' => 'register'));
            }


            if($_FILES['display_image']['error'] || $_FILES['wall_image']['error'])
            {
                $this->Session->setFlash('Please upload image files');
                $this->redirect(array('action' => 'register'));
            }


            //var_dump($this->request->data);//var_dump will show the type of value
            $this->Twitter_users->create();
            //var_dump($this->Twitter);

            $username = $this->request->data['Twitter_users']['username'];
            //save image
            $display_filename = '/files/'.$username.'_display.jpg';
            $imagelink=rename($_FILES['display_image']['tmp_name'],WWW_ROOT.$display_filename);

            $wall_filename = '/files/'.$username.'_wall.jpg';
            $imagelink=rename($_FILES['wall_image']['tmp_name'],WWW_ROOT.$wall_filename);

            //save data to DB
            $this->Twitter_users->save($this->request->data);
            $this->Twitter_users->save(array(
                'display_image' => "/CakePHP/app/webroot".$display_filename,
                'wall_image' => "/CakePHP/app/webroot".$wall_filename
            ));

            return $this->redirect(array('action' => 'twitter_login'));
        }


    }//end .register


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

            /*
            if(!is_uploaded_file($_FILES['display_image']) || !is_uploaded_file($_FILES['wall_image'])  )
            {
                $this->Session->setFlash('Please upload image files');
                $this->redirect(array('action' => 'profile'));
            }
            */

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


