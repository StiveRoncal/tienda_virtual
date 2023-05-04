<?php



  class Dashboard extends Controllers{

    public function __construct(){
        // Ejecucion de dos metodos por su herencia y constructor de libnrtaties controllers
    
        parent::__construct();
      //validar la session si esta cerro y no regresar
      session_start();
      
      // condicional si no esxiste la variabe¿le seesion
      if(empty($_SESSION['login'])){

        //redireciona 
        header('location: '.base_url().'/login');
      }

        // getPermisos(1);
      
    }

    // 1er Metodo

    public function dashboard(){
        // arreglo de un parametro $data
        $data['page_id'] = 2;
        $data['page_tag'] = "Dashboard - Tienda Virtual";
        $data['page_title'] = "Dashboard - Tienda Virtual";
        $data['page_name'] = "dashboard";
        // $data['page_functions_js'] = "functions_dashboard.js";
   

        // invocar la vista su metodo libraries/Core/Views.php
        $this->views->getView($this,"dashboard",$data);
    }


  

  }
?>