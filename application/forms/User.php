<?php

class Application_Form_User extends Zend_Form
{

    public function init()
    {
        $this->setMethod("post");
     
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
        $confirmPswd->setLabel('Confirm Password:')
                ->setAttrib('size', 35)
                ->setRequired(true)
                ->addValidator('Identical', false, array('token' => 'password'))
                ->addErrorMessage('The passwords do not match');

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
//-----------------------------------------------------------------------------------------            
        $nationality = new Zend_Form_Element_Select('nationality');
        $nationality->setLabel("Choose your nationality:");
        $nationality ->setMultiOptions(array('Afghan','Albanian','Algerian','American','Andorran','Angolan','Antiguans','Argentinean','Armenian',Australian,
            'Austrian','Azerbaijani','Bahamian','Bahraini','Bangladeshi','Barbadian','Barbudans',
            'Batswana','Belarusian','Belgian','Belizean','Beninese','Bhutanese','Bolivian','Bosnian',
            'Brazilian','British','Bruneian','Bulgarian','Burkinabe','Burmese','Burundian','Cambodian',
            'Cameroonian','Canadian','Cape Verdean','Central African','Chadian','Chilean','Chinese',
            'Colombian','Comoran','Congolese','Costa Rican','Croatian,Cuban','Cypriot','Czech','Danish',
            'Djibouti','Dominican','Dutch','East Timorese','Ecuadorean','Egyptian','Emirian','Eritrean',
            'Estonian','Ethiopian','Fijian','Filipino','Finnish','French','Gabonese','Gambian','Georgian',
            'German','Ghanaian','Greek','Grenadian','Guatemalan','Guinea-Bissauan','Guinean','Guyanese',
            'Haitian','Herzegovinian','Honduran','Hungarian','Icelander','Indian','Indonesian','Iranian',
            'Iraqi','Irish','Italian','Ivorian','Jamaican','Japanese','Jordanian','Kazakhstani',
            'Kenyan','Kittian and Nevisian','Kuwaiti','Kyrgyz','Laotian','Latvian','Lebanese','Liberian',
            'Libyan','Liechtensteiner','Lithuanian','Luxembourger','Macedonian','Malagasy','Malawian',
            'Malaysian','Maldivan','Malian','Maltese','Marshallese','Mauritanian','Mauritian','Mexican',
            'Micronesian','Moldovan','Monacan','Mongolian','Moroccan','Mosotho','Motswana','Mozambican',
            'Namibian','Nauruan','Nepalese','Netherlander','New Zealander','Ni-Vanuatu','Nicaraguan',
            'Nigerian','Nigerien','North Korean','Northern Irish','Norwegian','Omani','Pakistani',
            'Palauan','Panamanian', 'Paraguayan','Peruvian','Polish',
            'Portuguese','Qatari','Romanian','Russian','Rwandan','Salvadoran',
            'Samoan,Saudi','Scottish','Senegalese','Serbian',
            'Seychellois','Singaporean','Slovakian','Slovenian','Solomon Islander',
            'Somali','South African','South Korean','Spanish,Sudanese','Surinamer','Swazi',
            'Swedish','Swiss','Syrian','Taiwanese','Tajik','Tanzanian','Thai','Togolese','Tongan','Tunisian',
            'Turkish','Tuvaluan','Ugandan','Ukrainian','Uruguayan','Uzbekistani','Venezuelan',
            'Vietnamese','Welsh','Yemenite','Zambian','Zimbabwean'));
         
        
        
         
        $status = new Zend_Form_Element_Select('status');
        $status->setLabel("Choose your relationship status:");
        $status ->setMultiOptions(array('Single', 'Engaged' , 'Married', 'Divorced' , 'Widowed'));
            
         $id = new Zend_Form_Element_Hidden("id");
         $submit = new Zend_Form_Element_Submit("submit");
         $this->addElements(array($id,$username,$email,$password,$confirmPswd ,$nationality,$status , $submit));
      
      
        
    }


}

