<?php

class ThreadController extends Zend_Controller_Action
{

    public function init()
    {       

        $action = $this->getRequest()->getActionName();
        $authorization = Zend_Auth::getInstance();
        if ($authorization->hasIdentity()) {
            
            
            //1-check system
            $info = $authorization->getIdentity();
            if (!$this->checkSystemStatus() && !$info->isAdmin) {
                
                    $this->redirect("user/systemclosed");
            } 
            
            }else{ //not logged in
               
                //1-check system status
                if (!$this->checkSystemStatus() && !$action == "login" ) {
                    $this->redirect("user/systemclosed");
            }
        }

        /* Initialize action controller here */
    }
    
    
    private function checkSystemStatus() {

        $sys_mdl = new Application_Model_System();
        $system = $sys_mdl->getStatus()[0];
        return $system['status'];
    }
    
    
    
    
    protected function javascriptHelper($caller){
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
    
   
    public function indexAction()
    {
        // action body
    }

    
    //called by AJAX
public function markstickythreadAction(){
 
        $threadId=$this->_request->getParam('threadId');
        $forumId= $this->_request->getParam('forumId');
        
        $thread_model = new Application_Model_Thread();
        
        $thread_model->stickthread($threadId,$forumId);
        
        $this->redirect('/Forum/forumdata?forumId='.$forumId);

   }
    
   
   public function lockthreadAction() {
      
       $threadId=$this->_request->getParam('threadId');
       $thread_model = new Application_Model_Thread();
       
       $isLocked= $thread_model-> getThreadById($threadId);
      
       $isLocked=$isLocked[0]["isLocked"];
       
       $thread_model = new Application_Model_Thread();
      // $thread_model->lockthread($threadId,!($isLocked));
       
       $thread_model->updateThread(array('isLocked'=>!($isLocked)),'threadId='.$threadId);
       echo (!$isLocked);
       exit;
        
    }
   
   
public function addthreadAction(){
            $action = $this->getRequest()->getActionName();
            $authorization =Zend_Auth::getInstance();
             
             $info =     $authorization->getIdentity ();
             
                   
            $form = new Application_Form_addthread();

    
            if($this->getRequest()->isPost()){
            echo $form->isValid($this->getRequest()->getParams());
           if($form->isValid($this->getRequest()->getParams())){
                
               $thread_info = $form->getValues();
               $forumId=$this->_request->getParam('forumId');
               $thread_info["forumId"]=$forumId;
               $thread_info["user_id"]=$info->id;
               $thread_model = new Application_Model_Thread();
               $thread_model->addthread($thread_info);
               $this->redirect('/Forum/forumdata?forumId='.$forumId);        
           }
     
        
        }
            $this->view->form = $form;
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
                $threadUser = array ($thuser['id'] , $thuser['username'] , $thuser['signature'],$thuser['profpic'] );
                
                $replyUsers = array();
                foreach ($reps as $reply){
                    $user = $users->getUserById($reply['user_id'])[0];
                    $replyUsers[] = array ($user['id'] , $user['username'] , $user['signature'], $user['isAdmin'] , $user['isBan'], $user['profpic']);
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


