<?php

class Application_Model_Thread  extends Zend_Db_Table_Abstract
{
    protected $_name = "thread";  //table name in database

     
    
    function getThreadById($id){
        
        return $this->find($id)->toArray();
       
    }
    
    
     

}

