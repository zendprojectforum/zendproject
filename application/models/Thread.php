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
        $select->where("forum_id ={$forumid}");
        $select->order('isSticky DESC');
        $stmt = $select->query();
        $result = $stmt->fetchAll();
        return $result;
        
        
        
     }

    function addReply($data){      
       return  $this->insert($data);

    }
 function addthread($data){      
        $row = $this->createRow();
        $row->body = $data['newthread'];
        $row->threadTitle = $data['threadtitle'];
        $row->isLocked = 0;
        $row->forum_id = $data['forumId'];
       
        return $row->save();

    }
    
    function stickthread($threadid,$forumid){      
        $select = $this->select();
        
        //get sticky and mark as un sticky
        $select->from('thread');
        $select->where('forum_id = ?', $forumid);
        $stmt = $select->query();
        $result = $stmt->fetchAll();
        
        for($i=0;$i<count($result);$i++){
         
         $this->update(array('isSticky'=>0), "threadId={$result[$i]['threadId']} and threadId != $threadid");
        
         
        }
        
        ////////////////////////////////
        $select = $this->select();
        $select->from('thread');
        $select->where('threadId = ?', $threadid);
        $stmt = $select->query();
        $result = $stmt->fetchAll();
              

        return $this->update(array('isSticky'=>!$result[0]["isSticky"]), "threadId={$threadid}");
        

    }
    
  }

