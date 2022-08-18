<?php
class Usuario_model extends CI_Model{//Inicio Ifen Class

    public function __construct(){
        parent::__construct();
    }

    public function NovoUsuario(){//Inicio Linha 8

        //Dados vindo via Post
        $nome = $this->input->post('nome');
        $cpf_cnpj = $this->input->post('cpf_cnpj');
        $email = $this->input->post('email');
        $senha = $this->input->post('senha');
        $repetir_senha = $this->input->post('repetir_senha');
        //Fim dos Dados via Post

        //Retirada de caracteres variaveis acima
        $cpf_cnpj = str_replace(".", "", $cpf_cnpj);
        $cpf_cnpj = str_replace("-", "", $cpf_cnpj);
        $cpf_cnpj = str_replace("/", "", $cpf_cnpj);
        //Finaliza.

        //Consultas de Email e CPF/CNPJ
        $this->db->where('email', $email);
        $user_email = $this->db->get('usuarios');

        $this->db->where('cpf_cnpj', $cpf_cnpj);
        $user_cpf_cnpj = $this->db->get('usuarios');
        //Fim das Consultas


        //Consultas se Existe Email e Consulta se Existe CPF CNPJ
        if($user_email->num_rows() > 0){
        return '<div class="alert alert-danger text-center">Email já cadastrado.</div>';
        }

       
        if($user_cpf_cnpj->num_rows() > 0){
        return '<div class="alert alert-danger text-center">CPF ou CNPJ já cadastrado.</div>';
        }
        //Fim das Consultas.

        //Consulta Senhas conferem
        if($repetir_senha != $senha){
        return '<div class="alert alert-danger text-center">Senhas não conferem</div>';        
        }
        //Finaliza Consulta de Senha.

        //Verifica o numero de caracteres.. essa funçao vai definir se é CNPJ ou CPF.. 11 = CPF 14 = CNPJ..... bool 1 e 2
        $contagem =  mb_strlen($cpf_cnpj);//contando qntidade de numeros vindo

        if($contagem > 11){//Se contagem > 11 ..CNPJ / Tipo = 2
        $tipo = 2;
        $saldo = 0;  //Valor inserido no saldo  
        }else{//Caso não seja então é CPF.
        $tipo = 1; 
        $saldo = 99999; //Valor para teste    
        }
        //Finaliza Verificação.


        //Insere o cadastro no Banco de dados
        $array_cadastro = array(
                                'nome'=>$nome,
                                'cpf_cnpj'=>$cpf_cnpj,
                                'email'=>$email,
                                'senha'=>md5($senha),//Converte a senha em MD5
                                'saldo'=>$saldo,//Valor acima se CPF = 99999 CNPJ = 0 ISSO PARA TESTE
                                'tipo'=>$tipo//1 = CPF .. 2 = CNPJ Variavel acima.
                                );
        $cadastra = $this->db->insert('usuarios', $array_cadastro);
        //Finaliza Inserção no Banco de dados.

        if($cadastra){//Verifica se foi Inserido corretamente no banco de dados.

        return '<div class="alert alert-success text-center">Usuario Cadastrado com Sucesso.</div>
                <meta http-equiv="refresh" content="2; URL="login"/>';

        }

        return '<div class="alert alert-danger text-center">Não foi possível completar seu cadastro.</div>
                <meta http-equiv="refresh" content="2; URL="cadastrar"/>';
    

        }//Finaliza Iniciado Linha 8


    public function Logar(){//Inicio Linha 154

        $email = $this->input->post('email');//Email pegando via Post
        $senha = $this->input->post('senha');//Senha pegando Via Post

        //Aqui ele vai requisitar o Banco de dados, e os dados vindo via post estão 100%
        $this->db->where('email', $email);
        $this->db->where('senha', md5($senha));

        $usuario = $this->db->get('usuarios');
        //Finaliza consulta no banco de dados.

        //Se a variavel acima for maior que 0, Ou seja se ela exise
        if($usuario->num_rows() > 0){//Inicio

        $row = $usuario->row(); //Pega dados do usuario...    

        $this->native_session->set('user_id', $row->id); // Aqui ele vai criar a sessão Usando o ID do usuario

        redirect('conta'); // Aqui vai redirecionar para /Conta

        }else{
        
        //Caso os dados acima esteja errado ele retorna esse erro na tela de usuario.
    
        return '<div class="alert alert-danger text-center">Email ou senha Inválidos</div>';

        }//Final Iniciado Linha 167


        }//Final Iniciado Linha 154



//Fim Iniciado Linha 2
}
?>