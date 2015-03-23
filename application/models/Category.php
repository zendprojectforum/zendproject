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
    function listspecificcategory($catid){
        
       
        $select = $this->select();
        $select->from('category');
        $select->where('catId = ?', $catid);
        $stmt = $select->query();
        $result = $stmt->fetchAll();
        return $result;
        
        
        
     }
    function deletecategory($data){
        
        return $this->delete("catId=$data");
      
    }
    function editcategory($dataId,$dataname){
         
         return $this->update(array('catName'=>$dataname), "catId={$dataId}");
         
        }
    function lockcategory($dataId,$dataname){
           
         return $this->update(array('catIsLocked'=>$dataname), "catId={$dataId}");
         
    }    
    
}

