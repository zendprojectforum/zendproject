<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
        // action body
    }

    public function registerAction()
    {
        echo "here";
       $form  = new Application_Form_User();
       echo "here";
      if($this->_request->isPost()){
           if($form->isValid($this->_request->getParams())){
               $user_info = $form->getValues();
               $user_model = new Application_Model_User();
               $user_model->addUser($user_info);
                       
           }
       }  
       
       	$this->view->form = $form;

           }


}





