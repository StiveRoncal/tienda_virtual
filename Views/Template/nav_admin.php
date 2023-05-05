  <!-- Sidebar menu-->
  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?= media();?>/images/avatar3.png" alt="User Image">
        <div>
          <p class="app-sidebar__user-name"><?= $_SESSION['userData']['nombres'];?></p>
          <p class="app-sidebar__user-designation"><?= $_SESSION['userData']['nombrerol'];?></p>
        </div>
      </div>
      <ul class="app-menu">



      <!-- Validacion de Existen los permisos para mostrar en barra de menu -->

        <!-- Configuracion para Usuarios de Tabla Modulo en Dashboard(idmodulo=1) -->
        <!-- Condicinal si existe la session con otros parametros -->
        <?php if(!empty($_SESSION['permisos'][1]['r'])){ ?>
        <li>
            <a class="app-menu__item" href="<?= base_url();?>/dashboard">
                <i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>
        <?php } ?>
        
        
        <!-- Configuracion para Usuarios de Tabla Modulo  en Usuarios(idmodulo=2) -->
        <?php if(!empty($_SESSION['permisos'][2]['r'])){ ?>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label"> Usuarios</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="<?= base_url();?>/usuarios"><i class="icon fa fa-circle-o"></i> Usuarios</a></li>
            <li><a class="treeview-item" href="<?= base_url();?>/roles"><i class="icon fa fa-circle-o"></i> Roles</a></li>
          </ul>
        </li>
        <?php } ?>

        <!-- Configuracion para Usuarios de Tabla Modulo  en Clientes(idmodulo=3) -->
        <?php if(!empty($_SESSION['permisos'][3]['r'])){ ?>
        <li>
            <a class="app-menu__item" href="<?= base_url();?>/clientes">
                <i class="app-menu__icon fa fa-user"></i>
                <span class="app-menu__label">Clientes</span>
            </a>
        </li>
        <?php } ?>

        
        <!-- Configuracion para Usuarios de Tabla Modulo  en Productos(idmodulo=4) y categoria(idmodulo=6) -->
        <?php if(!empty($_SESSION['permisos'][4]['r']) || !empty($_SESSION['permisos'][6]['r'])){ ?>

        <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fa fa-archive"></i>
            <span class="app-menu__label">Tienda</span>
            <i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <!-- Validacion Producto -->
              <?php if(!empty($_SESSION['permisos'][4]['r'])){ ?>
              <li><a class="treeview-item" href="<?= base_url();?>/productos"><i class="icon fa fa-circle-o"></i> Productos</a></li>
              <?php } ?>

              <!-- Validacion de Categorias -->
              <?php if(!empty($_SESSION['permisos'][6]['r'])){ ?>
              <li><a class="treeview-item" href="<?= base_url();?>/categorias"><i class="icon fa fa-circle-o"></i> Categorías</a></li>
              <?php } ?>
            </ul>
        </li>
        <?php } ?>


        <!-- Configuracion para Usuarios de Tabla Modulo  en Pedidos(idmodulo=5) -->
        <?php if(!empty($_SESSION['permisos'][5]['r'])){ ?>
        <li>
            <a class="app-menu__item" href="<?= base_url();?>/pedidos">
                <i class="app-menu__icon fa fa-shopping-cart"></i>
                <span class="app-menu__label">Pedidos</span>
            </a>
        </li>
        <?php } ?>
        
        <li>
            <a class="app-menu__item" href="<?= base_url();?>/logout">
                <i class="app-menu__icon fa fa-sign-out"></i>
                <span class="app-menu__label">Logout</span>
            </a>
        </li>
    
      
      </ul>
    </aside>