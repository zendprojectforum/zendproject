<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initMail()
        {
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
            } catch (Zend_Exception $e){
                //Do something with exception
            }
        }


}

