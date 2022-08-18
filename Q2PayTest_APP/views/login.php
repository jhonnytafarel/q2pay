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
               <p class="login-box-msg">Insira os dados para Login</p>
               <form action="" method="POST">
                  <div class="input-group mb-3">
                     <input type="email" name="email" class="form-control" placeholder="Email" required/>
                     <div class="input-group-append">
                        <div class="input-group-text">
                           <span class="fas fa-envelope"></span>
                        </div>
                     </div>
                  </div>
                  <div class="input-group mb-3">
                     <input type="password" name="senha" class="form-control" placeholder="Senha" required/> 
                     <div class="input-group-append">
                        <div class="input-group-text">
                           <span class="fas fa-lock"></span>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <!-- /.col -->
                     <div class="col-4">
                        <input type="submit" name="submit" class="btn btn-primary btn-block" value="Acessar">
                     </div>
                     <!-- /.col -->
                  </div>
               </form>
               </br>
               <!-- /.social-auth-links -->
               <p class="mb-0">
                  <a href="cadastrar" class="text-center">Não tem Cadastro? Clique aqui</a>
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