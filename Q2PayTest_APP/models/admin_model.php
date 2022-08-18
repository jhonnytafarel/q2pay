<?php
class Admin_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    public function user($coluna){

        $sessao = $this->native_session->get('user_id_admin');

        $this->db->where('id', $sessao);
        $adm = $this->db->get('admin_login');

        $row = $adm->row();

        return $row->$coluna;
    }

    public function Login(){

        $login = $this->input->post('login');
        $senha = $this->input->post('senha');

        $this->db->where('login', $login);
        $this->db->where('senha', md5($senha));

        $login = $this->db->get('admin_login');

        if($login->num_rows() > 0){

            $this->native_session->set('user_id_admin', $login->row()->id);

            redirect('ctadmin/home');
        }

        return '<div class="alert alert-danger text-center">Usuário ou senha inválidos.</div>';
    }

    public function Usuarios(){

        $usuarios = $this->db->get('usuarios');

        if($usuarios->num_rows() > 0){

            return $usuarios->result();
        }

        return false;
    }

    public function TotalUsuarios(){

        $usuarios = $this->db->get('usuarios');

        return $usuarios->num_rows();
    }

    public function UltimosUsuarios(){

        $data_hoje = date('Y-m-d');
        $data_ultimos = date('Y-m-d', time() - (60*60*24*7));

        $usuarios = $this->db->query("SELECT * FROM usuarios WHERE data_cadastro BETWEEN '$data_ultimos' AND '$data_hoje'");

        return $usuarios->num_rows();
    }

    public function CotasAtivas(){

        $cotas = $this->db->query("SELECT COALESCE(SUM(quantidade), 0) AS qtd FROM cotas WHERE status = 1");

        $row = $cotas->row();

        return $row->qtd;
    }

    public function Recebimentos(){

        $cotas = $this->db->query("SELECT COALESCE(SUM(quantidade), 0) AS qtd FROM cotas");

        $row = $cotas->row();

        $soma = number_format(($row->qtd * config_site('valor_cota')), 2, ",", ".");

        return $soma;
    }

    public function SaquesPendentes(){

        $this->db->where('status', 0);
        $saques = $this->db->get('saques');

        return $saques->num_rows();
    }

    public function AtividadesMembros(){

        $usuarios = $this->db->query("SELECT u.nome, u.saldo_disponivel, data_cadastro, (SELECT COALESCE(SUM( c.quantidade ), 0) AS qtd FROM cotas AS c WHERE c.id_user = u.id AND c.status =1) AS quantidade_cotas, (SELECT COALESCE(SUM(IF(f.id, 1, 0)),0) AS qtdF FROM faturas AS f WHERE f.status = 0 AND f.id_user = u.id ) AS quantidade_faturas FROM usuarios AS u ORDER BY RAND() LIMIT 10");

        if($usuarios->num_rows() > 0){

            return $usuarios->result();
        }

        return false;
    }

    public function TodosAnuncios(){

        $anuncios = $this->db->query('SELECT u.login, a.* FROM anuncios AS a INNER JOIN usuarios AS u ON u.id = a.id_user');

        if($anuncios->num_rows() > 0){

            return $anuncios->result();
        }

        return false;
    }

    public function VisualizarAnuncio($id){

        $anuncio = $this->db->query('SELECT u.login, a.* FROM anuncios AS a INNER JOIN usuarios AS u ON u.id = a.id_user WHERE a.id ='.$id);

        return $anuncio->row();
    }

    public function DesativarAnuncio($id){

        $this->db->where('id', $id);
        $this->db->update('anuncios', array('status'=>0));
    }

    public function AprovarAnuncio($id){

        $this->db->where('id', $id);
        $this->db->update('anuncios', array('status'=>1));
    }

    public function ExcluirAnuncio($id){

        $this->db->where('id', $id);
        $this->db->delete('anuncios');
    }

    public function InformacaoUsuario($id){

        $this->db->where('id', $id);
        $user = $this->db->get('usuarios');

        return $user->row();
    }

    public function CotasUsuario($id){

        $this->db->order_by('status', 'DESC');
        $this->db->where('id_user', $id);

        $cotas = $this->db->get('cotas');

        if($cotas->num_rows() > 0){

            return $cotas->result();
        }

        return false;
    }

    public function ExtratoUsuario($id){

        $this->db->order_by('data', 'DESC');
        $this->db->where('id_user', $id);

        $extrato = $this->db->get('extrato');

        if($extrato->num_rows() > 0){

            return $extrato->result();
        }

        return false;
    }

    public function IndicadosUsuario($id){

        $query = $this->db->query("SELECT u.* FROM patrocinadores AS p INNER JOIN usuarios AS u ON u.id = p.id_usuario WHERE p.id_patrocinador = '$id'");

        if($query->num_rows() > 0){

            return $query->result();
        }

        return false;
    }

    public function EditarUsuario($id){

        $nome = $this->input->post('nome');
        $email = $this->input->post('email');
        $cpf = $this->input->post('cpf');
        $nascimento = converter_data($this->input->post('nascimento'));
        $celular = $this->input->post('celular');
        $senha = $this->input->post('senha');
        $block = $this->input->post('block');
        $saldo_disponivel = $this->input->post('saldo_disponivel');
        $saldo_bloqueado = $this->input->post('saldo_bloqueado');
        $banco = $this->input->post('banco');
        $agencia = $this->input->post('agencia');
        $conta = $this->input->post('conta');
        $tipo_conta = $this->input->post('tipo_conta');
        $titular = $this->input->post('titular');

        $array_usuario = array(
                                                'nome'=>$nome,
                                                'email'=>$email,
                                                'cpf'=>$cpf,
                                                'nascimento'=>$nascimento,
                                                'celular'=>$celular,
                                                'banco'=>$banco,
                                                'agencia'=>$agencia,
                                                'conta'=>$conta,
                                                'tipo_conta'=>$tipo_conta,
                                                'titular'=>$titular,
                                                'block'=>$block,
                                                'saldo_disponivel'=>$saldo_disponivel,
                                                'saldo_bloqueado'=>$saldo_bloqueado
                                                  );

        if(!empty($senha)){
            $array_usuario['senha'] = md5($senha);
        }

        $this->db->where('id', $id);
        $update = $this->db->update('usuarios', $array_usuario);

        if($update){

            return '<div class="alert alert-success text-center">Usuário atualizado com sucesso!</div>';
        }

        return '<div class="alert alert-danger text-center">Erro ao atualizar usuário.</div>';
    }

    public function ExcluirUsuario($id){

        $this->db->where('id', $id);
        $this->db->delete('usuarios');

        $this->db->where('id_user', $id);
        $this->db->delete('extrato');

        $this->db->where('id_user', $id);
        $this->db->delete('faturas');

        $this->db->where('id_user', $id);
        $this->db->delete('notificacoes');

        $this->db->where('id_patrocinador', $id);
        $this->db->delete('patrocinadores');

        $this->db->where('id_usuario', $id);
        $this->db->delete('patrocinadores');

        $this->db->where('id_user', $id);
        $this->db->delete('saques');

        $this->db->where('id_user', $id);
        $this->db->delete('tickets');
    }

    public function TodasFaturas(){

        $faturas = $this->db->query("SELECT f.id, f.quantidade_cotas AS quantidade, f.status AS status_number, IF(f.status = 0, '<font color=\"orange\"><b>Pendente</b></font>', '<font color=\"green\"><b>Pago</b></font>') AS status, IF(f.renovacao = 0, 'Não', 'Sim') AS renovacao, IF(c.comprovante, 'Enviado', 'Não Enviado') as comprovante_text, u.nome, c.comprovante AS link_comprovante FROM faturas AS f LEFT JOIN comprovantes AS c ON c.id_fatura = f.id INNER JOIN usuarios AS u ON u.id = f.id_user");

        if($faturas->num_rows() > 0){

            return $faturas->result();
        }

        return false;
    }

    public function LiberarFatura($id){

        $this->db->where('id', $id);
        $fatura = $this->db->get('faturas');

        $row = $fatura->row();

        $id_user_fatura = $row->id_user;

        $user_indicador = $this->db->query("SELECT u.id, u.saldo_disponivel FROM patrocinadores AS p INNER JOIN usuarios AS u ON p.id_patrocinador = u.id WHERE p.id_usuario = '$id_user_fatura'");

        if($user_indicador->num_rows() > 0){

            $row_indicador = $user_indicador->row();

            $saldo_user_indicador = $row_indicador->saldo_disponivel + (config_site('valor_indicacao'));

            $this->db->where('id', $row_indicador->id);
            $this->db->update('usuarios', array('saldo_disponivel'=>$saldo_user_indicador));

        }

        $dias = Recebimentos(date('Y-m-d'), config_site('validade_cotas'));

        $data_primeiro_recebimento = $dias['primeiro_recebimento'].' '.config_site('hora_pagamento').':00';
        $data_ultimo_recebimento = $dias['ultimo_recebimento'].' '.config_site('hora_pagamento').':00';

        $primeiro_recebimento = strtotime($data_primeiro_recebimento);
        $ultimo_recebimento = strtotime($data_ultimo_recebimento);

        $array_cotas = array(
                                                'id_user'=>$row->id_user,
                                                'quantidade'=>$row->quantidade_cotas,
                                                'primeiro_recebimento'=>$primeiro_recebimento,
                                                'ultimo_recebimento'=>$ultimo_recebimento,
                                                'status'=>1
                                                );

        $this->db->insert('cotas', $array_cotas);

        $this->db->where('id', $row->id);
        $this->db->update('faturas', array('status'=>1));

        $array_notificacao = array(
                                                        'id_user'=>$row->id_user,
                                                        'mensagem'=>'Fatura #'.$id.' liberada! '.$row->quantidade_cotas.' cota(s) ativada(s) !',
                                                        'visto'=>0,
                                                        'data'=>time()
                                                        );

        $this->db->insert('notificacoes', $array_notificacao);
    }

    public function TodosSaques(){

        $saques = $this->db->query("SELECT u.login, s.* FROM saques AS s INNER JOIN usuarios AS u ON u.id = s.id_user");

        if($saques->num_rows() > 0){

            return $saques->result();
        }

        return false;
    }

    public function Saque($id){

        $saque = $this->db->query("SELECT u.login, u.nome, u.email, u.cpf, u.banco, u.agencia, u.conta, u.tipo_conta, u.titular, s.* FROM saques AS s INNER JOIN usuarios AS u ON u.id = s.id_user WHERE s.id = '$id'");

        return $saque->row();
    }

    public function PagarSaque($id){

        $this->db->where('id', $id);
        $this->db->where('status', 0);
        $saque = $this->db->get('saques');

        if($saque->num_rows() > 0){

            $row = $saque->row();

            $id_user = $row->id_user;
            $valor = $row->valor;

            $this->db->where('id', $id_user);
            $user = $this->db->get('usuarios');

            $row_user = $user->row();

            $novo_saldo_bloqueado = $row_user->saldo_bloqueado - $valor;

            $this->db->where('id', $id_user);
            $this->db->update('usuarios', array('saldo_bloqueado'=>$novo_saldo_bloqueado));

            $this->db->where('id', $id);
            $this->db->update('saques', array('status'=>1));
        }
    }

    public function EstornarSaque($id){

        $this->db->where('id', $id);
        $this->db->where('status', 0);
        $saque = $this->db->get('saques');

        if($saque->num_rows() > 0){

            $row = $saque->row();

            $id_user = $row->id_user;
            $valor = $row->valor;

            $this->db->where('id', $id_user);
            $user = $this->db->get('usuarios');

            $row_user = $user->row();

            $novo_saldo_bloqueado = $row_user->saldo_bloqueado - $valor;
            $novo_saldo_disponivel = $row_user->saldo_disponivel + $valor;

            $this->db->where('id', $id_user);
            $this->db->update('usuarios', array('saldo_bloqueado'=>$novo_saldo_bloqueado, 'saldo_disponivel'=>$novo_saldo_disponivel));

            $this->db->where('id', $id);
            $this->db->update('saques', array('status'=>2));
        }
    }

    public function TodosTickets(){

        $tickets = $this->db->query("SELECT u.login, t.* FROM tickets AS t INNER JOIN usuarios AS u ON u.id = t.id_user");

        if($tickets->num_rows() > 0){

            return $tickets->result();
        }

        return false;
    }

    public function VisualizarTicket($id){

        $this->db->where('id', $id);
        $ticket = $this->db->get('tickets');

        return $ticket->row();
    }

    public function MensagensTicket($id){

        $mensagens = $this->db->query("SELECT u.nome, tm.* FROM tickets_mensagem AS tm INNER JOIN tickets AS t ON t.id = tm.id_ticket INNER JOIN usuarios AS u ON u.id = t.id_user WHERE tm.id_ticket = '$id' ORDER BY data ASC");

        if($mensagens->num_rows() > 0){

            return $mensagens->result();
        }

        return false;
    }

    public function EnviarMensagemTicket($id){

        $resposta = $this->input->post('resposta');

        $this->db->where('id', $id);
        $ticket = $this->db->get('tickets');
        $row = $ticket->row();

        $id_user = $row->id_user;

        $array_mensagem = array(
                                                        'id_ticket'=>$id,
                                                        'mensagem'=>$resposta,
                                                        'user'=>0,
                                                        'data'=>time()
                                                        );

        $this->db->insert('tickets_mensagem', $array_mensagem);

        $this->db->where('id', $id);
        $this->db->update('tickets', array('status'=>1));

        $array_notificacao = array(
                                                        'id_user'=>$id_user,
                                                        'mensagem'=>'Nova resposta em <b>"'.$row->titulo.'"</b>',
                                                        'visto'=>0,
                                                        'data'=>time()
                                                        );

        $this->db->insert('notificacoes', $array_notificacao);
    }

    public function FecharTicket($id){

        $ticket = $this->VisualizarTicket($id);

        $this->db->where('id', $id);
        $this->db->update('tickets', array('status'=>2));

        $array_notificacao = array(
                                                        'id_user'=>$ticket->id_user,
                                                        'mensagem'=>'Ticket fechado <b>"'.$ticket->titulo.'"</b>',
                                                        'visto'=>0,
                                                        'data'=>time()
                                                        );

        $this->db->insert('notificacoes', $array_notificacao);
    }

    public function ReabrirTicket($id){

        $ticket = $this->VisualizarTicket($id);

        $this->db->where('id', $id);
        $this->db->update('tickets', array('status'=>3));

        $array_notificacao = array(
                                                        'id_user'=>$ticket->id_user,
                                                        'mensagem'=>'Ticket Re-aberto <b>"'.$ticket->titulo.'"</b>',
                                                        'visto'=>0,
                                                        'data'=>time()
                                                        );

        $this->db->insert('notificacoes', $array_notificacao);
    }

    public function EnviarNotificacao(){

        $notificacao = $this->input->post('notificacao');

        $usuarios = $this->db->get('usuarios');

        if($usuarios->num_rows() > 0){

            foreach($usuarios->result() as $usuario){

                $array_notificacao = array(
                                                                'id_user'=>$usuario->id,
                                                                'mensagem'=>$notificacao,
                                                                'visto'=>0,
                                                                'data'=>time()
                                                                );

                $insert = $this->db->insert('notificacoes', $array_notificacao);
            }

            if(isset($insert) && $insert == true){

                return '<div class="alert alert-success text-center">Notificação enviada com sucesso!</div>';
            }

            return '<div class="alert alert-danger text-center">Erro ao enviar notificação.</div>';

        }

        return '<div class="alert alert-danger text-center">Não existe nenhum usuário cadastrado no sistema.</div>';
    }

    public function MudarSenha(){

        $sessao = $this->native_session->get('user_id_admin');

        $senha = $this->input->post('senha');

        $array_pw = array(
                                        'senha'=>md5($senha)
                                        );

        $this->db->where('id', $sessao);
        $update = $this->db->update('admin_login', $array_pw);

        if($update){

            return '<div class="alert alert-success text-center">Senha atualizada com sucesso!</div>';
        }

        return '<div class="alert alert-danger text-center">Erro ao atualizar senha.</div>';
    }

    public function TodosUsuariosAdmin(){

        $usuarios = $this->db->get('admin_login');

        return $usuarios->result();
    }

    public function AdicionarUsuarioAdministrativo(){

        $nome = $this->input->post('nome');
        $login = $this->input->post('login');
        $senha = $this->input->post('senha');

        $array_usuario = array(
                                                    'nome'=>$nome,
                                                    'login'=>$login,
                                                    'senha'=>md5($senha)
                                                    );

        $this->db->where('login', $login);
        $users = $this->db->get('admin_login');

        if($users->num_rows() > 0){

            return '<div class="alert alert-danger text-center>O login já existe. Escolha outro.</div>';
        }

        $insert = $this->db->insert('admin_login', $array_usuario);

        if($insert){

            return '<div class="alert alert-success text-center">Usuário adicionado com sucesso!</div>';
        }

        return '<div class="alert alert-danger text-center">Erro ao adicionar usuário.</div>';
    }

    public function InformacaoUsuarioAdministrativo($id){

        $this->db->where('id', $id);
        $usuario = $this->db->get('admin_login');

        return $usuario->row();
    }

    public function AtualizarUsuarioAdministrativo($id){

        $nome = $this->input->post('nome');
        $senha = $this->input->post('senha');

        $array_usuario = array(
                                                    'nome'=>$nome
                                                    );

        if(!empty($senha)){

            $array_usuario['senha'] = md5($senha);
        }

        $this->db->where('id', $id);
        $update = $this->db->update('admin_login', $array_usuario);

        if($update){

            return '<div class="alert alert-success text-center">Dados atualizados com sucesso!</div>';
        }

        return '<div class="alert alert-danger text-center">Erro ao atualizar usuário.</div>';
    }

    public function ExcluirUsuarioAdministrativo($id){

        $this->db->where('id', $id);
        $this->db->delete('admin_login');
    }

    public function Configuracoes(){

        $config = $this->db->get('website_config');

        return $config->row();
    }

    public function AtualizarConfiguracoes(){

        $nome_site = $this->input->post('nome_site');
        $email_remetente = $this->input->post('email_remetente');
        $valor_indicacao = $this->input->post('valor_indicacao');
        $valor_cota = $this->input->post('valor_cota');
        $maximo_cotas = $this->input->post('maximo_cotas');
        $validade_cotas = $this->input->post('validade_cotas');
        $permitir_transferencia_membros = $this->input->post('permitir_transferencia_membros');
        $valor_minimo_transferencia = $this->input->post('valor_minimo_transferencia');
        $pagar_com_saldo = $this->input->post('pagar_com_saldo');
        $taxa_pagamento_saldo = $this->input->post('taxa_pagamento_saldo');
        $saque_disponivel = $this->input->post('saque_disponivel');
        $valor_minimo_saque = $this->input->post('valor_minimo_saque');
        $dias_saque = $this->input->post('dias_saque');
        $taxa_saque = $this->input->post('taxa_saque');
        $pagamento_automatico = $this->input->post('pagamento_automatico');
        $proxima_execucao = $this->input->post('proxima_execucao');
        $hora_pagamento = $this->input->post('hora_pagamento');
        $valor_minimo_pago = $this->input->post('valor_minimo_pago');
        $valor_maximo_pago = $this->input->post('valor_maximo_pago');
        $paga_fim_de_semana = $this->input->post('paga_fim_de_semana');
        $permitir_renovacao_automatica = $this->input->post('permitir_renovacao_automatica');
        $ativa_gerencianet = $this->input->post('ativa_gerencianet');
        $token_gerencianet = $this->input->post('token_gerencianet');
        $permitir_cadastro_anuncio = $this->input->post('permitir_cadastro_anuncio');

        $array_config = array(
                                                'nome_site'=>$nome_site,
                                                'email_remetente'=>$email_remetente,
                                                'valor_indicacao'=>str_replace(",", ".", $valor_indicacao),
                                                'valor_cota'=>str_replace(",", ".", $valor_cota),
                                                'maximo_cotas'=>$maximo_cotas,
                                                'validade_cotas'=>$validade_cotas,
                                                'permitir_transferencia_membros'=>$permitir_transferencia_membros,
                                                'valor_minimo_transferencia'=>str_replace(",", ".", $valor_minimo_transferencia),
                                                'pagar_com_saldo'=>$pagar_com_saldo,
                                                'taxa_pagamento_saldo'=>str_replace(",", ".", $taxa_pagamento_saldo),
                                                'saque_disponivel'=>$saque_disponivel,
                                                'valor_minimo_saque'=>str_replace(",", ".", $valor_minimo_saque),
                                                'dias_saque'=>$dias_saque,
                                                'taxa_saque'=>str_replace(",", ".", $taxa_saque),
                                                'pagamento_automatico'=>$pagamento_automatico,
                                                'hora_pagamento'=>$hora_pagamento,
                                                'valor_minimo_pago'=>$valor_minimo_pago,
                                                'valor_maximo_pago'=>$valor_maximo_pago,
                                                'paga_fim_de_semana'=>$paga_fim_de_semana,
                                                'permitir_renovacao_automatica'=>$permitir_renovacao_automatica,
                                                'ativa_gerencianet'=>$ativa_gerencianet,
                                                'token_gerencianet'=>$token_gerencianet,
                                                'permitir_cadastro_anuncio'=>$permitir_cadastro_anuncio
                                                );

        $data_cron = converter_data($proxima_execucao);
        $data_completa = $data_cron.' '.$hora_pagamento;
        $nova_data_cron = strtotime($data_completa);

        $cotas = $this->db->get('cotas');

        if($cotas->num_rows() > 0){

            foreach($cotas->result() as $cota){

                $antiga_data_primeiro_recebimento = date('Y-m-d', $cota->primeiro_recebimento);
                $antiga_data_ultimo_recebimento = date('Y-m-d', $cota->ultimo_recebimento);

                $nova_data_primeiro_recebimento = strtotime($antiga_data_primeiro_recebimento.' '.$hora_pagamento);
                $nova_data_ultimo_recebimento = strtotime($antiga_data_ultimo_recebimento.' '.$hora_pagamento);

                $this->db->where('id', $cota->id);
                $this->db->update('cotas', array('primeiro_recebimento'=>$nova_data_primeiro_recebimento, 'ultimo_recebimento'=>$nova_data_ultimo_recebimento));
            }
        }

        $this->db->update('cron', array('proxima_execucao'=>$nova_data_cron));

        if(!empty($_FILES['logo_login']['name'])){

            $config_login['upload_path'] = 'uploads';
            $config_login['allowed_types'] = 'bmp|gif|png|jpg|jpeg|pjpeg';
            $config_login['overwrite'] = true;
            $config_login['file_name'] = 'logo_login';

            $this->upload->initialize($config_login);

            $this->upload->do_upload('logo_login');
            $upload_login = $this->upload->data();

            $array_config['imagem_logo'] = $upload_login['file_name'];

        }

        if(!empty($_FILES['logo_backoffice']['name'])){

            $config_bo['upload_path'] = 'uploads';
            $config_bo['allowed_types'] = 'bmp|gif|png|jpg|jpeg|pjpeg';
            $config_bo['overwrite'] = true;
            $config_bo['file_name'] = 'logo_backoffice';

            $this->upload->initialize($config_bo);

            $this->upload->do_upload('logo_backoffice');
            $upload_bo = $this->upload->data();

            $array_config['imagem_logo_backoffice'] = $upload_bo['file_name'];


        }

        if(!empty($_FILES['logo_admin']['name'])){

            $config_admin['upload_path'] = 'uploads';
            $config_admin['allowed_types'] = 'bmp|gif|png|jpg|jpeg|pjpeg';
            $config_admin['overwrite'] = true;
            $config_admin['file_name'] = 'logo_admin';

            $this->upload->initialize($config_admin);

            $this->upload->do_upload('logo_admin');
            $upload_admin = $this->upload->data();

            $array_config['imagem_logo_admin'] = $upload_admin['file_name'];

        }

        if(!empty($_FILES['favicon']['name'])){

            $config_fav['upload_path'] = './uploads/';
            $config_fav['allowed_types'] = 'gif|png|jpg|jpeg|pjpeg|ico';
            $config_fav['overwrite'] = true;
            $config_fav['file_name'] = 'favicon';

            $this->upload->initialize($config_fav);

            $this->upload->do_upload('favicon');
            $upload_favicon = $this->upload->data();

            $array_config['favicon'] = $upload_favicon['file_name'];

        }

        $update = $this->db->update('website_config', $array_config);

        if($update){

            return '<div class="alert alert-success text-center">Configurações salvas com sucesso!</div>';
        }

        return '<div class="alert alert-danger text-center">Erro ao salvar configurações.</div>';


    }

    public function Cron(){

        $cron = $this->db->get('cron');

        return $cron->row();
    }

    public function ContasBancarias(){

        $contas = $this->db->get('contas_bancarias');

        if($contas->num_rows() > 0){

            return $contas->result();
        }

        return false;
    }

    public function NovaContaBancaria(){

        $banco = $this->input->post('banco');
        $agencia = $this->input->post('agencia');
        $conta = $this->input->post('conta');
        $tipo_conta = $this->input->post('tipo_conta');
        $titular = $this->input->post('titular');

        $array_conta = array(
                                            'banco'=>$banco,
                                            'agencia'=>$agencia,
                                            'conta'=>$conta,
                                            'tipo_conta'=>$tipo_conta,
                                            'titular'=>$titular
                                            );

        $insert = $this->db->insert('contas_bancarias', $array_conta);

        if($insert){

            return '<div class="alert alert-success text-center">Conta bancária adicionada com sucesso!</div>';
        }

        return '<div class="alert alert-danger text-center">Erro ao adicionar conta bancária.</div>';
    }

    public function InformacaoContaBancaria($id){

        $this->db->where('id', $id);
        $conta = $this->db->get('contas_bancarias');

        return $conta->row();
    }

    public function EditarContaBancaria($id){

        $banco = $this->input->post('banco');
        $agencia = $this->input->post('agencia');
        $conta = $this->input->post('conta');
        $tipo_conta = $this->input->post('tipo_conta');
        $titular = $this->input->post('titular');

        $array_conta = array(
                                            'banco'=>$banco,
                                            'agencia'=>$agencia,
                                            'conta'=>$conta,
                                            'tipo_conta'=>$tipo_conta,
                                            'titular'=>$titular
                                            );

        $this->db->where('id', $id);
        $update= $this->db->update('contas_bancarias', $array_conta);

        if($update){

            return '<div class="alert alert-success text-center">Conta bancária atualizada com sucesso!</div>';
        }

        return '<div class="alert alert-danger text-center">Erro ao atualizar conta bancária.</div>';
    }

    public function ExcluirContaBancaria($id){

        $this->db->where('id', $id);
        $this->db->delete('contas_bancarias');
    }
}