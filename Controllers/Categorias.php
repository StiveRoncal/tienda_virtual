<?php

  //Creamos la Ruta http://localhost:81/tienda_virtual/usuarios    

  class Categorias extends Controllers{

    
    public function __construct(){

        // Reempalzo de session_start y usar un helper con timer de session activa
        sessionStart();
        
        parent::__construct();
        
        if(empty($_SESSION['login'])){

            header('Location:'.base_url().'/login');
            die();
        }

        // En el tabla modulo esta El nro 6 el ID
        getPermisos(6);

    }


    public function Categorias(){

        //validacion si no tiene permisos asignados redireccion 
        if(empty($_SESSION['permisosMod']['r']) ){

          header("Location:".base_url().'/dashboard');

        }

        $data['page_tag'] = "Categorias";
        $data['page_title'] = "CATEGORIAS <small>Tienda Virtual</small>";
        $data['page_name'] = "categorias";
        $data['page_functions_js'] = "functions_categorias.js";
        $this->views->getView($this,"categorias",$data);
    }



    // Metodo para Almacenar datos en Base de Datos de formulario categoria
    public function setCategoria(){
      dep($_POST);
      dep($_FILES);exit;
      if($_SESSION['permisosMod']['w']){
     
          $intIdrol = intval($_POST['idRol']);
        
          $strRol = strClean($_POST['txtNombre']);
          $strDescripcion = strClean($_POST['txtDescripcion']);
          $intStatus = intval($_POST['listStatus']);
          

          // Validacion para el nuevo rol para actualizar, si no viene Id Crea uno nuevo, va respuesta para cactular o crear
          if($intIdrol == 0){
          
            // Crear
            $request_rol = $this->model->insertRol($strRol,$strDescripcion,$intStatus);
            $option = 1;
          }else{

            // Actualizar
            $request_rol = $this->model->updateRol($intIdrol,$strRol,$strDescripcion,$intStatus);
            $option = 2;

          }


          // condicial lo de insertol
          // Si se inserto el registreo 
          if($request_rol > 0){

            // Opcion si es 1 crear si es 2 se actualizo
            if($option == 1){

              $arrResponse = array('status'=>true, 'msg'=> 'Datos Guardados Correctamente');
            }else{
              $arrResponse = array('status'=>true, 'msg'=> 'Datos Actualizados Correctamente');
            }
          }else if($request_rol == 'exist'){

            $arrResponse = array('status' => false, 'msg' => '¡Atencion! El Rol Ya existe');
          }else{

            $arrResponse = array("status" => false, 'msg' => 'No es posible almacenar los datos');
          }
          // sleep(3);
          echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
      }
          die();

    }

  

  }
?>