<?php

class CategoryController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function getcategoryAction()
    {
      
        $category_model = new Application_Model_Category();
        $categories=$category_model->listCategories();
        
        $this->view->categories = $categories;  
        
        $forums = array();
        
        $forum_model= new Application_Model_Forum();
        
        for ($i=0;$i<count($categories);$i++){
              
           $forums[$i] = $forum_model->listforumstospecificcategory((int)$categories[$i]['catId']);
            
            
        }
        $this->view->forums=$forums;
        
    }
    
    function addcategoryAction(){
        $form  = new Application_Form_addcategory();
        
        if($this->getRequest()->isPost()){
            echo $form->isValid($this->getRequest()->getParams());
           if($form->isValid($this->getRequest()->getParams())){
                
               $category_info = $form->getValues();
               $category_model = new Application_Model_Category();
               $category_model->addcategory($category_info);
                       
           }
     
        
        }
       
        $this->view->form=$form;
  
     }

      function deletecategoryAction(){
        $catId=$this->_request->getParam('catId');
        
        
        $category_model = new Application_Model_Category();
        
        $category_model->deletecategory((int)$catId); 
         
        echo $catId;exit;
    }
     
     
     
function editcategoryAction(){
        $form  = new Application_Form_addcategory();
        $catId=$this->_request->getParam('catId');
       
        if($this->getRequest()->isPost()){
            echo $form->isValid($this->getRequest()->getParams());
           if($form->isValid($this->getRequest()->getParams())){
                
               $category_info = $form->getValues();
               $category_model = new Application_Model_Category();
               $category_model->addcategory($category_info);
                       
           }
     
        
        }
       
        $this->view->form=$form;
        $this->view->catid=$catId;
     }     
     
}
