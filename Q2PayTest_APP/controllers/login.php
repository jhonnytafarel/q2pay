<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {//Inicia

public function __construct(){
	parent::__construct();
}

public function index(){//Inicio

if($this->native_session->get('user_id')){ // Se o usuario estiver Logado ele vai redirecionar para /conta
    redirect('conta');
}

$data = array(); // Cria uma data

if($this->input->post('submit')){ //Aqui se requisitar o SUBMIT, Vai executar o codigo de UsuarioModel => Logar.
$data['message'] = $this->usuario_model->Logar(); 
}
//Finaliza

$this->load->view('login', $data);// Aqui ele da um Load no Login $data = ele tras o que ta vendo no Model. Ou seja os returns
}//Finaliza Linha: 9


}//Finaliza Linha: 3