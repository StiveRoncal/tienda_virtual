<?php



  class Dashboard extends Controllers{

    public function __construct(){
        // Ejecucion de dos metodos por su herencia y constructor de libnrtaties controllers
    parent::__construct();

    }

    // 1er Metodo

    public function dashboard(){
        // arreglo de un parametro $data
        $data['page_id'] = 2;
        $data['page_tag'] = "Dashboard - Tienda Virtual";
        $data['page_title'] = "Dashboard - Tienda Virtual";
        $data['page_name'] = "dashboard";
   

        // invocar la vista su metodo libraries/Core/Views.php
        $this->views->getView($this,"dashboard",$data);
    }


  

  }
?>