<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Form_addthread extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");
        $threadtitle = new Zend_Form_Element_Text("threadtitle");
        $threadtitle->setAttrib("class", "form-control");  //class name
        $threadtitle->setLabel("thread title ");
        $threadtitle->setRequired();
        
        
        $newthread = new Zend_Form_Element_Textarea("newthread");
        $newthread->setAttrib("class", "form-control");  //class name
        $newthread->setLabel("add thread  ");
        $newthread->setRequired();
        
       
        
        $submit = new Zend_Form_Element_Submit("submit");
        $this->addElements(array($threadtitle,$newthread,$submit));
        
    }


}