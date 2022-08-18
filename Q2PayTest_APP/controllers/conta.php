<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Conta extends CI_Controller {//Inicio Controller

    public function __construct(){
        parent::__construct();
    }

    public function index(){//Home - DashBoard

    $data['titulo'] = 'Backoffice';

    $data['extrato_registros'] = $this->conta_model->Extrato();

    $this->load->view('conta/templates/header', $data);
    $this->load->view('conta/index');
    $this->load->view('conta/templates/footer');
    }

    public function TransferirSaldo(){//Função de transferencia de saldo

    $data['titulo'] = 'TransferirSaldo';

    if($this->input->post('submit')){
    $data['message'] = $this->conta_model->TransferirSaldo();
    }

    $this->load->view('conta/templates/header', $data);
    $this->load->view('conta/send');
    $this->load->view('conta/templates/footer');
    }


    public function sair(){//Função de Deslogar.
    $this->native_session->unset_userdata('user_id');
    redirect('login');
    }

}//Fim da linha 3