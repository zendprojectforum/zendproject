<?php

class CategoryController extends Zend_Controller_Action
{

    public function init()
    {
        $action = $this->getRequest()->getActionName();
        $authorization = Zend_Auth::getInstance();
        if ($authorization->hasIdentity()) {
            
            
            //1-check system
            $info = $authorization->getIdentity();
            if (!$this->checkSystemStatus() && !$info->isAdmin) {
                
                    $this->redirect("user/systemclosed");
            } 
            
            }else{ //not logged in
               
                //1-check system status
                if (!$this->checkSystemStatus() ) {
                    $this->redirect("user/systemclosed");
            }
        }
    }

    
    private function checkSystemStatus() {

        $sys_mdl = new Application_Model_System();
        $system = $sys_mdl->getStatus()[0];
        return $system['status'];
    }
    
    
    
    public function indexAction()
    {
        // action body
    }

    public function getcategoryAction()
    {
        $front = Zend_Controller_Front::getInstance();
        $bootstrap = $front->getParam("bootstrap");
         
        $category_model = new Application_Model_Category();
        $categories=$category_model->listCategories();
        
        $this->view->categories = $categories;  
        
        $forums = array();
        
        $forum_model= new Application_Model_Forum();
        
        for ($i=0;$i<count($categories);$i++){
              
           $forums[$i] = $forum_model->listforumstospecificcategory((int)$categories[$i]['catId']);
            
            
        }
        $this->view->forums=$forums;
        $this->view->myInfo = $bootstrap->myinfo;
    }
    
    public function categorydataAction()
    {
        $front = Zend_Controller_Front::getInstance();
        $bootstrap = $front->getParam("bootstrap");
        $categoryID=$this->getRequest()->getParam('categoryId');
        $forum_model = new Application_Model_Forum();
        
        $forums = $forum_model->listforumstospecificcategory((int)$categoryID);
        $this->view->forums=$forums;
        $this->view->categoryID=$categoryID;
        $this->view->myInfo = $bootstrap->myinfo;
        $category_model = new Application_Model_Category();
        $this->view->lock=$category_model->listspecificcategory($categoryID)[0]["catIsLocked"]; 
    }
    function addcategoryAction(){
        
        $front = Zend_Controller_Front::getInstance();
        $bootstrap = $front->getParam("bootstrap");
        
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
        $this->view->myInfo = $bootstrap->myinfo;
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
    
    
    
        $action = $this->getRequest()->getActionName();
        $authorization = Zend_Auth::getInstance();
        if ($authorization->hasIdentity()) {
            //1-check system
            $info = $authorization->getIdentity();
            if (!$info->isAdmin){
                $this->redirect("user/systemclosed");
            }
        }
        
        
        $categoryId=$this->_request->getParam('categoryId');
        $categoryName=$this->_request->getParam('catName');
         $form  = new Application_Form_addcategory();
        $validator = new Zend_Validate_Db_NoRecordExists( array('table' => 'category','field' => 'catName'));
        if ($validator->isValid($this->_request->getParam('catName'))) {
            // email address appears to be valid
        
        if($this->getRequest()->isPost()){
        
       
        $category_model = new Application_Model_Category();
        echo $categoryId; 
        
      
        $category_model->editcategory($categoryId,trim($categoryName));
        $this->redirect('/Category/getcategory');   
        } 

        }
       else {
           foreach ($validator->getMessages() as $message) {
                echo "$message\n";
            }
        } 
        $data['catName']= $categoryName;
        $form->populate($data);
        $this->view->form=$form;
        $this->view->admin = $info->isAdmin;
     
}
}
