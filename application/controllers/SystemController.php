<?php

class SystemController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
    
    
    public function showsystemAction()
    {
           
        $sys_mdl = new Application_Model_System();
        $status = $sys_mdl->getStatus()[0];
        
        $user_mdl = new Application_Model_User();
        //var_dump ($status);
        $admin = $user_mdl->getUserById($status['admin_id'])[0];    
        $this->view->status = $status['status'];
        $this->view->adminname = $admin['username'];
        
    }
    
    //called by AJAX
    public function changestatusAction()
    {
         if ($this->_request->isPost()){
           
            $data['admin_id']= $this->_request->getParam('id');
            $data['status']= $this->_request->getParam('status');
            $sys_mdl = new Application_Model_System();
            $sys_mdl->updateStatus($data);
            exit;
            
         }
       
    }


}
