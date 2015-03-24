<?php


  class Application_Model_System  extends Zend_Db_Table_Abstract
{

    protected $_name = "system";  //table name in database

     
    
    function getStatus(){   
       return $this ->fetchAll()->toArray();
    }
    
    function updateStatus($data){   
       return $this ->update($data, 'id=1');
    }
    
    

}

