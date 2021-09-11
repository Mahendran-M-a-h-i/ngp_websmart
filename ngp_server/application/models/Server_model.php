<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Server_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    public function get_answers($id){
        if($id){
            $query= $this->db->query("select *,case when temp_table.bookmarked=1 then 'bookmarked' else 'bookmark' end as bookmarkclass,case when temp_table.answerid=0 then 0 else 1 end as answered from (select question_master.questionid,ucase(question_master.question)as question,question_master.inserted_datetime as creationdate,COALESCE(answer_master.answerid,0)as answerid,answer_master.answer,
            COALESCE((select sum(vote) from vote_master where question_master.questionid=vote_master.questionid ),0)as vote,
            COALESCE((select bookmarked from bookmark_master where question_master.questionid=bookmark_master.questionid ),0)as bookmarked
            from question_master
             LEFT JOIN answer_master ON question_master.questionid=answer_master.questionid where question_master.questionid=".$id."
            GROUP BY question_master.questionid ORDER BY question_master.questionid desc)as temp_table");
        }else{
            $query= $this->db->query("select *,case when temp_table.bookmarked=1 then 'bookmarked' else 'bookmark' end as bookmarkclass,case when temp_table.answerid=0 then 0 else 1 end as answered from (select question_master.questionid,question_master.question,question_master.inserted_datetime as creationtime,COALESCE(answer_master.answerid,0)as answerid,answer_master.answer,
            COALESCE((select sum(vote) from vote_master where question_master.questionid=vote_master.questionid),0)as vote,
            COALESCE((select bookmarked from bookmark_master where question_master.questionid=bookmark_master.questionid ),0)as bookmarked
            from question_master
             LEFT JOIN answer_master ON question_master.questionid=answer_master.questionid 
            GROUP BY question_master.questionid ORDER BY question_master.questionid desc)as temp_table order by answerid asc,questionid asc");
        }
        return $query->result();
    }
    
    public function post_answers($data){
        $this->db->trans_begin();
        $this->db->insert('question_master',$data);
        $last_id= $this->db->insert_id();
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            return $last_id;
        }
    }

    public function post_vote($data){
        $err_log=array('status'=>200,'message'=>'');
        if($data['mode']==1) $vote=1; else $vote=-1;

        $result=$this->db->get_where('answer_master',array('questionid'=>$data['questionid']));
        if($result->num_rows()<=0){
            $err_log['message']= 'Not allowed for vote, answered not yet..!';
            $err_log['status']=409;return $err_log;
        }
        $result=$this->db->get_where('vote_master',array('questionid'=>$data['questionid'],'userid'=>$data['userid']));
        if($result->num_rows()>0){
            $err_log['message']= 'One user can vote one time for a question..!';
            $err_log['status']=409;
        }else{
            $ins=array('userid'=>$data['userid'],'questionid'=>$data['questionid'],'answerid'=>$data['answerid'],'vote'=>$vote);
            $this->db->trans_begin();
            $this->db->insert('vote_master',$ins);
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return false;
            }else{
                $this->db->trans_commit();
                
                $err_log['message']= $data['vote']+$vote;
            }
        }
        return $err_log;
    }

    public function book_mark_answer($data){
        $err_log=array('status'=>200,'message'=>'');
        if($data['bookmarked']==0){
            $data['bookmarked']=1;
            $this->db->trans_begin();
            $this->db->insert('bookmark_master',$data);
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return false;
            }else{
                $this->db->trans_commit();
                $err_log['message']= 'Question was bookmarked successfully..!';
            }
        }else{
            $this->db->trans_begin();
            $this->db->where($data);
            $this->db->delete('bookmark_master');
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return false;
            }else{
                $this->db->trans_commit();
                $err_log['message']= 'Bookmark was removed successfully..!';
            }
        }
        return $err_log;
    }

    public function make_answer($data){
        $err_log=array('status'=>200,'message'=>'');
        $this->db->trans_begin();
        $this->db->insert('answer_master',$data);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            $err_log['message']= 'Question answered successfully..!';
        }
        return $err_log;
    }

    public function make_filter($data){
        $err_log=array('status'=>200,'message'=>'');

        
        $this->db->select('question_master.questionid,question_master.question, COALESCE(answer_master.answerid,0)as answerid,answer_master.answer,COALESCE(sum(vote_master.vote),0)as vote,question_master.inserted_datetime as creationtime,bookmark_master.bookmarked,case when COALESCE(answer_master.answerid,0)=0 then 0 else 1 end as answered,case when bookmark_master.bookmarked=1 then "bookmarked" else "bookmark" end as bookmarkclass',false);
        $this->db->from('question_master');
        $this->db->join('answer_master','question_master.questionid=answer_master.questionid','left');
        $this->db->join('bookmark_master','question_master.questionid=bookmark_master.questionid','left');
        $this->db->join('vote_master','vote_master.questionid=question_master.questionid ','left');
        
        if($data['filter']=='bookmark'){
            $this->db->where('bookmark_master.userid',$data['userid']);
            $this->db->where('bookmark_master.bookmarked',1);
            $this->db->order_by('question_master.questionid desc');
        }
        if($data['filter']=='vote'){
            $this->db->order_by('COALESCE(sum(vote_master.vote),0) desc');
        }
        if($data['filter']=='time'){
            $this->db->where('question_master.userid',$data['userid']);
            $this->db->order_by('question_master.inserted_datetime');
        }
        $this->db->group_by('question_master.questionid');
        $query = $this -> db -> get();
        $result=$query->result();
        //echo $this->db->last_query();
        $err_log['message']=$result;
        return $err_log;
    }
}
?>

