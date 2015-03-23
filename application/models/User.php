<?php

class Application_Model_User extends Zend_Db_Table_Abstract
{

    protected $_name = "user";  //table name in database

     
    
    function getUserById($id){  
       
      return $this->find($id)->toArray();
    }
    
    function getUsers(){   
      $select =  $this->select();
       return $this ->fetchAll($select)->toArray();
       
    }
    
    function ban($data , $where){
        return $this->update($data, $where);
        
    }
   
     function admin($data , $where){
        return $this->update($data, $where);
        
    }
    
    function deleteUser($cond){        
        return $this->delete($cond);
    }
    

}

