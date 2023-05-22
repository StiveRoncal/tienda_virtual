<?php


    // Heredacion
  class Home extends Controllers{

    public function __construct(){
        // Ejecucion de dos metodos por su herencia y constructor de libnrtaties controllers
    parent::__construct();

    }

    // 1er Metodo

    public function home(){
        // arreglo de un parametro $data

        $data['page_tag'] = NOMBRE_EMPRESA;
        $data['page_title'] = NOMBRE_EMPRESA;
        $data['page_name'] = "tienda_Virtual";
        $data['page_content'] = "Lorem"; 
        // invocar la vista su metodo libraries/Core/Views.php
        $this->views->getView($this,"home",$data);
    }


  

  }
?>