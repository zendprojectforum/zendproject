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

    public function getrepliesAction()
    {
           
        if($this->_request->isGet()){

           $id = $this->_request->getParam('id');
           $replies = new Application_Model_Reply;
           $reps = $replies->getReplies($id); 
           $this->view->replies = $reps;

           
        }

    }
}



