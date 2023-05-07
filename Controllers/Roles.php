<?php


    // Heredacion
  class Roles extends Controllers{

    public function __construct(){
      // Ejecucion de dos metodos por su herencia y constructor de libnrtaties controllers
      parent::__construct();

      // session_start();
      // Reempalzo de session_start y usar un helper con timer de session activa
      sessionStart();


      // Indiciar que el id(SESSION(memoria interna)) Anterior se eliminar cuando cerramos seccion
      // session_regenerate_id(true);


      if(empty($_SESSION['login'])){

          header('Location:'.base_url().'/login');
          die();
      }
    //  agara dos modulos usuarios y roles
      getPermisos(2);

    }

    // 1er Metodo

    public function Roles(){

      
        //validacion si no tiene permisos asignados redireccion 
        if(empty($_SESSION['permisosMod']['r']) ){

          header("Location:".base_url().'/dashboard');

        }

        // arreglo de un parametro $data
        $data['page_id'] = 3;
        $data['page_tag'] = "Roles Usuarios";
        $data['page_name'] = "rol_usuario"; 
        $data['page_title'] = "Roles Usuario <small>Tienda Virtual</small>";
        $data['page_functions_js'] = "functions_roles.js";
 

        // invocar la vista su metodo libraries/Core/Views.php
        $this->views->getView($this,"roles",$data);
    }


    // 3er Medto Relacionado con Functions_Roles.js  fntRolesUsuario();
    // Selecionar Todos los Roles En Un Select de bootstrap-select en Libreria
    public function getSelectRoles(){

      // Variable vacioa
      $htmlOptions = "";
      // Varaible que usa un modelo su metodo
      $arrData = $this->model->selectRoles();

      // Condicional, Si la cantidad de Registro de la varaible que extrea todo los roles es maypr a o0 si hay registro
      if(count($arrData) > 0 ){

        // incementecaion de roles que selcciona uno por 1
        for($i=0; $i < count($arrData); $i++){
            // validacion de roles para que no se muestre en ususarios cuando esten vacios en selectoption
            if($arrData[$i]['status'] == 1){
          // Armado de options con los roles
            $htmlOptions .= '<option value="'.$arrData[$i]['idrol'].'">'.$arrData[$i]['nombrerol'].'</option>';
            }
        }
      }
      echo $htmlOptions;
      die();
    }

    // 2do Metodo Obtener Roles
    public function getRoles(){

      if($_SESSION['permisosMod']['r']){
          $arrData = $this->model->selectRoles();

          // Condicional de contar arregloo y validar si son 1 o 0 i
          for($i=0; $i < count($arrData); $i++){

              // Varaibles para Sessiones de permisos
              $btnView = '';
              $btnEdit = '';
              $bntDelete = '';
              

            // Condicional 1 si es activo el status
            if($arrData[$i]['status'] == 1){
              // Guardamos el valor en un html como boton 
                $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
            }else{

                $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
            }



      
              // BOTON 02 Permisos (u=>update)(ACTUALIZAR) Boton Lapiz
              if($_SESSION['permisosMod']['u']){
                
                $btnView = '<button class="btn btn-secondary btn-sm btnPermisosRol" onClick="fntPermisos('.$arrData[$i]['idrol'].')" title="Permisos"><i class="fas fa-key"></i></button>';
                $btnEdit = '<button class="btn btn-primary btn-sm btnEditRol" onClick="fntEditRol('.$arrData[$i]['idrol'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
              
              }
      
              // BOTON 03 Permisos (d=>delte)(ELIMINAR) Boton tacho de basura
              if($_SESSION['permisosMod']['d']){
      
                $bntDelete = '<button class="btn btn-danger btn-sm btnDelRol" onClick="fntDelRol('.$arrData[$i]['idrol'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>';
              }
      
              //  Concadenamiento de varaibles para mostras botones de acciones
              $arrData[$i]['options'] = '
              <div class="text-center">'.$btnView.' '.$btnEdit.' '.$bntDelete.' </div>';

          }
          // json_encode: devuele los datos de variables en formato json
          // JSON_UNESCAPED_UNICODE: evita caracteres especiales
          echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
      }
      die();
    }

    // metodo para extraer un rol para el editar
    public function getRol(int $idrol){

      if($_SESSION['permisosMod']['r']){
        $intIdrol = intval(strClean($idrol));

          // condicional si el datos tiene un id validos realizo procesos
          if($intIdrol > 0){

                $arrData = $this->model->selectRol($intIdrol);
                // Si no encontro o esta vacia manda errror
                // Basicamente hace si detecta el id Existe lo corre si no manda mensahe de error
                if(empty($arrData)){

                  $arrResponse = array('status' => false, 'msg' => 'Datos No Encontrados.');
                }else{

                  $arrResponse = array('status'=> true, 'data' => $arrData);
                }

                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

            }
      }

      die();

    }

    // Metod para actualizar o crear usuario cumple doble funcionamiento

    public function setRol(){

      if($_SESSION['permisosMod']['w']){
      // dep($_POST);
          // Para El Id ya ponder nuevo rol
          $intIdrol = intval($_POST['idRol']);
          // almacenar datos guardano la varaibles del los campos
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

    // metodo para eliminar el Rol
    public function delRol(){
      
          // si se envio
          if($_POST){
            if($_SESSION['permisosMod']['d']){
                // varaiblke que guarda el  el idrol
                $intIdrol = intval($_POST['idrol']);

                // ejecuta un proceso desde el modelo para eliminar
                $requestDelete = $this->model->deleteRol($intIdrol);

                // Si mi respuesta es OK
                if($requestDelete == 'ok'){

                  // Ejecuta el mensaje del proceso
                  $arrResponse = array('status' => true, 'msg' => 'Se Ha Eliminado El Rol');
                // de lo contraio manda error
                }else if($requestDelete == 'exist'){

                  $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un Rol asociado a Usuario');
                }
                // varaible guardado en json evitando caracteres especiales

                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
              }
            }
              // De lo contrario muere
              die();

        }
    

  }
?>