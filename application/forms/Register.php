<?php

class Application_Form_Register extends Zend_Form
{

    public function init()
    { 
        $this->tsetMethod("post");
     
        $username = new Zend_Form_Element_Text("name");
        $username->setAttrib("class", "form-control");  //class name
        $username->setLabel("Username: ");
        $username->setRequired();
        
        $password = new Zend_Form_Element_Password("password");
        $password->setRequired()
                 ->setLabel("Password")
                 ->addValidator('StringLength', false, array(6,15))
                 ->addErrorMessage('Please choose a password between 6-15 characters');
        
        
        $confirmPswd = new Zend_Form_Element_Password('confirm_pswd');
       /* $confirmPswd->setLabel('Confirm Password:')
                ->setAttrib('size', 35)
                ->setRequired(true)
                ->addValidator('Identical', false, array('token' => '$password'))
                ->addErrorMessage('The passwords do not match');
*/
        //$username->addValidator(new Zend_Validate_EmailAddress());
       // $username->addFilter(new Zend_Filter_StripTags);
        //$username->addDecorator($decorator)
        
        $email = new Zend_Form_Element_Text("email");
         $email->setRequired()
                ->setLabel("Email:")
                 ->addValidator(new Zend_Validate_EmailAddress());
            /*     ->addValidator(new Zend_Validate_Db_NoRecordExists(array(
        'table' => 'user',
        'field' => 'email'
    )
));*/
         
         
         
         $id = new Zend_Form_Element_Hidden("id");
         $submit = new Zend_Form_Element_Submit("submit");
         $this->addElements(array($id,$username,$email,$password,$confirmPswd , $submit));
        
        
    }

  /* Form Elements & Other Definitions Here ... */
    


}

