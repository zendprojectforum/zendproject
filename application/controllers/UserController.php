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
    {/*
        require_once 'Zend/Mail/Transport/Smtp.php';
        $tr = new Zend_Mail_Transport_Smtp('mertloka@hotmail.com');
        Zend_Mail::setDefaultTransport($tr);
        // action body
        $mail = new Zend_Mail();
        $mail->setBodyText('This is the text of the mail.');
        $mail->setFrom('mertloka@hotmail.com', 'Some Sender');
        $mail->addTo('mertloka@hotmail.com', 'Some Recipient');
        $mail->setSubject('TestSubject');
        
        $mail->send();
       */
        
        //Prepare email
            $mail = new Zend_Mail();
            
            $mail->addTo('mertloka@hotmail.com');
           
            $mail->setSubject('eeeeeeeeeeeeeee');
            
            $mail->setBodyText('hhhhhhhhhhhhhhh');
          
            $mail->setFrom('mertloka@gmail.com', 'User Name');
            
            //Send it!
            $sent = true;
             
               
            try {
                $mail->send();
            } catch (Exception $e){
               
                  echo $e;exit;
                $sent = false;
            }

            //Do stuff (display error message, log it, redirect user, etc)
            if($sent){
                //Mail was sent successfully.
            } else {
                
               
                //Mail failed to send.
            }
      
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





