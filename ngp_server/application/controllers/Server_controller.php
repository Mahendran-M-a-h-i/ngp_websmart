<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
class Server_controller extends REST_Controller {

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('Server_model','server');
        $this->session->set_userdata(array('userid'=>1));
    }

    public function index_get(){
        $answers = $this->server->get_answers(0);
        $this->response($answers, REST_Controller::HTTP_OK);                           
    }

    public function index_post()
    {
        $input = $this->input->post();
        $input['userid']=$this->session->userdata('userid');
        $result = $this->server->post_answers($input);
        if($result){
            //$this->response(['Answered successfully.'], REST_Controller::HTTP_OK);
            $answers = $this->server->get_answers($result);
            if($answers){
                $this->response($answers, REST_Controller::HTTP_OK);
            }
           else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'something went wrong..!'
                ], REST_Controller::HTTP_NOT_FOUND);
           }
        }
        else{
            $this->response([
                'status' => FALSE,
                'message' => 'something went wrong..!'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    } 

    public function vote_answer(){
        $data['userid']=$this->session->userdata('userid');
        $data['questionid'] = $this->input->post('questionid');
        $data['answerid'] = $this->input->post('answerid');
        $data['vote'] = $this->input->post('vote');
        $data['mode'] = $this->input->post('mode');
        $result = $this->server->post_vote($data);
        if($result){
            $this->response($result, REST_Controller::HTTP_OK);
        }
       else{
            $this->response([
                'status' => FALSE,
                'message' => 'something went wrong..!'
            ], REST_Controller::HTTP_NOT_FOUND);
       }
    }

    public function bookmark_answer(){
        $data = $this->input->post();
        $data['userid']=$this->session->userdata('userid');
        
        $result = $this->server->book_mark_answer($data);
        if($result){
            $this->response($result, REST_Controller::HTTP_OK);
        }
       else{
            $this->response([
                'status' => FALSE,
                'message' => 'something went wrong..!'
            ], REST_Controller::HTTP_NOT_FOUND);
       }
    }

    public function make_answer(){
        $data = $this->input->post();
        $data['userid']=$this->session->userdata('userid');
        
        $result = $this->server->make_answer($data);
        if($result){
            $this->response($result, REST_Controller::HTTP_OK);
        }
       else{
            $this->response([
                'status' => FALSE,
                'message' => 'something went wrong..!'
            ], REST_Controller::HTTP_NOT_FOUND);
       }
    }

    public function make_filter(){
        $data = $this->input->post();
        $data['userid']=$this->session->userdata('userid');
        
        $result = $this->server->make_filter($data);
        //var_dump($result['message']);return;
        if($result){
            $res_row='';
            if(!empty($result['message'])){
                foreach($result['message'] as $row){
                    if($row->answered==1){
                        $answered=' answered';
                        $loadbtn='';$readed='readonly';
                    }else{
                        $answered=$readed='';
                        $loadbtn='<div class="submit-answer form-inline">
                                    <button class="answer-btn" onClick="submit_answer('.$row->questionid.',this)" id="submitanswer">SUBMIT</button>
                                </div>';
                    }
                    $res_row.= '<div class="br-4 mt-5 row bg-gray">
                        <div class="col-1 vote-container form-inline">
                            <p class="w-100 vote-value vote_'.$row->questionid.'">'.$row->vote.'</p>
                            <span onclick="vote_answer('.$row->questionid.','.$row->answerid.','.$row->vote.',1)" class="w-50 vote-plus vote_plus_'.$row->questionid.'"></span><span onclick="vote_answer('.$row->questionid.','.$row->answerid.','.$row->vote.',0)" class="w-50 vote-minus  vote_minus_'.$row->questionid.'"></span>
                        </div>
                        <div class="col-11  form-inline">
                        <div class="'.$row->bookmarkclass.' bookmark_'.$row->questionid.'_'.$row->answerid.'" onclick="bookmark_question('.$row->questionid.','.$row->answerid.','.$row->bookmarked.')"></div>
                            <div class="col-11 form-inline">
                                <p class="view-question">'.$row->question.'</p>
                                <textarea class="answer-box'.$answered.' answer_for_'.$row->questionid.'" rows="2" '.$readed.'>'.$row->answer.'</textarea>
                            </div>
                            '.$loadbtn.'
                            <div class="col-12 jc-fd form-inline">
                                <p class="ques_time">'.$row->creationtime.'</p>
                            </div>
                        </div>
                    </div>';
                }
            }
            //var_dump($res_row);
            $this->response($res_row, REST_Controller::HTTP_OK);
        }
       else{
            $this->response([
                'status' => FALSE,
                'message' => 'something went wrong..!'
            ], REST_Controller::HTTP_NOT_FOUND);
       }
    }
}
?>
