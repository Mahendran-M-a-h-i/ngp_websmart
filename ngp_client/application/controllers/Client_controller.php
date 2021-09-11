<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Client_controller extends CI_Controller {

    var $api ="";
    function __construct() 
    {
        parent::__construct();
        $this->api="http://localhost/ngp_server/get-answer";
        $this->load->model('Client_model','home');
    }

    public function ask_question(){
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $this->api);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        $data['answer'] = curl_exec($curl_handle);
        return $this->load->view('index',$data);
    }
}