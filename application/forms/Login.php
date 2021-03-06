<?php

class Application_Form_Login extends Zend_Form {

    public function init() {

        error_reporting(E_ALL); //this should show all php errors

        $this->setMethod("post");
        $this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);

        $email = new Zend_Form_Element_Text("email");
        $email->setRequired()
                ->setLabel("Email:");
$email->setDecorators(array(

  

                   'ViewHelper',

                   'Description',

                   'Errors',

                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),

                   array('Label', array('tag' => 'td')),

                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))

  

           ));



        $password = new Zend_Form_Element_Password("password");
        $password->setRequired()
                ->setLabel("Password");
$password->setDecorators(array(

  

                   'ViewHelper',

                   'Description',

                   'Errors',

                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),

                   array('Label', array('tag' => 'td')),

                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))

  

           ));




       
        $submit = new Zend_Form_Element_Submit("submit");
 $submit->setDecorators(array(

  

               'ViewHelper',

               'Description',

               'Errors', array(array('data'=>'HtmlTag'), array('tag' => 'td',

               'colspan'=>'2','align'=>'center')),

               array(array('row'=>'HtmlTag'),array('tag'=>'tr', 'closeOnly'=>'true'))

  

       ));
        $this->addElements(array($email, $password, $submit));
     $this->setDecorators(array(

  

               'FormElements',

               array(array('data'=>'HtmlTag'),array('tag'=>'table')),

               'Form'

  

       ));
        
    }

}
