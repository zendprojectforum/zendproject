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
        $forumName->setDecorators(array(

  

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
        $this->addElements(array($forumName, $submit));
        $this->setDecorators(array(

  

               'FormElements',

               array(array('data'=>'HtmlTag'),array('tag'=>'table')),

               'Form'

  

       ));

    }


}

