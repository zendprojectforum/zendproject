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
    
    public function categorydataAction()
    {
        $categoryID=$this->getRequest()->getParam('categoryId');
        $forum_model = new Application_Model_Forum();
        
        $forums = $forum_model->listforumstospecificcategory((int)$categoryID);
        $this->view->forums=$forums;
        $this->view->categoryID=$categoryID;
        
    }
    function addcategoryAction(){
        $form  = new Application_Form_addcategory();
        $validator = new Zend_Validate_Db_NoRecordExists( array('table' => 'category','field' => 'catName'));
        if ($validator->isValid($this->_request->getParam('catName'))) {
            // email address appears to be valid
        
        if($this->getRequest()->isPost()){
            echo $form->isValid($this->getRequest()->getParams());
           if($form->isValid($this->getRequest()->getParams())){
                
               $category_info = $form->getValues();
               $category_model = new Application_Model_Category();
               $category_model->addcategory($category_info);
           $this->redirect('/Category/getcategory');        
                   
           }
     
        
        }
        } else {
            // email address is invalid; print the reasons
            foreach ($validator->getMessages() as $message) {
                echo "$message\n";
            }
        } 
       
        $this->view->form=$form;
  
     }
     public function lockcategoryAction() {
       $categoryId=$this->_request->getParam('catId');
       $category_model = new Application_Model_Category();
       $catIsLocked= $category_model-> listspecificcategory($categoryId);
       $catIsLocked=$catIsLocked[0]["catIsLocked"];
       $category_model->lockcategory($categoryId,!($catIsLocked));
       echo (!($catIsLocked));
       exit;
        
    }
     
      function deletecategoryAction(){
        $catId=$this->_request->getParam('catId');
        
        
        $category_model = new Application_Model_Category();
        
        $category_model->deletecategory((int)$catId); 
         
        echo $catId;exit;
    }
     
     
     
function editcategoryAction(){
         $form  = new Application_Form_addcategory();
        $validator = new Zend_Validate_Db_NoRecordExists( array('table' => 'category','field' => 'catName'));
        if ($validator->isValid($this->_request->getParam('catName'))) {
            // email address appears to be valid
        
        if($this->getRequest()->isPost()){
        $categoryId=$this->_request->getParam('categoryId');
        $categoryName=$this->_request->getParam('catName');
       
        $category_model = new Application_Model_Category();
        echo $categoryId; 
        
      
        $category_model->editcategory($categoryId,trim($categoryName));
        
        } 

        }
       else {
           foreach ($validator->getMessages() as $message) {
                echo "$message\n";
            }
        } 
       
        $this->view->form=$form;
     
}
}