<?php

class Application_Model_User extends Zend_Db_Table_Abstract
{

    protected $_name = "user";  //table name in database

    function getuserbyemail($email){
        
       
        $select = $this->select();
        $select->from('user');
        $select->where('email = ?', $email);
        $stmt = $select->query();
        $result = $stmt->fetchAll();
        return $result;
        
        
        
     }
    
    
     
    function getLastId(){
        $select= $this->select()
            ->from($this,array('max(id)')); // you could also include the 'as' statement in the field name to make it look like 'id as otherName'
        return $this->fetchAll($select)->toArray();
    }
    
    function getUserById($id){  
       
      return $this->find($id)->toArray();
    }
    
    function getUsers(){   
      $select =  $this->select();
       return $this ->fetchAll($select)->toArray();
       
    }
    
    function editUser($data){
        if(!empty($data['password'])){
            $data['password']=md5($data['password']);
        }
     
        $this->update($data, "id=".$data['id']);
        return $this->fetchAll()->toArray();
    }
    
    function ban($data , $where){
        return $this->update($data, $where);
        
    }
   
     function admin($data , $where){
        return $this->update($data, $where);
        
    }
    
     function addUser($data){
         
        $data['password'] = md5 ($data['password']);
        return $this->insert($data);
        
    }
    
    
    function deleteUser($cond){        
        return $this->delete($cond);
    }
    

}

