<?php

class Application_Model_Reply  extends Zend_Db_Table_Abstract
{

    protected $_name = "reply";  //table name in database

     
    
    function getReplies($id){   
      $select =  $this->select()
        ->where('thread_id = ?', $id);
       return $this ->fetchAll($select)->toArray();
       
    }
    
     function addReply($data){      
       return  $this->insert($data);

    }
    
    function updateReply($data , $where){
        return $this->update($data, $where);
        
    }
    
     function deleteReply($cond){      
       return  $this->delete($cond);

    }
    
    function getLastReply($data){
        //$this->select();
        $select = $this->select()
                ->where("thread_id = ?", $data['thread_id'])
                ->where("user_id = ?", $data['user_id'])
                ->order('Date DESC')
                ->limit(1);
                               
       return $this ->fetchAll($select)->toArray();
        
                
    }
    
    
    
    
     

}




