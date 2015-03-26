<?php

class Application_Form_User extends Zend_Form {

    public function init() {
        $this->setMethod("post");
        

        $username = new Zend_Form_Element_Text("username");
        $username->setAttrib("class", "form-control")
                ->addDecorator('HtmlTag', array('tag' => 'td', 'class' =>'test' ))
                ->setLabel("Username: ")
                ->setRequired()
                ;
        $username->setDecorators(array(

  

                   'ViewHelper',

                   'Description',

                   'Errors',

                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),

                   array('Label', array('tag' => 'td')),

                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))

  

           ));
        $password = new Zend_Form_Element_Password("password");
        $password->setAttrib("class", "form-control")  //class name
                ->setRequired()
                ->setLabel("Password")
                 ->addValidator('StringLength', false, array(6, 15))
                 ->addErrorMessage('Please choose a password between 6-15 characters');
        $password->setDecorators(array(

  

                   'ViewHelper',

                   'Description',

                   'Errors',

                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),

                   array('Label', array('tag' => 'td')),

                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))

  

           ));

        $confirmPswd = new Zend_Form_Element_Password('confirm_pswd');
        $confirmPswd->setAttrib("class", "form-control");  //class name

        $confirmPswd->setLabel('Confirm Password:')
                ->setAttrib('size', 35)
                ->setRequired(true)
                ->addValidator('Identical', false, array('token' => 'password'))
                ->addErrorMessage('The passwords do not match');

        $confirmPswd->setDecorators(array(

  

                   'ViewHelper',

                   'Description',

                   'Errors',

                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),

                   array('Label', array('tag' => 'td')),

                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))

  

           ));

        $email = new Zend_Form_Element_Text("email");
        $email->setAttrib("class", "form-control")  //class name     
              ->setRequired()
              ->setLabel("Email:")
              ->addValidator(new Zend_Validate_EmailAddress())
              ->addValidator(new Zend_Validate_Db_NoRecordExists(array(
                    'table' => 'user',
                    'field' => 'email')
        ));

        $email->setDecorators(array(

  

                   'ViewHelper',

                   'Description',

                   'Errors',

                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),

                   array('Label', array('tag' => 'td')),

                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))

  

           ));
       $gender = new Zend_Form_Element_Radio('gender');

        $gender->setLabel('Gender:')

        ->addMultiOptions(array(

        'Male' => 'Male',

        'Female'=> 'Female'

        ))

        ->setSeparator('');
        $gender->setRequired();
        $gender->setDecorators(array(

  

                   'ViewHelper',

                   'Description',

                   'Errors',

                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),

                   array('Label', array('tag' => 'td')),

                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))

  

           ));
      
        $country = new Zend_Form_Element_Select('country');
        $country->setDecorators(array(

  

                   'ViewHelper',

                   'Description',

                   'Errors',

                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),

                   array('Label', array('tag' => 'td')),

                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))

  

           ));
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

        $status->setDecorators(array(

  

                   'ViewHelper',

                   'Description',

                   'Errors',

                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),

                   array('Label', array('tag' => 'td')),

                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))

  

           ));
        @$profpic = new Zend_Form_Element_File('profpic');
        @$profpic->setLabel('Upload your profile picture:')
                        ->setDestination('media/profile')
                        ->setMaxFileSize(10240000)                              // limits the filesize on the client side
                        ->addValidator('Count', false, 1)                       // ensure only 1 file
                        ->addValidator('Extension', false, 'jpg,jpeg,png,gif'); // only JPEG, PNG, an

          @$profpic->setDecorators(array(

  

                   'File',

                   'Errors',

                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),

                   array('Label', array('tag' => 'td')),

                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))

  

           ));
        
        @$signature = new Zend_Form_Element_File('signature');
        @$signature->setLabel('Upload your signature:')
                        ->setDestination('media/images')
                        ->setMaxFileSize(10240000)                              // limits the filesize on the client side
                        ->addValidator('Count', false, 1)                       // ensure only 1 file
                        ->addValidator('Extension', false, 'jpg,jpeg,png,gif'); // only JPEG, PNG, an
        @$signature->setDecorators(array(

  

                   'File',

                   'Errors',

                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),

                   array('Label', array('tag' => 'td')),

                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))

  

           ));

        $submit = new Zend_Form_Element_Submit("submit");
        $submit->setAttrib("class", "btn btn-primary");
        $submit->setDecorators(array(

  

               'ViewHelper',

               'Description',

               'Errors', array(array('data'=>'HtmlTag'), array('tag' => 'td',

               'colspan'=>'2','align'=>'center')),

               array(array('row'=>'HtmlTag'),array('tag'=>'tr', 'closeOnly'=>'true'))

  

       ));

        $this->addElements(array($username, $email, $password, $confirmPswd, $gender, $country, $status, $profpic, $signature, $submit));
        $this->setDecorators(array(

  

               'FormElements',

               array(array('data'=>'HtmlTag'),array('tag'=>'table')),

               'Form'

  

       ));

        }

}
