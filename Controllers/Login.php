<?php


  // Heredacion
  class Login extends Controllers{

    public function __construct(){
       
        parent::__construct();

    }



    public function login(){
      
        $data['page_tag'] = "Login -  Tienda Virtual Stive";
        $data['page_title'] = "Login - Mi Tienda Virtual";
        $data['page_name'] = "login";
        // Nueva JS
        $data['page_functions_js'] = "functions_login.js";
       
        $this->views->getView($this,"login",$data);
    }


    #1 funcion para 
    public function loginUser(){

      dep($_POST);
      die();
    }

  

  }
?>