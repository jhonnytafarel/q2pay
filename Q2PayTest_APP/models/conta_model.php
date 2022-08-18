<?php
class Conta_model extends CI_Model{ //Inicio

    public function __construct(){
        parent::__construct();
    }

    
    public function user($coluna, $parametro = null){//Inicio

    if(!$this->native_session->get('user_id')) redirect('login'); //Aqui ele verifica se a pessoa ta logada.. 

    $sessao = $this->native_session->get('user_id'); //Pega ID Via sessão

    $this->db->where('id', $sessao);//Faz um get em usuarios com o ID
    $user = $this->db->get('usuarios');

    $row = $user->row(); //Cria uma variavel que busca tudo em Usuairos

    if(is_null($parametro)){
    return $row->$coluna;
    }

    preg_match('/[^\s]*/i', $row->$coluna, $matches);

    return $matches[0];
    }//Fim Linha 9


    public function InserirExtrato($codigo, $sessao, $mensagem, $valor, $cor){//Inicio

    $array_extrato = array(//Array para inserir Extrato.
                            'codigo'=>$codigo,
                            'id_user'=>$sessao,
                            'valor'=>$valor,
                            'descricao'=>$mensagem,
                            'cor'=>$cor,
                            'data'=>date('Y-m-d')
                            );

    $this->db->insert('extrato', $array_extrato);
    
    }//Fim linha 31

    public function Extrato(){//Inicio

    $sessao = $this->native_session->get('user_id');//Pega ID Via Sessão

    $this->db->where('id_user', $sessao);//Faz um get na tabela Extrato
    $this->db->limit(15);
    $this->db->order_by('id', 'DESC');

    $extrato = $this->db->get('extrato');

    if($extrato->num_rows() > 0){//Se retornar > 1 ele da um result na tabela.
    return $extrato->result();
    }//Caso contrario ele retorna false. Ou seja Nada.
    return false;
    }//Fim Linha 48


    public function TransferirSaldo(){//Inicio

    $sessao = $this->native_session->get('user_id');//Pega ID Via Sessão

    $this->db->where('id', $sessao);//Faz um get em usuarios com o ID
    $user = $this->db->get('usuarios');

    $row = $user->row(); //Cria uma variavel que busca tudo em Usuairos

    //Verifica se uma pessoa CNPJ está tentando enviar 
    if($row->tipo == 2 ){
    return '<div class="alert alert-danger text-center">CNPJ Não pode Transferir Saldo</div>';   
    }//Fim


    //Inicio dos Input Post
    $valor = $this->input->post('valor');//Valor vindo via Post 
    $email_a_enviar = $this->input->post('email_a_enviar');//Email a ser Enviado.
    //Fim das variaveis Post.

    //Verifica se esta enviando um valor 0
    if($valor < 1 ){
    return '<div class="alert alert-danger text-center">O minimo para Transferencia é de R$1,00</div>';   
    }//Fim

    //Verifica se o email tentando enviar o saldo é igual da propria pessoa.
    if($email_a_enviar == $row->email){
    return '<div class="alert alert-danger text-center">Você não pode Transferir para si mesmo.</div>';   
    }//Fim

    //Inicio Verificação se o Email vindo por Post existe no banco de dados.
    $this->db->where('email', $email_a_enviar);//Faz um get em usuarios com o email que vem por POST.
    $email = $this->db->get('usuarios');

    if($email->num_rows() == 0 ){//Se o Email não existir ou seja Numero 0 na DB.... Retorna erro.
    return '<div class="alert alert-danger text-center">Este Email não existe, revise o seus dados.</div>';   
    }//Fim

    //Inicia a verificação agora da API pedida por vocês.
    $url = "https://run.mocky.io/v3/d02168c6-d88d-4ff2-aac6-9e9eb3425e31";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
       "Content-Length: 0",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);
    curl_close($curl);

    $json = json_decode($resp);//Decodifica o Json


    if($json->authorization == true){//Inicio verificação

    if($row->saldo >= $valor ){//Se o valor que tenho é = OU Maior que o valor vindo do post Executo o Codigo.

    $row_email = $email->row();  //pega dados da tabela usuarios do Email a Enviar o saldo.  
   
    //Retira o saldo do usuario 
    $this->db->where('id', $sessao);
    $this->db->update('usuarios', array('saldo'=>$row->saldo - $valor));
    //Finaliza

    //Envia o Saldo ao remetente
    $this->db->where('id', $row_email->id);
    $this->db->update('usuarios', array('saldo'=>$row_email->saldo + $valor));
    //Finaliza
    
    //Gera codigo
    $s1 = rand(10, 50);
    $s2 = rand(30, 99); //aqui óh preciso de 2 letras maiuscluals aleatorias
    $s3 = rand(1, 9999); //aqui óh preciso de 2 letras maiuscluals aleatorias
    $codigo = $s1.$s2.$row->id.$row_email->id.$s3;
    //Finaliza

    //Insere PayLoad
    $this->db->insert('payload', array('codigo'=>$codigo,'valor_enviado'=>$valor,'data'=>date('Y-m-d H:i:s')));
    //

    //Envia Extrato para Ambos usuarios.
    $this->InserirExtrato($codigo,$sessao, 'Transferência de saldo', '-'.$valor, 'red');
    $this->InserirExtrato($codigo,$row_email->id, 'Recebimento de saldo', $valor, 'green');

    return '<div class="alert alert-success text-center">Saldo Transferido com sucesso.!</div>';  

    }else{//Caso não seja. retorna um Erro.. que nao tenho saldo  ;X Sou pobre ^^
    return '<div class="alert alert-danger text-center">O seu saldo é insuficiente para essa transação.</div>';          
    }//Finaliza Linha iniciada 95

    }else{
    return '<div class="alert alert-danger text-center">Sem permissão para essa transação.</div>';      
    }//Fim da Linha iniciada 93

    }//Fim Linha 61


}//Final da Linha 2