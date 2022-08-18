<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Q2Pay - Teste</title>
      <!-- Google Font: Source Sans Pro -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="q2paytemplate/plugins/fontawesome-free/css/all.min.css">
      <!-- icheck bootstrap -->
      <link rel="stylesheet" href="q2paytemplate/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="q2paytemplate/dist/css/adminlte.min.css">
      <!-- Mask CPF CNPJ -->
      <script type="text/javascript">
         function mascaraMutuario(o,f){
             v_obj=o
             v_fun=f
             setTimeout('execmascara()',1)
         }
          
         function execmascara(){
             v_obj.value=v_fun(v_obj.value)
         }
          
         function cpfCnpj(v){
          
             //Remove tudo o que não é dígito
             v=v.replace(/\D/g,"")
          
             if (v.length <= 14) { //CPF
          
                 //Coloca um ponto entre o terceiro e o quarto dígitos
                 v=v.replace(/(\d{3})(\d)/,"$1.$2")
          
                 //Coloca um ponto entre o terceiro e o quarto dígitos
                 //de novo (para o segundo bloco de números)
                 v=v.replace(/(\d{3})(\d)/,"$1.$2")
          
                 //Coloca um hífen entre o terceiro e o quarto dígitos
                 v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
          
             } else { //CNPJ
          
                 //Coloca ponto entre o segundo e o terceiro dígitos
                 v=v.replace(/^(\d{2})(\d)/,"$1.$2")
          
                 //Coloca ponto entre o quinto e o sexto dígitos
                 v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3")
          
                 //Coloca uma barra entre o oitavo e o nono dígitos
                 v=v.replace(/\.(\d{3})(\d)/,".$1/$2")
          
                 //Coloca um hífen depois do bloco de quatro dígitos
                 v=v.replace(/(\d{4})(\d)/,"$1-$2")
          
             }
          
             return v
          
         }
      </script>
      <script src="https://unpkg.com/imask"></script>
   </head>
   <body class="hold-transition login-page">
      <div class="login-box">
         <!-- /.login-logo -->
         <?php
            //Mensagem vindo do Model
            if(isset($message)) echo $message;
            ?>
         <div class="card card-outline card-primary">
            <div class="card-header text-center">
               <a href="#" class="h1"><b>Q2</b> Teste</a>
            </div>
            <div class="card-body">
               <p class="login-box-msg">Insira os dados para Cadastro</p>
               <form action="" method="post">
                  <div class="input-group mb-3">
                     <input type="text" name="nome" class="form-control" placeholder="Informe seu Nome" required/>
                     <div class="input-group-append">
                        <div class="input-group-text">
                           <span class="fas fa-user"></span>
                        </div>
                     </div>
                  </div>
                  <div class="input-group mb-3">
                     <input type="text" name="cpf_cnpj" class="form-control" minlength="14" maxlength="18" placeholder="Informe CPF ou CNPJ" onkeypress="mascaraMutuario(this,cpfCnpj)" onblur="clearTimeout()" required/>
                     <div class="input-group-append">
                        <div class="input-group-text">
                           <span class="fas fa-user"></span>
                        </div>
                     </div>
                  </div>
                  <div class="input-group mb-3">
                     <input type="email" name="email" class="form-control" placeholder="Informe seu Email" required/>
                     <div class="input-group-append">
                        <div class="input-group-text">
                           <span class="fas fa-envelope"></span>
                        </div>
                     </div>
                  </div>
                  <div class="input-group mb-3">
                     <input type="password" name="senha" class="form-control" placeholder="Informe sua Senha" required/> 
                     <div class="input-group-append">
                        <div class="input-group-text">
                           <span class="fas fa-lock"></span>
                        </div>
                     </div>
                  </div>
                  <div class="input-group mb-3">
                     <input type="password" name="repetir_senha" class="form-control" placeholder="Repetir Senha" required/> 
                     <div class="input-group-append">
                        <div class="input-group-text">
                           <span class="fas fa-lock"></span>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <!-- /.col -->
                     <div class="col-12">
                        <input type="submit" name="submit" class="btn btn-primary btn-block" value="Efetuar Cadastro">
                     </div>
                     <!-- /.col -->
                  </div>
               </form>
               </br>
               <!-- /.social-auth-links -->
               <p class="mb-0">
                  <a href="login" class="text-center">Ja é Cadastrado? Voltar.</a>
               </p>
            </div>
            <!-- /.card-body -->
         </div>
         <!-- /.card -->
      </div>
      <!-- /.login-box -->
      <!-- jQuery -->
      <script src="q2paytemplate/plugins/jquery/jquery.min.js"></script>
      <!-- Bootstrap 4 -->
      <script src="q2paytemplate/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- AdminLTE App -->
      <script src="q2paytemplate/dist/js/adminlte.min.js"></script>
   </body>
</html>