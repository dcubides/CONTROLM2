<!--<body>

  <div class="container">
    <div class="container">
      <br />
      <?php //echo validation_errors();?>
          <form class="form-signin" action="<?php // echo base_url().'index.php/home/login';?>" method="post">
            <h2 class="form-signin-heading">Conectarse</h2>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Contraseña" required>
            <div class="checkbox">
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Conectarse</button>
          </form>
        </div>  /container 
</div>-->




<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>Login - CONTROLM</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
    
<link href="<?=base_url()?>/asset/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>/asset/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />

<link href="<?=base_url()?>/asset/css/font-awesome.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    
<link href="<?=base_url()?>/asset/css/style.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>/asset/css/pages/signin.css" rel="stylesheet" type="text/css">

</head>

<body>
 
  
  <div class="navbar navbar-fixed-top">
  
  <div class="navbar-inner">
    
    <div class="container">
      
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      
      <a class="brand" href="index.html">
        Inicio de sesion CONTROLM - Nesitelco S.A.        
      </a>    
      
      <div class="nav-collapse">
        <ul class="nav pull-right">
          
          <!--<li class="">           
            <a href="signup.html" class="">
              Don't have an account?
            </a>
            
          </li>
          
          <li class="">           
            <a href="index.html" class="">
              <i class="icon-chevron-left"></i>
              Back to Homepage
            </a>-->
            
          </li>
        </ul>
        
      </div><!--/.nav-collapse -->  
  
    </div> <!-- /container -->
    
  </div> <!-- /navbar-inner -->
  
</div> <!-- /navbar -->



<div class="account-container">
  
  <div class="content clearfix">

  <?php echo validation_errors();?>
    
    <form class="form-signin" action="<?php  echo base_url().'index.php/home/login';?>" method="post">
    
      <h1>Inicio de usuarios</h1>   
      
      <div class="login-fields">
        
        <p>Porfavor ingresa tus datos</p>
        
        <div class="field">
          <label for="inputEmail">E-mail</label>
          <input type="text" id="inputEmail" name="email"  placeholder="Email" class="login username-field"/>
          
        </div> <!-- /field -->
        
        <div class="field">
          <label for="inputPassword">Password:</label>
          <input type="password" id="inputPassword" name="password"  placeholder="Password" class="login password-field" required/>
          
        </div> <!-- /password -->
        
      </div> <!-- /login-fields -->
      
      <div class="login-actions">
        
        <span class="login-checkbox">
          <input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
          <label class="choice" for="Field">Recordarme</label>
        </span>
                  
        <button type="submit"  class="button btn btn-success btn-large">Ingresar</button>
        
      </div> <!-- .actions -->
      
      
      
    </form>

    
    
  </div> <!-- /content -->
  
</div> <!-- /account-container -->



<div class="login-extra">
  <a href="#">Reset Password</a>
</div> <!-- /login-extra -->


<script src="<?=base_url()?>/asset/js/jquery-1.7.2.min.js"></script>
<script src="<?=base_url()?>/asset/js/bootstrap.js"></script>

<script src="<?=base_url()?>/asset/js/signin.js"></script>

</body>

</html>
