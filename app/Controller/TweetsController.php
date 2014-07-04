
<?php
// This is controller
class TweetsController extends AppController{
	
	//activate html,Form,javascript helper
	public $helppers = array('Html', 'Form', 'Js' );
	public $components = array('RequestHandler');
	//import model
	var $uses = array('Twitter_users','Twitter_post','follow');


//////////////////////////////////////////////////////////////////////////////////////////////
	//Welcome page no system
	public function index(){
			//何もない
	}
	public function user_page($id = null){

		$this->set('user_id',$this->Twitter_users->findById($id));
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
	//Twitter Login system
	public function twitter_login(){
		//set 
		$this->layout = ('twitterlayout');
		$this->set('user_data', $this->Twitter_users->find('all'));

		//Count DB
		$rows = $this->Twitter_users->find('count');
		$data =	$this->Twitter_users->find('all');

		//if form go post
		if($this->request->is('post'))
		{
			$user = $this->Twitter_users->find( 'all', array(
				'Username' => $this->request->data['Twitter_users']['Username'],
				'Password' => $this->request->data['Twitter_users']['password']
				));

			$username= $this->request->data['Twitter_users']['Username'];
			$password= $this->request->data['Twitter_users']['password'];

			$this->Session->write('username', $username);
			for($i=0;$i<=$rows;$i++)
			{
				//echo $user[$i]['Twitter']['username'];
				echo "</br>";
				//if username in POST and DB are MATCH goto main
				if($user[$i]['Twitter_users']['username']==$username&&
				   $user[$i]['Twitter_users']['password']==$password)
				{
					return $this->redirect(array('action' => 'getTweet'));
				}
				else
				{
					echo "Username or Password incorrect";
				}
			}
    	}
	}//end .twitter_login

//////////////////////////////////////////////////////////////////////////////////////////////
    
    //system for register twitter
    public function register() {
    	//set layout
    	$this->layout = ('twitterlayout');

        if($this->request->is('post')) 
        {
        	var_dump($this->request->data);//var_dump will show the type of value
            $this->Twitter_users->create();
            //var_dump($this->Twitter);
            if ($this->Twitter_users->save($this->request->data) ) {
                $this->Session->setFlash(__('Your post has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Unable to add your post.'));
            debug($this->Twitter_users->validationErrors);
        }
    }//end .register

/////////////////////////////////////////////////////////////////////////////////////////////

    //system for get form DB change to json decode and show in view
	public function getTweet()
	{
		//set
		$this->layout = ('twitterlayout');
		$username = $this->Session->read('username');
		$this->set('username',$username);
		
		//set json
		$json = $this->Twitter_post->find('all');
		$json_user =$this->Twitter_users->find('all',array(
					'user_id' => array('user_id')
			));	
		$this->set(compact("json",'json_user'));
		$this->set(compact("json_user"));
		$this->set('_serialize', array('json','json_user') );


		if ($this->request->is('post')) 
		 {
		 	return $this->redirect(array('action' => 'tweet'));
		 }
		 //render view	
		 $this->render('getTweet');
	}//end post_tweet

//////////////////////////////////////////////////////////////////////////////////////////////////

	 //最新のツイットをとって保存する
	public function tweetUpdate()
	{
		//set
		$this->layout = ('twitterlayout');
		$username = $this->Session->read('username');
		$this->set('username',$username);
		$tweet_detail = $this->data['Twitter_post']['tweet_detail'];
		$this->redirect(array('action' => 'getTweet'));
		//render view	
		$this->render('/js_submit_form');
		
	}//end tweet
//////////////////////////////////////////////////////////////////////////////////////////////////

	//リプライデータを登録する
	public function reply_tweet()
	{
		$this->layout = ('twitterlayout');
		$username = $this->Session->read('username');
		$this->set('username',$username);
		$this->set('reply_user', $this->Twitter_post->find('all'));
		
		if($this->request->is('post'))
		{
			//reply_dataはPOSTで得たのreplyデータ
			$reply_data=$_POST['reply_tweet'];
			$reply_id = $_POST['id'];

			$this->Twitter_post->create();
			$this->Twitter_post->save(array(
				'username' => $username,
				'tweet' => $reply_data,
				'reply_check' => 'TRUE',
				'reply_tweet_id'=> $reply_id

			));
		}
		$this->render('getTweet');
	}

////////////////////////////////////////////////////////////////////////////////////////////////
	
	//Ajaxになるため最新のツイットをechoして.TweetUpdateにRenderされる
	public function js_submit_form()
	{
		$username = $this->Session->read('username');
		$this->set('username',$username);

		//POSTでセーブ
		if($this->request->is('post'))
		{
			$this->Twitter_post->create();
			$this->Twitter_post->save(array(
				'username' => $username,
				'tweet' => $this->request->data['Twitter_post']['tweet_detail'],
				'reply_check' => 'FLASE'

				));		
		}
		else
		{
			$this->Js->each('alert("登録失敗");', true);	
		}
	}

/////////////////////////////////////////////////////////////////////////////////////////////////
	public function delete_tweet()
	{
		$this->layout = ('twitterlayout');
		$username = $this->Session->read('username');
		$this->set('username',$username);
		if($this->request->is('post'))
		{
			$delete_id = $_POST['delete_id'];

			if($this->Twitter_post->delete($delete_id))
			{
				 echo "<script>alert('Delete complete')</script>";
				 
			}
			else
			{
				echo "<script>alert('Delete Error')</script>";

			}
			//return $this->redirect(array('action' => 'getTweet'));	
		}
		$this->render('getTweet');
	}
/////////////////////////////////////////////////////////////////////////////////////////////////

}// End class

/*
	public function tweetUpdate(){
		$this->layout = ('twitterlayout');
		$username = $this->Session->read('username');
		$this->set('username',$username);
		$Twitter_post = $this->data['Twitter_post']['tweet_detail'];

		$this->Twitter->create();
		$this->Twitter_post->save($this->request->data,array(
			'username' => $username,
			'tweet' => $Twitter_post
			));
		{
			$this->render('/js_submit_form');
		}
	}//end tweet


		$this->layout = ('twitterlayout');

		$username = $this->Session->read('username');
		$this->set('username',$username);

		if($this->request->is('post'))
		{
			$this->Twitter_post->create();
			//var_dump($this->request->data);//var_dump will show the type of value
			$this->Twitter_post->save(array(
			    'tweet' => $this->request->data['Twitter_post']['tweet'],
			    'username'=> $username
			));
		}

		$this->render('getTweet');
*/
?>

