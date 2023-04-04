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
        $data['page_id'] = 1;
        $data['page_tag'] = "Home";
        $data['page_title'] = "Página Principal, Stive Roncal";
        $data['page_name'] = "home";
        $data['page_content'] = "Lorem";

        // invocar la vista su metodo libraries/Core/Views.php
        $this->views->getView($this,"home",$data);
    }


  

  }
?>