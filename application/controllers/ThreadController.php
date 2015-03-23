<?php

class ThreadController extends Zend_Controller_Action
{

    public function init()
    {
         
        /* Initialize action controller here */
    }
    
   /* protected function javascriptHelper($caller){
    $request = Zend_Controller_Front::getInstance()->getRequest();
         $file_uri = 'media/js/' . $request->getControllerName() . '/' . $request->getActionName() . '.js';
  echo "ckd";
        if (file_exists($file_uri)) {
            echo "ooooooooooook";
            $viewName= $request->getActionName();
            $view = $this->load->view($viewName);
            //$view->headScript()->appendFile('/' . $file_uri);
        
        }
    }
    */
   
    public function indexAction()
    {
        // action body
    }

    public function showthreadAction()
    {     
       
       $front = Zend_Controller_Front::getInstance();
       $bootstrap = $front->getParam("bootstrap");
            
       
       if($this->_request->isGet()) {
           
           $id = $this->_request->getParam('id'); //getParam search in user params first
           if (!empty($id)){
           
                $thread  = new Application_Model_Thread();
                $replies = new Application_Model_Reply;
                $users = new Application_Model_User;

                $result = $thread->getThreadById($id);
                $reps = $replies->getReplies($id);
                $this->view->thread = $result[0];
                $this->view->replies = $reps;
                $this->view->id = $id;
                
                
              
                
                $thuser =  $users->getUserById($result[0]['user_id'])[0];
                $threadUser = array ($thuser['id'] , $thuser['username'] , $thuser['signature']);
                
                $replyUsers = array();
                foreach ($reps as $reply){
                    $user = $users->getUserById($reply['user_id'])[0];
                    $replyUsers[] = array ($user['id'] , $user['username'] , $user['signature'], $user['isAdmin'] , $user['isBan']);
                 }


                $this->view->users = $replyUsers;
                $this->view->myInfo = $bootstrap->myinfo;
                $this->view->threadUser = $threadUser;
                

                
                
           }
           
       
            else{

                $this->redirect('/thread/error');


            }
       }
    }
    
    //called by AJAX
    public function updatethreadAction(){
 
        if ($this->_request->isPost()){
           $data['threadTitle']= $this->_request->getParam('title'); 
           $data['body']= $this->_request->getParam('body'); 
           $cond='threadId= '.$this->_request->getParam('id');
           $thr_model = new Application_Model_Thread();
           $thr_model->updateThread($data, $cond);
           exit;

        }

   }

    public function deletethreadAction(){

            if ($this->_request->isPost()){
                       
               $cond='threadId= '.$this->_request->getParam('id');
               $thr_model = new Application_Model_Thread();
               $thr_model->deleteThread($cond);
               exit;
              
            }
       }
    
    
}


