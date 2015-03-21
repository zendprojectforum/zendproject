<?php

class Application_Model_Thread  extends Zend_Db_Table_Abstract
{
    protected $_name = "thread";  //table name in database

     
    
    function getThreadById($id){
        
        return $this->find($id)->toArray();     
    }
    
     function updateThread($data , $where){
        return $this->update($data, $where);
        
    }
    
      function deleteThread($cond){      
       return  $this->delete($cond);

    }
    
     
      function listpoststospecificform($forumid){
        
       
        $select = $this->select();
        $select->from('thread');
        $select->where('forum_id = ?', $forumid);
        $stmt = $select->query();
        $result = $stmt->fetchAll();
        return $result;
        
        
        
     }

}

