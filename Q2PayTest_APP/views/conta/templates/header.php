<?php
   check_session();//Check se existe uma sessão
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Q2Teste | Dashboard</title>
      <!-- Google Font: Source Sans Pro -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="q2paytemplate/plugins/fontawesome-free/css/all.min.css">
      <!-- Ionicons -->
      <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
      <!-- Tempusdominus Bootstrap 4 -->
      <link rel="stylesheet" href="q2paytemplate/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
      <!-- iCheck -->
      <link rel="stylesheet" href="q2paytemplate/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
      <!-- JQVMap -->
      <link rel="stylesheet" href="q2paytemplate/plugins/jqvmap/jqvmap.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="q2paytemplate/dist/css/adminlte.min.css">
      <!-- overlayScrollbars -->
      <link rel="stylesheet" href="q2paytemplate/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
      <!-- Daterange picker -->
      <link rel="stylesheet" href="q2paytemplate/plugins/daterangepicker/daterangepicker.css">
      <!-- summernote -->
      <link rel="stylesheet" href="q2paytemplate/plugins/summernote/summernote-bs4.min.css">
   </head>
   <body class="hold-transition sidebar-mini layout-fixed">
      <div class="wrapper">
      <!-- Preloader -->
      <div class="preloader flex-column justify-content-center align-items-center">
         <img class="animation__shake" src="q2paytemplate/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
      </div>
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
         <!-- Left navbar links -->
         <!-- Right navbar links -->
         <ul class="navbar-nav ml-auto">
            <li class="nav-item">
               <a class="nav-link" data-widget="fullscreen" href="#" role="button">
               <i class="fas fa-expand-arrows-alt"></i>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
               <i class="fas fa-th-large"></i>
               </a>
            </li>
         </ul>
      </nav>
      <!-- /.navbar -->
      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
         <!-- Brand Logo -->
         <a href="index3.html" class="brand-link">
         <img src="q2paytemplate/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
         <span class="brand-text font-weight-light">Q2Teste</span>
         </a>
         <!-- Sidebar -->
         <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
               <div class="image">
                  <img src="q2paytemplate/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
               </div>
               <div class="info">
                  <a href="#" class="d-block"><?php echo $this->conta_model->user('nome', 'first_name');?></a>
                  <?php
                     $tipo = $this->conta_model->user('tipo');
                     if($tipo == 2){
                     echo'<a href="#" class="d-block">Tipo de conta: CNPJ</a>';  
                     }else{
                     echo'<a href="#" class="d-block">Tipo de conta: CPF</a>';  
                     }
                     ?>
               </div>
            </div>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
               <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                  <li class="nav-item menu-open">
                     <?php 
                        if($titulo == "Backoffice"){
                        echo '<a href="conta" class="nav-link active">';  
                        }else{
                        echo'<a href="conta" class="nav-link">';
                        }?>
                     <i class="nav-icon fas fa-tachometer-alt"></i>
                     <p>
                        Dashboard
                     </p>
                     </a>
                  </li>
                  <?php 
                     if($tipo == 1){
                     ?>
                  <li class="nav-item">
                     <?php 
                        if($titulo == "TransferirSaldo"){
                        echo '<a href="transferir_saldo" class="nav-link active">';  
                        }else{
                        echo'<a href="transferir_saldo" class="nav-link">';
                        }?>
                     <i class="nav-icon fas fa-paper-plane"></i>
                     <p>
                        Enviar Saldo
                        <span class="right badge badge-success">Novo</span>
                     </p>
                     </a>
                  </li>
                  <?php
                     }?>
                  <li class="nav-item">
                     <a href="usuario/logout" class="nav-link">
                        <i class="fas fa-sign-out-alt nav-icon"></i>
                        <p>Logout</p>
                     </a>
                  </li>
               </ul>
            </nav>
            <!-- /.sidebar-menu -->
         </div>
         <!-- /.sidebar -->
      </aside>