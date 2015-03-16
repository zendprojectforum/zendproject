<?php

class Application_Model_Category extends Zend_Db_Table_Abstract
{

     protected $_name = "category";  //table name in database

     function categories(){
        
        return $this->fetchAll()->toArray();
     }
    
    
}

