<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
         </div>
         <!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="#">Home</a></li>
               <li class="breadcrumb-item active">Q2Teste v1</li>
            </ol>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
<div class="container-fluid">
<!-- Small boxes (Stat box) -->
<div class="row">
   <!-- ./col -->
   <div class="col-lg-12 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
         <div class="inner">
            <h3>R$<?php echo number_format($this->conta_model->user('saldo'),2,",",".");?></h3>
            <p>Saldo Disponivel</p>
         </div>
         <div class="icon">
            <i class="ion ion-stats-bars"></i>
         </div>
      </div>
   </div>
</div>
<!-- /.row -->
<!-- Main row -->
<?php
   //Mensagem vindo do Model
   if(isset($message)) echo $message;
   ?>
<!-- Main content -->
<section class="content">
<div class="container-fluid">
<div class="row">
<!-- left column -->
<div class="col-md-12">
<!-- general form elements -->
<div class="card card-success">
   <div class="card-header">
      <h3 class="card-title">Transferir Saldo</h3>
   </div>
   <!-- /.card-header -->
   <!-- form start -->
   <form actio="" method="POST">
      <div class="card-body">
         <div class="form-group">
            <label for="exampleInputEmail1">Email a Enviar</label>
            <input type="email" name="email_a_enviar" class="form-control" placeholder="Email">
         </div>
         <div class="form-group">
            <label for="exampleInputEmail1">Valor</label>
            <input type="number" name="valor" class="form-control" placeholder="Valor a ser Enviado">
         </div>
         <!-- /.card-body -->
         <div class="card-footer">
            <input type="submit" name="submit" class="btn btn-primary" value="Enviar saldo">
         </div>
   </form>
   </div>
   <!-- /.card -->
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->