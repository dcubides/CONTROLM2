<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if($this->session->userdata('conectado') == true){ ?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Reporte de Ingresos y Egreos de Material</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="<?php echo base_url();?>asset/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>asset/css/bootstrap.min.js" rel="stylesheet">
<link href="<?php echo base_url();?>asset/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
        rel="stylesheet">
<link href="<?php echo base_url();?>asset/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo base_url();?>asset/css/style.css" rel="stylesheet">
<link href="<?php echo base_url();?>asset/css/pages/dashboard.css" rel="stylesheet">
<link href="<?php echo base_url();?>asset/css/jquery-impromptu.css" rel="stylesheet">





<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="index.html">Administrador de Aplicaciones Nesitelco S.A. </a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-cog"></i> Account <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="javascript:;">Settings</a></li>
              <li><a href="javascript:;">Help</a></li>
            </ul>
          </li>
          <?php
      $emailUser = $this->session->userdata('email');
      $nombreUser = $this->session->userdata('usuario');
     // echo '<h4>'.$nombreUser.'</h4>';
      //echo '<p>'.$emailUser.'</p>';?>
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-user"></i> <?php echo $nombreUser; ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url();?>index.php/home/salir">Salir</a></li>
              <li><a href="javascript:;">perfil</a></li>
              
            </ul>
          </li>
        </ul>
        
      </div>
      <!--/.nav-collapse --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /navbar-inner --> 
</div>
<!-- /navbar -->
<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
        <li class="active"><a href="<?php echo site_url('reporte_salidas')?>"><i class="icon-dashboard"></i><span>Reporte de Salida </span> </a> </li>
         <li class="active"><a href="<?php echo site_url('reporte_entradas')?>"><i class="icon-dashboard"></i><span>Reportes de Devoluciones</span> </a> </li>
        <li class="active"><a href='<?php echo site_url('reportes_movimientos/informe_movimiento')?>'><i class="icon-list-alt"></i><span>Informes Movimientos</span> </a> </li>
        <li class="active"><a href='<?php echo site_url('salidas_bodega')?>'><i class="icon-facetime-video"></i><span>Informes</span> </a></li>
        <li class="active"><a href="<?php echo base_url();?>index.php/home/salir"><i class="icon-bar-chart"></i><span>Salir</span> </a> </li>
       
       
      </ul>
    </div>
    <!-- /container --> 
  </div>
  <!-- /subnavbar-inner --> 
</div>
<!-- /subnavbar -->
<div class="main">
  <div class="main-inner">
    <div class="container">
     

      <?php }else{

  redirect(base_url());

  }
  ?>