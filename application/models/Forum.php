<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



class Application_Model_Forum extends Zend_Db_Table_Abstract
{

     protected $_name = "forum";  //table name in database

     function listforumstospecificcategory($catid){
        
       
        $select = $this->select();
        $select->from('forum');
        $select->where('cat_id = ?', $catid);
        $stmt = $select->query();
        $result = $stmt->fetchAll();
        return $result;
        
        
        
     }
     
     function listspecificforum($forumid){
        
       
        $select = $this->select();
        $select->from('forum');
        $select->where('forumId = ?', $forumid);
        $stmt = $select->query();
        $result = $stmt->fetchAll();
        return $result;
        
        
        
     }
     
    function listForums(){
        
        return $this->fetchAll()->toArray();
     }
    function addforum($data){
        $row = $this->createRow();
        $row->forumName = $data['forumName'];
        $row->cat_id = $data['cat_id'];
        $row->isLocked = $data['isLocked'];
       
        return $row->save();
        
     }

     function deleteforum($data){
        
        return $this->delete("forumId=$data");
      
    }
    function editforum($dataId,$dataname){
           
         return $this->update(array('forumName'=>$dataname), "forumId={$dataId}");
         
    }
    function lockforum($dataId,$dataname){
           
         return $this->update(array('isLocked'=>$dataname), "forumId={$dataId}");
         
    }
}

