<?php

class Application_Form_addforum extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");
        
        //$cat_id=new Zend_Form_Element_Checkbox();
        //$cat_id=new Zend_Form_Element_Select($cats);
        //$cat_id->setOptions($cats);
        
       
        $forumName = new Zend_Form_Element_Text("forumName");
        $forumName->setAttrib("class", "form-control");  //class name
        $forumName->setLabel("forum name: ");
        $forumName->setRequired();
        
        $submit = new Zend_Form_Element_Submit("submit");
        $this->addElements(array($forumName, $submit));
        
    }


}

