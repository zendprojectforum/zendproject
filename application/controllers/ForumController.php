<?php

class ForumController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
     public function getforumAction()
    {
        $forum_model = new Application_Model_Forum();
        $forums=$forum_model->listForums();
        
        $this->view->forums = $forums;  
        $posts = array();
        $posts_model= new Application_Model_Thread();
        
        for ($i=0;$i<count($forums);$i++){
           
           $posts[$i] = $posts_model->listpoststospecificform((int)$forums[$i]['forumId']);
            
            
        }
        
        $this->view->posts=$posts;
        
    }
    
    public function forumdataAction() {
       $forumId=$this->_request->getParam('forumId');
       $posts_model= new Application_Model_Thread();
       $posts = $posts_model->listpoststospecificform($forumId);
       $this->view->posts=$posts; 
        
    }
  
    function addforumAction(){
        $form  = new Application_Form_addforum();
        
        if($this->getRequest()->isPost()){
            echo $form->isValid($this->getRequest()->getParams());
           if($form->isValid($this->getRequest()->getParams())){
                
               $form_info = $form->getValues();
               $form_model = new Application_Model_Category();
               $form_model->addforum($form_info);
                       
           }
     
        
        }
       
        $this->view->form=$form;
       
     }
    function deleteforumAction(){
        
        $forumId=$this->_request->getParam('forumId');
        
        
        $forum_model = new Application_Model_Forum();
        
        $forum_model->deleteforum((int)$forumId); 
         
        echo $forumId;exit;
    }
     
     
     
}

