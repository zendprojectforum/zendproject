<?php

class UserController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
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
                var_dump($user_info);
                $user_mdl->addUser($user_info);
                
                
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
        
        $id = ($this->_request->getParam('id'));
        echo $id;
        if (!empty($id)){
        $form = new Application_Form_User();
        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getParams())) {
                $user_info = $form->getValues();
                $user_model = new Application_Model_User();
                $user_model->editUser($user_info);
                $this->view->message= "user updated successfully";
            }
        }
            
            $user_model = new Application_Model_User();
            $user = $user_model->getUserById($id);
            var_dump($user);

            
            $form->getElement("password")->setRequired(false);
            $email = $form->getElement("email");
            $email->removeValidator('Db_NoRecordExists');
            
            $form->populate($user[0]);
            $this->view->form = $form;
            $this->view->image = $user[0]['signature'];
        }
        else {
	$this->render('error');
 
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

}
