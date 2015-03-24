<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initMail() {
        try {
            $config = array(
                'auth' => 'login',
                'username' => 'mertloka@gmail.com',
                'password' => '',
                'ssl' => 'tls',
                'port' => 587
            );

            $mailTransport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
            Zend_Mail::setDefaultTransport($mailTransport);
        } catch (Zend_Exception $e) {
            //Do something with exception
        }
    }

    protected function _initSession() {
        //$action = $this->getRequest()->getActionName();
        $this->user2;
        $authorization = Zend_Auth::getInstance();
        if ($authorization->hasIdentity()) {
             $info = $authorization->getIdentity();
            $this->myinfo = $info;
        /* else {
          } */
           
            //$name = $info->username ;
            // echo "welcome $name";
        }
      
    }

   

    var $myinfo;

}
