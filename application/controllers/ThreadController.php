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
        $userId = 1;
     
           
       if($this->_request->isGet()) {
           
           $id = $this->_request->getParam('id'); //getParam search in user params first
           if (!empty($id)){
           
                $thread  = new Application_Model_Thread();
                $replies = new Application_Model_Reply;
                $users = new Application_Model_User;
                //$addReply = new Application_Form_Reply;      

                $result = $thread->getThreadById($id);
                $reps = $replies->getReplies($id);
                $this->view->thread = $result[0];
                $this->view->replies = $reps;
                $this->view->id = $id;


                $replyUsers = array();
                foreach ($reps as $reply){
                    //echo $reply['user_id']."pppp";
                    $user = $users->getUserById($reply['user_id'])[0];
                    $replyUsers[] = array ($user['id'] , $user['username'] , $user['signature']);
                 }

                $this->view->users = $replyUsers;
                //$this->view->addReply = $addReply;
           }
           
       
            else{

                $this->redirect('/thread/error');


            }
       }
    }
    
    
    
    
}


