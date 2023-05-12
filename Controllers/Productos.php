<?php


  class Productos extends Controllers{

    
    public function __construct(){

  
        sessionStart();
        
        parent::__construct();
        
        if(empty($_SESSION['login'])){

            header('Location:'.base_url().'/login');
            die();
        }

        // En el tabla modulo esta El nro 4 el ID porque alli esta el producto del modulo
        getPermisos(4);

    }


    public function Productos(){

        //validacion si no tiene permisos asignados redireccion 
        if(empty($_SESSION['permisosMod']['r']) ){

          header("Location:".base_url().'/dashboard');

        }

        $data['page_tag'] = "Productos";
        $data['page_title'] = "PRODUCTOS <small>Tienda Virtual</small>";
        $data['page_name'] = "productos";
        $data['page_functions_js'] = "functions_productos.js";
        $this->views->getView($this,"productos",$data);
    }

  }