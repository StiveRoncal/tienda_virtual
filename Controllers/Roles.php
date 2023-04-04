<?php


    // Heredacion
  class Roles extends Controllers{

    public function __construct(){
        // Ejecucion de dos metodos por su herencia y constructor de libnrtaties controllers
    parent::__construct();

    }

    // 1er Metodo

    public function Roles(){
        // arreglo de un parametro $data
        $data['page_id'] = 3;
        $data['page_tag'] = "Roles Usuarios";
        $data['page_name'] = "rol_usuario"; 
        $data['page_title'] = "Roles Usuario <small>Tienda Virtual</small>";
 

        // invocar la vista su metodo libraries/Core/Views.php
        $this->views->getView($this,"roles",$data);
    }


  

  }
?>