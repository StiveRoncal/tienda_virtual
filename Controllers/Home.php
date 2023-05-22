<?php

  // Incluimos archivo Trait
  // clase no permite hacer herencias multiple
  require_once("Models/TCategoria.php");

  // Heredacion
  class Home extends Controllers{

    // Sentencia para usar un Trait
    use TCategoria;

    public function __construct(){
        // Ejecucion de dos metodos por su herencia y constructor de libnrtaties controllers
    parent::__construct();

    }

    // 1er Metodo

    public function home(){
        

        $data['page_tag'] = NOMBRE_EMPRESA;
        $data['page_title'] = NOMBRE_EMPRESA;
        $data['page_name'] = "tienda_Virtual";
        $data['slider'] = $this->getCategoriasT(CAT_SLIDER);
        $data['banner'] = $this->getCategoriasT(CAT_BANNER);

        // dep($data);
        // invocar la vista su metodo libraries/Core/Views.php
        $this->views->getView($this,"home",$data);
    }


  

  }
?>