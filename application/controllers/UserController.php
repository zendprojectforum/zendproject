<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
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
                //$authAdapter->setCredential(md5($password));
                $authAdapter->setCredential($password); //*********//
                //authenticate
                $result = $authAdapter->authenticate();
                //echo $result;
                if ($result->isValid()) {

                    $auth = Zend_Auth::getInstance();
                    $storage = $auth->getStorage();
                    $storage->write($authAdapter->getResultRowObject(array('email', 'id', 'name')));
                    //$this->redirect("thread/showthread/id/1");





                    /*****************************************************************/
                  /*  if ($form->image->isUploaded()) {
                        $source = $form->image->getFileName();
                        echo $source;
                        exit;
                        //to re-name the image, all you need to do is save it with a new name, instead of the name they uploaded it with. Normally, I use the primary key of the database row where I'm storing the name of the image. For example, if it's an image of Person 1, I call it 1.jpg. The important thing is that you make sure the image name will be unique in whatever directory you save it to.

                        $new_image_name = 'someNameYouInvent.jpg';

                        //save image to database and filesystem here
                        $image_saved = move_uploaded_file($source, 'media/images/' . $new_image_name);
                        if ($image_saved) {
                          echo "ok";
                        }
                    }*/
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
                $user_model = new Application_Model_User();
                $user_model->addUser($user_info);
            }
        }

        $this->view->form = $form;
    }

    
    
    public function listusersAction()
    {
        $user_model = new Application_Model_User;
        $users  = $user_model->getUsers();
        $this->view->users = $users;
        
    }
    
    public function banAction(){
        if ($this->_request->isPost()){
           $data['isBan']= $this->_request->getParam('status'); 
           $cond='id= '.$this->_request->getParam('id');
           $user_model = new Application_Model_User;
           $user_model->ban($data , $cond);
           exit;

        }
        
    }
    
     public function makeadminAction(){
        if ($this->_request->isPost()){
           $data['isAdmin']= $this->_request->getParam('status'); 
           $cond='id= '.$this->_request->getParam('id');
           $user_model = new Application_Model_User;
           $user_model->admin($data , $cond);
           exit;

        }
     }
        
    public function deleteuserAction(){
        if ($this->_request->isPost()){
           $cond='id= '.$this->_request->getParam('id');
           $user_model = new Application_Model_User;
           $user_model->deleteUser($cond);
           exit;

        }
        
    }
        
}





