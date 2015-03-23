<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initMail() {
        try {
            $config = array(
                'auth' => 'login',
                'username' => 'putyour@gmail.com',
                'password' => 'password',
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
        if (!$authorization->hasIdentity()) {

            //if (!($action == "login"))
            //     $this->redirect("user/login");
        }
        /* else {
          //if (($action == "login" ) || ($action == "add" ) ){
          //     $this->redirect("article/list");
          } */ else {
            $info = $authorization->getIdentity();
            $this->myinfo = $info;
            //$name = $info->username ;
            // echo "welcome $name";
        }
      
    }

    public function _initRequest() {
        $this->bootstrap('frontController');
        $front = $this->getResource('frontController');
        $front->setRequest(new Zend_Controller_Request_Http());

        $request = $front->getRequest()->getControllerName();
       // $controller = $request->getControllerName();
      //  echo $request+"777";

    }

    var $myinfo;

}
