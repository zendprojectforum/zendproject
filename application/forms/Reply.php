<?php

class Application_Form_Reply extends Zend_Form
{

    public function init()
    {
        $this->setMethod("post");
     
        $body= new Zend_Form_Element_Textarea("reply");       
        $body->setRequired();
        
        $id = new Zend_Form_Element_Hidden("id");
        
        $submit = new Zend_Form_Element_Submit("submit");
        $this->addElements(array($id,$body, $submit));
      
    }


}

