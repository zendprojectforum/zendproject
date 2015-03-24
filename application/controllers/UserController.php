<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
     

        $action = $this->getRequest()->getActionName();
        $authorization =Zend_Auth::getInstance();
             if(!$authorization->hasIdentity()) {
             
               if (!(($action == "login") || ($action == "register" )))
                      $this->redirect("user/login");
             }
             else {
               if (($action == "login" ) || ($action == "register" ) ){
                      $this->redirect("category/getcategory");
               }
               else
               {$info =     $authorization->getIdentity ();
                if(isset($info->system)){
                    $this->redirect("system/systemclosed");
                } 
                else{
                   // $name = $info->name ;
                    if((!$info->isAdmin) &&($action == "listusers" )){
                      $this->redirect("user/error");
                  }
                }
                  
                    
               }
       }
       
      
    }
    public function indexAction()
    {
        // action body
    }
    private function sendmail($userinfo){
       
            $mail = new Zend_Mail();
            $email=(string)($userinfo['email']);
            $mail->addTo($email);
           
            $mail->setSubject('fatkat');
            $new="welcome to our website here is your info to change it login to the web site :"." \n";
            foreach ($userinfo as $name => $value)
            {
                $new .=" ";
                $new .= $name;
                $new .= ":";
                $new .= $value;
                $new .="\n ";
                
            }
            
            $mail->setBodyText($new);
          
            $mail->setFrom('mertloka@gmail.com', 'User Name');
            
            //Send it!
            $sent = true;
             
               
            try {
                $mail->send();
            } catch (Exception $e){
               
                  echo $e;exit;
                $sent = false;
            }

            //Do stuff (display error message, log it, redirect user, etc)
            if($sent){
                //Mail was sent successfully.
            } else {
                
               
                //Mail failed to send.
            }
        
    }
    public function loginAction()
    {
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
                    $data = $authAdapter->getResultRowObject('isAdmin','pass');
                    if(!$data->isAdmin){
                        $sys_mdl = new Application_Model_System();
                        $status = $sys_mdl->getStatus()[0]['status'];
                        
                        if (!$status){ //system closed
                            $storage->write(array('system'=> 'closed'));
                            $this->redirect('user/systemclosed');
                

                        }
                        
                    }
                    
                    
                    $storage->write($authAdapter->getResultRowObject(array('id', 'username', 'signature', 'isAdmin', 'isBan')));
                    $this->redirect("thread/showthread/id/1");
                } else {
                    echo "not auth";
                    $message = "Invalid username or password";
                    $this->view->message = $message;
                }
            }
        }

        $this->view->form = $form;
    }

    public function registerAction()
    {
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
                var_dump($user_info);
                $user_mdl->addUser($user_info);
                $this->sendmail($user_info);
                $this->redirect("user/login");
            }
        }

        $this->view->form = $form;
    }

    public function listusersAction()
    {
        $user_model = new Application_Model_User;
        $users = $user_model->getUsers();
        $this->view->users = $users;
    }

    public function banAction()
    {
        if ($this->_request->isPost()) {
            $data['isBan'] = $this->_request->getParam('status');
            $cond = 'id= ' . $this->_request->getParam('id');
            $user_model = new Application_Model_User;
            $user_model->ban($data, $cond);
            exit;
        }
    }

    public function makeadminAction()
    {
        if ($this->_request->isPost()) {
            $data['isAdmin'] = $this->_request->getParam('status');
            $cond = 'id= ' . $this->_request->getParam('id');
            $user_model = new Application_Model_User;
            $user_model->admin($data, $cond);
            exit;
        }
    }

    public function editAction() {
        
       
        $id = ($this->_request->getParam('id'));
        if (!empty($id)) {
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

                    var_dump($user_info);
                
                    //save images
                    if ($user_info["signature"] != NULL) {
                       
                        $source = $form->signature->getFileName();
                        $ext = "." . pathinfo($source)['extension'];
                        $destination = "media/images/" . $id . $ext;
                        chmod($source, 0777);
                        rename($source, $destination);
                        $user_info['signature'] = "$id$ext";
                    }else{
                        unset($user_info['signature']);
                    }

                    if ($user_info["profpic"] != NULL) {

                        $source = $form->profpic->getFileName();
                        $ext = "." . pathinfo($source)['extension'];
                        $destination = "media/profile/" . $id . $ext;
                        chmod($source, 0777);
                        rename($source, $destination);
                        $user_info['profpic'] = "$id$ext";
                    }else{
                        echo "kjhgf";
                        unset($user_info['profpic']);
                    }
                    
                    //var_dump($user_info);
                    //exit;

                  



                    $user_model->editUser($user_info);
                    
                    $user = Zend_Auth::getInstance()->getIdentity();

                    if ($user_info["id"]== $user->id){
                      
                        $user->username = $user_info["username"];
                        if(isset ($user_info["profpic"])){
                            $user->profpic = $user_info["profpic"];
                        }
                        if(isset ($user_info["signature"])){
                            $user->signature = $user_info["signature"];
                        }
                        
                    }else{
                        $this->view->message = "user updated successfully";
                    }
                }
            }
            $user_model = new Application_Model_User();
            $user = $user_model->getUserById($id);

            $form->populate($user[0]);
            $this->view->form = $form;
            $this->view->image = $user[0]['signature'];
        } else {
            $this->render('error');
        }
    }


    public function deleteuserAction()
    {
        if ($this->_request->isPost()) {
            $cond = 'id= ' . $this->_request->getParam('id');
            $user_model = new Application_Model_User;
            $user_model->deleteUser($cond);
            exit;
        }
    }

    public function systemclosedAction()
    {
        
    }
    public function logoutAction() {

        $auth = Zend_Auth::getInstance();

        $auth->clearIdentity();
        $this->redirect("user/login");
    }

    public function errorAction(){
        
    }
    
}


