  <!-- Varibles para que reconozca js de la ruta de localhost -->
  <script>
      const base_url = "<?= base_url(); ?>";
  </script>
  
  <!-- Essential javascripts for application to work-->
    <script src="<?= media(); ?>/js/jquery-3.3.1.min.js"></script>
    <script src="<?= media(); ?>/js/popper.min.js"></script>
    <script src="<?= media(); ?>/js/bootstrap.min.js"></script>
    <script src="<?= media(); ?>/js/main.js"></script>
    <script src="<?= media(); ?>/js/fontawesome.js"></script>

    <script src="<?= media(); ?>/js/functions_admin.js"></script>
   
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?= media(); ?>/js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <!-- Google analytics script-->

    <script type="text/javascript" src="<?= media(); ?>/js/plugins/sweetalert.min.js"></script>

    <script type="text/javascript" src="<?= media(); ?>/js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?= media(); ?>/js/plugins/dataTables.bootstrap.min.js"></script>
    

    <!-- Condicionales Roles -->
    <?php if($data['page_name'] == "rol_usuario"){ ?>
        <script src="<?= media(); ?>/js/functions_roles.js"></script>
    <?php } ?>


    <!-- Condicionales Usuarios -->
  <?php if($data['page_name'] == "usuarios"){     ?>
        <script src="<?= media(); ?>/js/functions_usuarios.js"></script>
  <?php } ?>

   
  </body>
</html>