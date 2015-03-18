<?php

class ThreadController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function showthreadAction()
    {
       
        
        
        
        
        echo "here";
       if($this->_request->isGet()){
           $thread  = new Application_Model_Thread();
           $replies = new Application_Model_Reply;
           $users = new Application_Model_User;
           $addReply = new Application_Form_Reply;
           
           
           $id = $this->_request->getParam('id'); //getParam search in user params first
           echo $id;
           $result = $thread->getThreadById($id);
           $reps = $replies->getReplies($id);
           $this->view->thread = $result[0];
           $this->view->replies = $reps;
           
           $replyUsers = array();
           foreach ($reps as $reply){
               echo $reply['user_id']."pppp";
               $user = $users->getUserById($reply['user_id'])[0];
               $replyUsers[] = array ($user['id'] , $user['username'] , $user['signature']);
            }
                      
          
           
           $this->view->users = $replyUsers;
           $this->view->addReply = $addReply;
           

           
           
           
           
       }
       else{
           
       
       }

    }
}



