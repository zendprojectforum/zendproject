<?php

class Application_Model_Category extends Zend_Db_Table_Abstract
{

     protected $_name = "category";  //table name in database

     function listCategories(){
        
        return $this->fetchAll()->toArray();
     }
     
    function addcategory($data){
        $row = $this->createRow();
        $row->catName = $data['catName'];
       
        return $row->save();
        
    }
    function deletecategory($data){
        
        return $this->delete("catId=$data");
      
    }
    
}

