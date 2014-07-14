
<?php
// This is controller
class TweetsController extends AppController{
	
	//activate html,Form,javascript helper
	public $helpers = array('Html', 'Form', 'Js','Text' );
	public $components = array('RequestHandler','Session');

	//import model
	var $uses = array('Twitter_users','Twitter_post','follow','tag');


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
					/*
					$this->follow->create();
	                $this->follow->save(array(
	                		'username' => $this->request->data['Twitter_users']['Username'],
	                		'follow_user' => $this->request->data['Twitter_users']['Username']
	                	));
	                */

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
	public function twitter_logout()
	{

	}


//////////////////////////////////////////////////////////////////////////////////////////////
    
    //system for register twitter
    public function register() {
    	//set layout
    	$this->layout = ('twitterlayout');
    	$username = $this->Session->read('username');
		$this->set('username',$username);

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
		$json_follow = $this->follow->find('all',array(
				'conditions' => array('follow.username' => $username)
			));
		$json_user =$this->Twitter_users->find('all',array(
					'user_id' => array('user_id')
			));
        $json_tag = $this->tag->find('all');
		
		$this->set(compact("json"));
		$this->set(compact("json_user"));
		$this->set(compact("json_follow"));
        $this->set(compact("json_tag"));
		
		$this->set('_serialize', array('json','json_user','json_follow','json_tag') );//sent json

		if ($this->request->is('post')) 
		 {
		 	return $this->redirect(array('action' => 'tweet'));
		 }
		 //render view	

	}//end post_tweet


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
            $reply_username = $_POST['reply_username'];

			$this->Twitter_post->create();
			$this->Twitter_post->save(array(
				'username' => $username,
				'tweet' => $reply_data,
				'reply_check' => 'TRUE',
				'reply_tweet_id'=> $reply_id,
                'reply_tweet_username' => $reply_username

			));
		}
		$this->render('getTweet');
	}

////////////////////////////////////////////////////////////////////////////////////////////////
	
	//Ajaxになるため最新のツイットをechoして.TweetUpdateにRenderされる
	public function tweetUpdate()
	{
        $this->layout = ('twitterlayout');
		$username = $this->Session->read('username');
		$this->set('username',$username);

        if(is_uploaded_file($_FILES['image']['tmp_name']))
        {
            //input file
            $randomName = intval(rand());
            $filename = '/files/'.$randomName.'.jpg';
            $imagelink=rename($_FILES['image']['tmp_name'],WWW_ROOT.$filename);
            $this->set('filename',$filename);

            $this->Twitter_post->create();
            $this->Twitter_post->save(array(
                'imagelink' => "/CakePHP/app/webroot".$filename,
                'imagetitle' => $randomName
            ));
        }

             //POSTでセーブ
            if($this->request->is('post'))//check this is send by post
            {
                $tweet = $_POST['text'];
                //if this no tag
                if(strpos($tweet,"#")===false)
                {
                    $this->Twitter_post->save(array(
                        'username' => $username,
                        'tweet' =>$tweet,
                        'reply_check' => 'FALSE',
                        'tag_status' => 'FALSE'
                    ));
                }
                //# tag case
                else
                {
                   $tweetSplit = explode(" ",$tweet);
                   $tweetCount = substr_count($tweet, " ");
                    for($i=0;$i<=$tweetCount;$i++)
                    {
                       $tweetFindTag = strpos($tweetSplit[$i],'#');
                        if($tweetFindTag === FALSE)
                        {
                            $this->Twitter_post->save(array(
                                'username' => $username,
                                'tweet' => $tweetSplit[$i],
                                'reply_check' => 'FALSE',
                                'tag_status' => 'TRUE'
                            ));
                        }
                        else if($tweetFindTag==0)
                        {
                            $this->Twitter_post->save(array(
                                'tagname' => substr($tweetSplit[$i],1),
                            ));

                            $this->tag->create();
                            $this->tag->save(array(
                                'username' => $username,
                                'tagname' => substr($tweetSplit[$i],1),
                                'tag_tweet' => $tweet
                            ));


                        }
                    }//end loop
                }


            }

		else
		{

		}
        $this->render('getTweet');
	}

/////////////////////////////////////////////////////////////////////////////////////////////////
    public function FileUpload()
    {
        $this->layout = ('twitterlayout');
        $username = $this->Session->read('username');
        $this->set('username',$username);
       $this->render('getTweet');
    }



//////////////////////////////////////////////////////////////////////////////////////////////////
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

    public function tag($tagName = null)
    {

        //set
        $this->layout = ('twitterlayout');
        $username = $this->Session->read('username');
        $this->set('username',$username);


         $this->set('tagName',$this->tag->findBytagname($tagName));
         $this->set('tagData',$this->tag->find('all',array(
             'conditions' => array('tag.tagname' => $tagName)
         )));

    }


////////////////////////////////////////////////////////////////////////////////////////////////

}// End class


?>



















