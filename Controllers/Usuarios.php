<?php

  //Creamos la Ruta http://localhost:81/tienda_virtual/usuarios    

  class Usuarios extends Controllers{

    public function __construct(){

    parent::__construct();

    }

    // 1er Metodo

    public function Usuarios(){
        // arreglo de un parametro $data
   
        $data['page_tag'] = "Usuarios";
        $data['page_title'] = "Usuarios <small>Tienda Virtual</small>";
        $data['page_name'] = "usuarios";
        

        // invocar la vista su metodo libraries/Core/Views.php
        $this->views->getView($this,"usuarios",$data);
    }


  

  }
?>