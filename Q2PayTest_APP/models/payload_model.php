<?php
class payload_model extends CI_Model{ //Inicio

    public function __construct(){
        parent::__construct();
    }



    public function api_payload(){//Inicio

    $transacao = $this->input->post('transacao');


    if(isset($transacao)){//Verifica se vem algo no POST
    
    $this->db->where('codigo',$transacao);//Get no payload
    $payload = $this->db->get('payload');    
    
    if($payload->num_rows() > 0){//Verifica se existe a transação

    $row = $payload->row();//Gera uma row para pegar os dados da tabela     

    $result = array(//Array q transforma em Json e encoda
    'status'=>'true',
    'codigo' => $row->codigo,
    'valor_enviado' => $row->valor_enviado,
    'data' => $row->data
    );
    echo json_encode($result);   //Mostra resultados na tela

    }else{
    $result = array(
    'status'=>'false'
    );
    echo json_encode($result);  //Resultados de erro na tela 
    }
      }
    
    }//Fim do inicio da linha 10


}//Final da Linha 2