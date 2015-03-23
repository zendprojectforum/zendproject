<?php

class Application_Form_User extends Zend_Form {

    public function init() {
        $this->setMethod("post");

        $username = new Zend_Form_Element_Text("username");
        $username->setAttrib("class", "form-control")
                ->addDecorator('HtmlTag', array('tag' => 'div', 'class' =>'test' ))
                ->setLabel("Username: ")
                ->setRequired()
                ;

        $password = new Zend_Form_Element_Password("password");
        $password->setAttrib("class", "form-control")  //class name
                ->setRequired()
                ->setLabel("Password")
                 ->addValidator('StringLength', false, array(6, 15))
                 ->addErrorMessage('Please choose a password between 6-15 characters');


        $confirmPswd = new Zend_Form_Element_Password('confirm_pswd');
        $confirmPswd->setAttrib("class", "form-control");  //class name

        $confirmPswd->setLabel('Confirm Password:')
                ->setAttrib('size', 35)
                ->setRequired(true)
                ->addValidator('Identical', false, array('token' => 'password'))
                ->addErrorMessage('The passwords do not match');


        $email = new Zend_Form_Element_Text("email");
        $email->setAttrib("class", "form-control")  //class name     
              ->setRequired()
              ->setLabel("Email:")
              ->addValidator(new Zend_Validate_EmailAddress())
              ->addValidator(new Zend_Validate_Db_NoRecordExists(array(
                    'table' => 'user',
                    'field' => 'email')
        ));

        $gender = new Zend_Form_Element_Radio('gender');
        $gender->setRequired(true)
                ->setMultiOptions(array('Male' => 'Male', 'Female' => 'Female'));

      
        $country = new Zend_Form_Element_Select('country');
        $locale = new Zend_Locale('en_US');
        $countries = ($locale->getTranslationList('Territory', 'en', 2));
        asort($countries, SORT_LOCALE_STRING);
        $country->setMultiOptions($countries)
                ->setLabel('Select country:');


        $status = new Zend_Form_Element_Select('status');
        $status->setLabel("Choose your relationship status:");
        $status->setMultiOptions(array(
            'Single' => 'Single',
            'Engaged' => 'Engaged',
            'Married' => 'Married',
            'Divorced' => 'Divorced',
            'Widowed' => 'Widowed'
        ));

        @$signature = new Zend_Form_Element_File('signature');
        @$signature->setLabel('Uploat your signature:')
                        ->setDestination('media/images')
                        ->setRequired(true)
                        ->setMaxFileSize(10240000)                              // limits the filesize on the client side
                        ->addValidator('Count', false, 1)                       // ensure only 1 file
                        ->addValidator('Extension', false, 'jpg,jpeg,png,gif'); // only JPEG, PNG, an


        $submit = new Zend_Form_Element_Submit("submit");
        $submit->setAttrib("class", "btn btn-primary");
        $this->addElements(array($username, $email, $password, $confirmPswd, $gender, $country, $status, $signature, $submit));
    }

}
