<?php


class Clientes extends Controllers{

    
    public function __construct(){

      // Reempalzo de session_start y usar un helper con timer de session activa
      sessionStart();
      
      
      parent::__construct();
      
      // session_start();


      // Indiciar que el id(SESSION(memoria interna)) Anterior se eliminar cuando cerramos seccion
      // session_regenerate_id(true); 


      if(empty($_SESSION['login'])){

          header('Location:'.base_url().'/login');
          die();
      }

    //   Modulo Cliente(3) tbl.modulo -> Clientes
      getPermisos(3);

    }

    // 1er Metodo

    public function Clientes(){

        //validacion si no tiene permisos asignados redireccion 
        if(empty($_SESSION['permisosMod']['r']) ){

          header("Location:".base_url().'/dashboard');

        }
        // arreglo de un parametro $data
   
        $data['page_tag'] = "Clientes";
        $data['page_title'] = "CLIENTES <small>Tienda Virtual</small>";
        $data['page_name'] = "clientes";
        $data['page_functions_js'] = "functions_clientes.js";

        // invocar la vista su metodo libraries/Core/Views.php
        $this->views->getView($this,"clientes",$data);
    }



    // 2do Metodo

    public function setCliente(){

      dep($_POST);
      die();

    }


    }
?>