<?php

class Application_Model_User extends Zend_Db_Table_Abstract
{

    protected $_name = "user";  //table name in database

     
    
    function getUserById($id){  
       
      return $this->find($id)->toArray();
    }

}

