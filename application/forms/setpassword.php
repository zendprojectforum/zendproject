<?php

class Application_Form_setpassword extends Zend_Form {

    public function init() {

        error_reporting(E_ALL); //this should show all php errors

        $this->setMethod("post");
        $this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);

        $password = new Zend_Form_Element_Password("password");
        $password->setRequired()
                 ->setLabel("Password")
                 ->addValidator('StringLength', false, array(6,15))
                 ->addErrorMessage('Please choose a password between 6-15 characters');
        
        
       
       




       
        $submit = new Zend_Form_Element_Submit("submit");
        $submit->setDecorators(array(

  

               'ViewHelper',

               'Description',

               'Errors', array(array('data'=>'HtmlTag'), array('tag' => 'td',

               'colspan'=>'2','align'=>'center')),

               array(array('row'=>'HtmlTag'),array('tag'=>'tr', 'closeOnly'=>'true'))

  

       ));
        $this->addElements(array($password, $submit));
     $this->setDecorators(array(

  

               'FormElements',

               array(array('data'=>'HtmlTag'),array('tag'=>'table')),

               'Form'

  

       ));
        
    }

}
