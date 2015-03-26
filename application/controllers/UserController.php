<?php

class UserController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */


        $action = $this->getRequest()->getActionName();
        $authorization = Zend_Auth::getInstance();
        if ($authorization->hasIdentity()) {
            
            
            //1-check system
            $info = $authorization->getIdentity();
            if (!$this->checkSystemStatus() && !$info->isAdmin && $action!='systemclosed' && $action!='logout') {
                
                    $this->redirect("user/systemclosed");
            } 
            
            //2-no login or register            
            if (($action == "login" ) || ($action == "register" )||($action == "forgetpassword" )||($action == "setpassword" )) {
                $this->redirect("category/getcategory");
                
            //3- if not admin no listusers 
            } else {         
                if ((!$info->isAdmin) && ($action == "listusers" )) {
                        $this->redirect("user/error");
                    }
                }
            }else{ //not logged in
               
                //1-check system status
                if (!$this->checkSystemStatus() && $action!='systemclosed' && $action!='login' ) {
                    $this->redirect("user/systemclosed");
                    
                //2-no list users (admin only)
                }elseif(($action == "listusers" )) {
                       $this->redirect("user/error");
            }
        }
    }
    
    private function checkSystemStatus() {

        $sys_mdl = new Application_Model_System();
        $system = $sys_mdl->getStatus()[0];
        return $system['status'];
    }
    
    
    
    private function sendmailpassword($email,$id,$userName){
       
            $mail = new Zend_Mail();
            $mail->addTo($email);
            $mail->setSubject('fatkat');
            
            $new="Dear ".$userName.",\n to change your password please use this link"." \n";
            $new=$new.'http://localhost/zend_project/public/user/setpassword?id='.$id ."\n";
                
            
            
            $mail->setBodyText($new);
          
            $mail->setFrom('yoyo80884@gmail.com', 'Change password : Fatkat');
            
            //Send it!
            $sent = true;
             
               
            try {
                $mail->send();
            } catch (Exception $e){
               
                $sent = false;
            }

            if($sent){
                //Mail was sent successfully.
            } else {
                
               
                //Mail failed to send.
            }
        
    }
    public function indexAction() {
        // action body
    }
    
    

    private function sendmail($userinfo) {

        $mail = new Zend_Mail();
        $email = (string) ($userinfo['email']);
        $mail->addTo($email);

        $mail->setSubject('fatkat');
        $new = "welcome to our website here is your info to change it login to the web site :" . " \n";
        foreach ($userinfo as $name => $value) {
            $new .=" ";
            $new .= $name;
            $new .= ":";
            $new .= $value;
            $new .="\n ";
        }

        $mail->setBodyText($new);

        $mail->setFrom('yoyo80884@gmail.com', 'Registration Completed');

        //Send it!
        $sent = true;


        try {
            $mail->send();
        } catch (Exception $e) {

            
            $sent = false;
        }

        //Do stuff (display error message, log it, redirect user, etc)
        if ($sent) {
            //Mail was sent successfully.
        } else {            
        }
    }

    public function loginAction() {
        $form = new Application_Form_Login();
        if ($this->_request->isPost()) {

            if ($form->isValid($this->_request->getParams())) {

                // get the default db adapter
                $db = Zend_Db_Table::getDefaultAdapter();
                $authAdapter = new Zend_Auth_Adapter_DbTable($db, 'user', 'email', 'password');
                //set the email and password
                $email = $form->getValue('email');
                $password = $form->getValue('password');

                $authAdapter->setIdentity($email);
                $authAdapter->setCredential(md5($password));


                //authenticate
                $result = $authAdapter->authenticate();

                if ($result->isValid()) {

                    $auth = Zend_Auth::getInstance();
                    $storage = $auth->getStorage();
                    $data = $authAdapter->getResultRowObject('isAdmin', 'pass');

                    $storage->write($authAdapter->getResultRowObject(array('id', 'username', 'signature', 'isAdmin', 'isBan', 'profpic')));
                    $this->redirect("category/getcategory");
                } else {
                    $message = "Invalid username or password";
                    $this->view->message = $message;
                }
            }
        }

        $this->view->form = $form;
    }

    public function registerAction() {
        $form = new Application_Form_User();
        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getParams())) {
                $user_info = $form->getValues();

                //rename image by user id
                $user_mdl = new Application_Model_User;
                $id = (reset($user_mdl->getLastId()[0])) + 1; //get first value of array
                $source = $form->signature->getFileName();
                $ext = "." . pathinfo($source)['extension'];
                $destination = "media/images/" . $id . $ext;
                chmod($source, 0777);
                rename($source, $destination);
                $user_info['signature'] = "$id$ext";
                unset($user_info['confirm_pswd']);
                $user_mdl->addUser($user_info);
                $this->sendmail($user_info);
                $this->redirect("user/login");
            }
        }

        $this->view->form = $form;
    }

    public function listusersAction() {
        $user_model = new Application_Model_User;
        $users = $user_model->getUsers();
        $this->view->users = $users;
    }

    public function banAction() {
        if ($this->_request->isPost()) {
            $data['isBan'] = $this->_request->getParam('status');
            $cond = 'id= ' . $this->_request->getParam('id');
            $user_model = new Application_Model_User;
            $user_model->ban($data, $cond);
            exit;
        }
    }

    public function makeadminAction() {
        if ($this->_request->isPost()) {
            $data['isAdmin'] = $this->_request->getParam('status');
            $cond = 'id= ' . $this->_request->getParam('id');
            $user_model = new Application_Model_User;
            $user_model->admin($data, $cond);
            exit;
        }
    }

    public function editAction() {
        
        
        
        $action = $this->getRequest()->getActionName();
        $authorization = Zend_Auth::getInstance();
        if ($authorization->hasIdentity()) {
        $info = $authorization->getIdentity();
        }
        $id = ($this->_request->getParam('id'));
        
        
        
    if (!empty($id) && ($id ==  $info->id || $info->isAdmin )) {
            $form = new Application_Form_User();
            $form->getElement("password")->setRequired(false);
            $form->removeElement('confirm_pswd');
            $form->getElement("email")->removeValidator('Db_NoRecordExists');


            if ($this->_request->isPost()) {                            //save updates
                if ($form->isValid($this->_request->getParams())) {
                    $user_info = $form->getValues();
                    $user_model = new Application_Model_User();
                    $user_info['id'] = $id;
                    if (empty($user_info['password'])) {
                        unset($user_info['password']);
                    }


                    //save images
                    if ($user_info["signature"] != NULL) {

                        $source = $form->signature->getFileName();
                        $ext = "." . pathinfo($source)['extension'];
                        $destination = "media/images/" . $id . $ext;
                        chmod($source, 0777);
                        rename($source, $destination);
                        $user_info['signature'] = "$id$ext";
                    } else {
                        unset($user_info['signature']);
                    }

                    if ($user_info["profpic"] != NULL) {

                        $source = $form->profpic->getFileName();
                        $ext = "." . pathinfo($source)['extension'];
                        $destination = "media/profile/" . $id . $ext;
                        chmod($source, 0777);
                        rename($source, $destination);
                        $user_info['profpic'] = "$id$ext";
                    } else {
                        unset($user_info['profpic']);
                    }

                    $user_model->editUser($user_info);

                    $user = Zend_Auth::getInstance()->getIdentity();

                    if ($user_info["id"] == $user->id) {

                        $user->username = $user_info["username"];
                        if (isset($user_info["profpic"])) {
                            $user->profpic = $user_info["profpic"];
                        }
                        if (isset($user_info["signature"])) {
                            $user->signature = $user_info["signature"];
                        }
                    } else {
                        $this->view->message = "user updated successfully";
                    }
                }
            }
            $user_model = new Application_Model_User();
            $user = $user_model->getUserById($id);

            $form->populate($user[0]);
            $this->view->form = $form;
            $this->view->image = $user[0]['signature'];
            $this->view->profpic = $user[0]['profpic'];
        } else {
            $this->redirect('user/error');
        }
    }

    public function deleteuserAction() {
        if ($this->_request->isPost()) {
            $cond = 'id= ' . $this->_request->getParam('id');
            $user_model = new Application_Model_User;
            $user_model->deleteUser($cond);
            exit;
        }
    }

    public function systemclosedAction() {
        
    }

    public function logoutAction() {

        $auth = Zend_Auth::getInstance();

        $auth->clearIdentity();
        $this->redirect("user/login");
    }

    public function errorAction() {
        
    }
    public function forgetpasswordAction(){
        $form  = new Application_Form_forgetpassword();

        
        if($this->getRequest()->isPost()){
        $user_model = new Application_Model_User();
       
        $email=$this->_request->getParam('email');
        
       if($form->isValid($this->_request->getParams())){
       
        $userId=$user_model->getuserbyemail($email); 
        $userName=$userId[0]['username'];
        $userId=$userId[0]['id'];
        
        $this->sendmailpassword($email,$userId,$userName);
        $this->redirect("user/login");
        }
        
        
        }    
        $this->view->form=$form;
    }
    
     public function setpasswordAction(){
        $form  = new Application_Form_setpassword();

         if($this->getRequest()->isPost()){
              if ($form->isValid($this->_request->getParams())) {
                $data = $this->_request->getParams();
                $user_model = new Application_Model_User();
                $ndata['id']=$data['id'];
                $ndata['password']=$data['password'];
                $user_model->editUser($ndata);
                $this->redirect("user/login");
              }

        }    
        $this->view->form=$form;
        
           
        
    }
    
}
