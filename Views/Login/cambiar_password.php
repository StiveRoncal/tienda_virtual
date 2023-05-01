<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Stive Roncal">
    <meta name="theme-color" content="#009688">
    <link rel="shortcut icon" href="<?= media();?>/images/uploads/favicon.png" type="image/x-icon">
    
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= media();?>/css/styles.css">


    <title><?= $data['page_tag'];?></title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>

    <!-- Formulario login -->
    <section class="login-content">
      <div class="logo">
        <h1><?= $data['page_title'];?></h1>
      </div>
      <div class="login-box flipped">
       
        <form name="formCambiarPass" id="formCambiarPass" class="forget-form" action="">
          <input type="hidden" id="idUsuario" name="idUsuario" value="<?= $data['idpersona']; ?>" required>
          <h3 class="login-head"><i class="fas fa-key"></i> Cambiar Contraseña</h3>
          <div class="form-group">
            <input id="txtPassword" name="txtPassword" class="form-control" type="password" placeholder="Nueva Contraseña" required >
          </div>
          <div class="form-group">
            <input id="txtPasswordConfirm" name="txtPasswordConfirm" class="form-control" type="password" placeholder="Confirmar Contraseña" required >
          </div>
          <div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>REINICIAR</button>
          </div>
          <div class="form-group mt-3">
            <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Iniciar sesión</a></p>
          </div>
        </form>
      </div>
    </section>

    <script>
      const base_url = "<?= base_url();?>";
    </script>
    <!-- Essential javascripts for application to work-->
    <script src="<?= media(); ?>/js/jquery-3.3.1.min.js"></script>
    <script src="<?= media(); ?>/js/popper.min.js"></script>
    <script src="<?= media(); ?>/js/bootstrap.min.js"></script>
    <script src="<?= media(); ?>/js/fontawesome.js"></script>
    <script src="<?= media(); ?>/js/plugins/sweetalert.min.js"></script>
    <script src="<?= media(); ?>/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?= media(); ?>/js/plugins/pace.min.js"></script>
    
    
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <!-- php al de alto nivel recuerda que es una condenacion solo php no te asustes -->
    <script src="<?= media(); ?>/js/<?= $data['page_functions_js'];?>"></script>
    
  </body>
</html>






<!-- localhost:81/tienda_virtual/login/confirmUser/stiveroncal@gmail.com/0cb47c781a749dc205ad-d7928600ed7518fe618b-c522e4fa2d7502e4651c-ed88224aa76c23ae0 -->