<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cadastrar extends CI_Controller {//Inicio

    public function __construct(){
        parent::__construct();
    }

    public function index(){

        $data = array();

        if($this->input->post("submit")){//Se requisitar o SUBMIT do cadastro vai executar o codigo abaixo.

        $data['message'] = $this->usuario_model->NovoUsuario();//Usuario Model/Função Novo usuario

        }

        $this->load->view('cadastrar', $data);//Ele da View no cadastrar.php.
    }

}//Fim Linha 3