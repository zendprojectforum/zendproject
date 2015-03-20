<?php

class ReplyController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function getrepliesAction(){
           
        if($this->_request->isGet()){

           $id = $this->_request->getParam('id');
           $replies = new Application_Model_Reply;
           $reps = $replies->getReplies($id); 
           $this->view->replies = $reps;

           
        }

    }
    
    public function savereplyAction(){
 
       if ($this->_request->isPost()){
           
               $userId = 1;
            
               $reply['body']= $this->_request->getParam('body');
               //$id = $this->_request->getParam('id');
               $reply['thread_id'] = $this->_request->getParam('thread_id');
               $reply['user_id']= $userId;
               $rep_model = new Application_Model_Reply();
               $rep_model->addReply($reply);
               
               //get reply
               unset($reply['body']);
               $reply['Date'] = 'max(Date)';
               //var_dump($reply);
               $lastReply = $rep_model->getLastReply($reply);
               echo json_encode($lastReply[0]);
               
               
               exit;
               
               
           }
       }
       
       public function updatereplyAction(){
 
            if ($this->_request->isPost()){
               $data['body']= $this->_request->getParam('body');
               $data['edited']= 1;
               
               $cond='replyId= '.$this->_request->getParam('id');
               $rep_model = new Application_Model_Reply();
               $rep_model->updateReply($data, $cond);
               exit;
              
            }
  
       }
       
       public function deletereplyAction(){
 
            if ($this->_request->isPost()){
                       
               $cond='replyId= '.$this->_request->getParam('id');
               $rep_model = new Application_Model_Reply();
               $rep_model->deleteReply($cond);
               exit;
              
            }
       }
}


