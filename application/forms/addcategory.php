<?php

class Application_Form_addcategory extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");
     
        $catName = new Zend_Form_Element_Text("catName");
        $catName->setAttrib("class", "form-control");  //class name
        $catName->setLabel("category name: ");
        $catName->setRequired();
        $catName->setDecorators(array(

  

                   'ViewHelper',

                   'Description',

                   'Errors',

                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),

                   array('Label', array('tag' => 'td')),

                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))

  

           ));
        
        
        $catId = new Zend_Form_Element_Text("catId");
        $catId->setAttrib("visibilty", "hidden");  //class name
       
        
        $submit = new Zend_Form_Element_Submit("submit");
         $submit->setDecorators(array(

  

               'ViewHelper',

               'Description',

               'Errors', array(array('data'=>'HtmlTag'), array('tag' => 'td',

               'colspan'=>'2','align'=>'center')),

               array(array('row'=>'HtmlTag'),array('tag'=>'tr', 'closeOnly'=>'true'))

  

       ));
        $this->addElements(array($catName,$submit));
        $this->setDecorators(array(

  

               'FormElements',

               array(array('data'=>'HtmlTag'),array('tag'=>'table')),

               'Form'

  

       ));
    }


}

