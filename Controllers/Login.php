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

              // Varaible que almacena un modelo como variables de session de una funcion que deuvel y parametro de idusuario
              // cargar los datos sin cerrar sesion
              $arrData =$this->model->sessionLogin($_SESSION['idUser']);
              // obtener todos los datos de usuario y alamdenra en vraible de ssion
              $_SESSION['userData'] = $arrData;
              
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

  
    // #2 metodo para recetar usuario con correo

    public function resetPass(){
      // validar si se envio un post
      if($_POST){
        
        // valida el campo email
        if(empty($_POST['txtEmailReset'])){

          $arrResponse = array('status' => false, 'msg' => 'Error de Datos');
        }else{
          // Variable token que esta en helper
          $token = token();

          $strEmail = strtolower(strClean($_POST['txtEmailReset']));
          $arrData = $this->model->getUserEmail($strEmail);

          // validar no encontro usuario
          if(empty($arrData)){

            $arrResponse = array('status'=>false, 'msg' => 'Usuario que no existe');
          }else{

            // devuelve datos sql
            $idpersona = $arrData['idpersona'];
            $nombreUsuario = $arrData['nombres'].' '.$arrData['apellidos'];

            // Varable que alamcena la ruta para establecer la contraseña

            $url_recovery = base_url().'/login/confirmUser/'.$strEmail.'/'.$token;

            // invoka funcion de modelo para actualiza toke
            $requestUpdate = $this->model->setTokenUser($idpersona,$token);

            // MEnsejes si cumpplio
            if($requestUpdate){

              $arrResponse = array('status' => true, 'msg' => 'Se Ha Enviado Un Email a tu Cuenta de Correo Para cambiar Tu Contraseña');

            }else{  

              $arrResponse = array('status'=> false, 'msg' => 'No es posible realizar el proceso, Intenta más tarde');
            }

          }
        }

        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

      }

      die();
    }

    // #3 Metodo para confirma el usuario para restablecer nueva contraseña
    public function confirmUser(string $params){

      // Validar si trae un parametro en la url no aceptado por token, direccionamos
      if(empty($params)){
        header('Location: '.base_url());
      }else{
        // de lo contrario obtenemos estos parametros
        // explode convertir array separando por coma 
        $arrParams = explode(',',$params);
        // poscion de los arreglos
        $strEmail = strClean($arrParams[0]);
        $strToken = strClean($arrParams[1]);

        // consulta hacia db por medio de modelo
        $arrResponse = $this->model->getUsuario($strEmail,$strToken);
        // validar la consulta, si esta vacio retorna a la pagina principal
        if(empty($arrResponse)){
            header("Location: ".base_url());
        }else{
          // Muestra la Vista

           // Arreglo para cambiar otro pagina con otros datos
              $data['page_tag'] = "Cambiar constraseña";
              $data['page_name'] = "cambiar_contrasenia";
              $data['page_title'] = "Cambiar Contraseña";
              $data['email'] = $strEmail;
              $data['token'] = $strToken;
              $data['idpersona'] = $arrResponse['idpersona'];
              $data['page_functions_js'] = "functions_login.js";
              // regerencia al archivo de la vista
              $this->views->getView($this,"cambiar_password",$data);
          }

        }
       die();
   
    }


    // #4 Metodo

    public function setPassword(){
      //Validar datos que no vallen vacio
      if(empty($_POST['idUsuario']) || empty($_POST['txtEmail']) || empty($_POST['txtToken']) || empty($_POST['txtPassword']) || empty($_POST['txtPasswordConfirm'])){

        $arrResponse = array('status' => false, 'msg' => 'Error de Datos..');

      }else{

        $intIdpersona = intval($_POST['idUsuario']);
        $strPassword = $_POST['txtPassword'];
        $strPasswordConfirm = $_POST['txtPasswordConfirm'];
        $strEmail = strClean($_POST['txtEmail']);
        $strToken = strClean($_POST['txtToken']);

        if($strPassword != $strPasswordConfirm){

          $arrResponse = array('status' => false, 'msg' => 'Las contraseñas no son iguales X(');
        }else{

            $arrResponseUser = $this->model->getUsuario($strEmail,$strToken);
            
            if(empty($arrResponseUser)){
                $arrResponse = array('status' => false, 'msg' => 'Error de Datos X(');
            }else{

                // proceso de actualizacon de datos
                // 
                $strPassword = hash("SHA256",$strPassword);
                $requestPass = $this->model->insertPassword($intIdpersona,$strPassword);

                if($requestPass){

                  $arrResponse = array('status' => true, 'msg' => 'Contraseña Actualizada con Exito');

                }else{

                  $arrResponse = array('status'=> false, 'msg' => 'No es posible realizar el proceso, Intente mas tarde');

                }

            }

        }
      }
      echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
      die();
    }

  }
?>