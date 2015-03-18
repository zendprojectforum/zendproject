<?php

class Application_Model_Reply  extends Zend_Db_Table_Abstract
{

    protected $_name = "reply";  //table name in database

     
    
    function getReplies($id){
        
       
       $this->select()
        ->where('thread_id = ?', $id);
       return $this ->fetchAll()->toArray();
    
       
    }
    
    
     

}




