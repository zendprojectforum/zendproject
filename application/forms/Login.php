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



/******************************/
        $wd = getcwd();
        $destination = APPLICATION_PATH;
        //exit;
        $image = new Zend_Form_Element_File('image');
        $image->setLabel('Upload an image:')
                ->setDestination("public/media/images")
                ->setRequired(true)
                ->setMaxFileSize(10240000) // limits the filesize on the client side
                ->setDescription('Click Browse and click on the image file you would like to upload');
        $image->addValidator('Count', false, 1);                // ensure only 1 file
        $image->addValidator('Size', false, 10240000);            // limit to 10 meg
        $image->addValidator('Extension', false, 'jpg,jpeg,png,gif'); // only JPEG, PNG, an

/********************************************************/
        $submit = new Zend_Form_Element_Submit("submit");
        $this->addElements(array($email, $password,$image, $submit));
    }

}
