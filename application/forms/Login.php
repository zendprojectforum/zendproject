<?php

class Application_Form_Login extends Zend_Form {

    public function init() {

        error_reporting(E_ALL); //this should show all php errors

        $this->setMethod("post");
        $this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);

        $email = new Zend_Form_Element_Text("email");
        $email->setRequired()
                ->setLabel("Email:");



        $password = new Zend_Form_Element_Password("password");
        $password->setRequired()
                ->setLabel("Password");




       
        $submit = new Zend_Form_Element_Submit("submit");
        $this->addElements(array($email, $password, $submit));
    }

}
