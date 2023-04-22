<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="Tienda virtual Stive Roncal Quintimari Amadeus system">
    <meta http-equiv="X-UA-Compatible" content="Chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Stive Roncal">
    <link rel="shortcut icon" href="<?= media();?>/images/uploads/favicon.png">
    <title><?= $data['page_tag'];?></title>
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/styles.css">
  
   
    
  </head>
  <body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="<?= base_url();?>/dashboard">Tienda Virtual</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
       
    
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href="<?= base_url();?>/opciones"><i class="fa fa-cog fa-lg"></i> Settings</a></li>
            <li><a class="dropdown-item" href="<?= base_url();?>/perfil"><i class="fa fa-user fa-lg"></i> Profile</a></li>
            <li><a class="dropdown-item" href="<?= base_url();?>/logout"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </header>

    <?php  require_once("nav_admin.php"); ?>