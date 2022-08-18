<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class payload extends CI_Controller {//Inicio Controller

    public function __construct(){
        parent::__construct();

    $this->load->model('payload_model');    
    }
    
    public function transacao(){
    $this->payload_model->api_payload();
    }

}//Fim da linha 3