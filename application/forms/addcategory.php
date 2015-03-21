<?php

class Application_Form_addcategory extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");
     
        $catname = new Zend_Form_Element_Text("catName");
        $catname->setAttrib("class", "form-control");  //class name
        $catname->setLabel("category name: ");
        $catname->setRequired();
       
        $catId = new Zend_Form_Element_Text("catId");
        $catId->setAttrib("visibilty", "hidden");  //class name
       
        
        $submit = new Zend_Form_Element_Submit("submit");
        $this->addElements(array($catname, $submit));
        
    }


}

