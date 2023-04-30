<?php


  // Heredacion
  class Login extends Controllers{

    public function __construct(){
      // Iniciar una variable de sesion
      session_start();
      // condicional si esxiste la variabe¿le seesion
      if(isset($_SESSION['login'])){

        //redireciona 
        header('Location: '.base_url().'/dashboard');
      }

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


    #1 funcion para ingresar a login 
    public function loginUser(){

      // dep($_POST);
      if($_POST){
        // validacion de campos vacios
        if(empty($_POST['txtEmail']) || empty($_POST['txtPassword'])){

          $arrResponse = array('status' => false, 'msg' => 'Error de Datos');

        }else{

          // almacenar datos recibidos
          $strUsuario = strtolower(strClean($_POST['txtEmail']));
          $strPassword = hash("SHA256",$_POST['txtPassword']);
          $requestUser = $this->model->loginUser($strUsuario, $strPassword);

          // Validar
          if(empty($requestUser)){

            $arrResponse = array('status' => false, 'msg' => 'El usuario o la constraseña es incorrecta.');

          }else{

            $arrData = $requestUser;

            // validacion de estato
            if($arrData['status'] == 1){

              // Creacion de varaivle de sesion
              $_SESSION['idUser'] = $arrData['idpersona'];
              $_SESSION['login'] = true;
              
              // si hizo login de forma correcta
              $arrResponse = array('status'=>true, 'msg' => 'OK');


            }else{
                $arrResponse = array('status' => false, 'msg' => 'Usuario Inactivo');
            }
          }

        }
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
      }
      die();
    }

  

  }
?>