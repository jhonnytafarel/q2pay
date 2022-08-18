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
<section class="content">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
   <div class="card">
      <div class="card-header">
         <h3 class="card-title">Extrato</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
         <table class="table table-bordered">
            <thead>
               <tr>
                  <th>
                     Transação
                  </th>
                  <th>
                     Data
                  </th>
                  <th>
                     Valor
                  </th>
                  <th>
                     Descrição
                  </th>
               </tr>
            </thead>
            <tbody>
               <?php
                  if($extrato_registros != false){
                  
                      foreach($extrato_registros as $extrato){
                  ?>
               <tr>
                  <td><?php echo $extrato->codigo;?></td>
                  <td><?php echo date('d/m/Y', strtotime($extrato->data));?></td>
                  <td><font color="<?php echo $extrato->cor;?>">R$<?php echo $extrato->valor;?></font></td>
                  <td><?php echo $extrato->descricao;?></td>
               </tr>
               <?php
                  }
                  }
                  ?>
            </tbody>
         </table>
      </div>
   </div>
   <!-- END SAMPLE TABLE PORTLET-->
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->