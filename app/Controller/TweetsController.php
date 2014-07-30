
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
				//if username in POST and DB are MATCH goto main
				if($user[$i]['Twitter_users']['username']==$username&&
				   $user[$i]['Twitter_users']['password']==$password)
				{
					return $this->redirect(array('action' => 'getTweet'));
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

//////////////////////////////////////////////////////////////////////////////////////////////
    
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

            if(!is_uploaded_file($_FILES['display_image']) || !is_uploaded_file($_FILES['wall_image'])  )
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

        //if session = null

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
            $tweet = $_POST['reply_tweet'];

            //if this is no tag
            if(strpos($tweet,"#")===false)
            {
                $this->Twitter_post->create();
                $this->Twitter_post->save(array(
                    'username' => $username,
                    'tweet' => $reply_data,
                    'reply_check' => 'TRUE',
                    'reply_tweet_id'=> $reply_id,
                    'reply_tweet_username' => $reply_username,
                    'tag_status' => 'FALSE'

                ));
            }
            //tag case
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
		$this->render('getTweet');
	}

////////////////////////////////////////////////////////////////////////////////////////////////

    public function retweet()
    {
        $this->layout = ('twitterlayout');
        $username = $this->Session->read('username');
        $this->set('username',$username);

        if($_POST['retweet_id'] != 0 )
        {
            $retweet_id = $_POST['retweet_id'];
            $retweet_username = $_POST['retweet_username'];
            $retweet_tweet = $_POST['tweet'];
            $retweet_imagelink = $_POST['imagelink'];
            //just for debug
            echo var_dump($_POST['retweet_username']);
            echo var_dump($_POST['retweet_id']);
            echo var_dump($_POST['tweet']);

            $this->Twitter_post->create();
            $this->Twitter_post->save(array(
                'username' => $username,
                'reply_check' => 'FALSE',
                'tag_status' => 'FALSE',
                'retweet_id' => $retweet_id,
                'retweet_username' => $retweet_username,
                'tweet' => $retweet_tweet,
                'imagelink' => $retweet_imagelink

            ));
        }
        $this->redirect(array('action' => 'getTweet'));
    }
////////////////////////////////////////////////////////////////////////////////////////////////
	
	//Ajaxになるため最新のツイットをechoして.TweetUpdateにRenderされる
	public function tweetUpdate()
	{
        $this->layout = ('twitterlayout');
		$username = $this->Session->read('username');
		$this->set('username',$username);

        //input file case
        if(is_uploaded_file($_FILES['image']['tmp_name']))
        {
            //input file
            $randomName = md5(intval(rand()));
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
             if($tweet=="" && !is_uploaded_file($_FILES['image']['tmp_name']))
             { $this->Session->setFlash('<script>alert("ツイート内容を入力してください")</script>');}
             else
             {
                //if this no tag
                if(strpos($tweet,"#")===false)
                {
                    $this->Twitter_post->save(array(
                        'username' => $username,
                        'tweet' =>$tweet,
                        'reply_check' => 'FALSE',
                        'tag_status' => 'FALSE',
                    ));
                }
                //# tag case

                else
                {
                    $this->Twitter_post->save(array(
                        'username' => $username,
                        'tweet' => $tweet,
                        'reply_check' => 'FALSE',
                        'tag_status' => 'TRUE'
                    ));

                    $tweetSplit = explode(" ",$tweet);
                    $tweetCount = substr_count($tweet, " ");
                    for($i=0;$i<=$tweetCount;$i++)
                    {
                        $tweetFindTag = strpos($tweetSplit[$i],'#');

                        if($tweetFindTag === FALSE)
                        {

                        }
                        else if($tweetFindTag==0)
                        {

                            $this->Twitter_post->save(array(
                                'tagname' => substr($tweetSplit[$i],1),
                            ));

                            $tweet_id =  $this->Twitter_post->getLastInsertId();

                            $this->tag->create();
                            $this->tag->save(array(
                                'username' => $username,
                                'tagname' => substr($tweetSplit[$i],1),
                                'tag_tweet' => $tweet,
                                'tweet_id' =>   $tweet_id
                            ));


                        }
                    }//end loop
                }//end else
             }
            }// end if

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

        // unlink($_SERVER['DOCUMENT_ROOT']."/CakePHP/app/webroot/files/673b0a8f69f725746a7855824c7da178.jpg");
		if($this->request->is('post'))
		{
			$delete_id = $_POST['delete_id'];

            $delete_data = $this->Twitter_post->findByid($delete_id);
            $tag_id = $this->tag->findBytweet_id($delete_id);


             //if will delete tweet text
            if($this->Twitter_post->delete($delete_id))
			{
                //this is for delete image
                unlink($_SERVER['DOCUMENT_ROOT']."/CakePHP/app/webroot/files/".$delete_data['Twitter_post']['imagetitle'].".jpg");

                //check tag
                if(isset($tag_id['tag']['id']) === true)
                {
                    $this->tag->delete($tag_id['tag']['id']);
                }
                else if( isset($tag_id['tag']['id']))
                {

                }


                //$this->Session->setFlash('<script>alert("Delete Complete")</script>');
                $this->redirect(array('action' => 'getTweet'));
				 
			}
			else
			{
                $this->Session->setFlash('<script>alert("Delete Error")</script>');
                $this->redirect(array('action' => 'getTweet'));
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



















