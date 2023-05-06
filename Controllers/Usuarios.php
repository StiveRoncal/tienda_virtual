<?php

  //Creamos la Ruta http://localhost:81/tienda_virtual/usuarios    

  class Usuarios extends Controllers{

    
    public function __construct(){

      
      parent::__construct();
      
      session_start();

      if(empty($_SESSION['login'])){

          header('Location:'.base_url().'/login');

      }


      getPermisos(2);

    }

    // 1er Metodo

    public function Usuarios(){

        //validacion si no tiene permisos asignados redireccion 
        if(empty($_SESSION['permisosMod']['r']) ){

          header("Location:".base_url().'/dashboard');

        }
        // arreglo de un parametro $data
   
        $data['page_tag'] = "Usuarios";
        $data['page_title'] = "Usuarios <small>Tienda Virtual</small>";
        $data['page_name'] = "usuarios";
        $data['page_functions_js'] = "functions_usuarios.js";

        // invocar la vista su metodo libraries/Core/Views.php
        $this->views->getView($this,"usuarios",$data);
    }


    //actulizar o agregar usuario
    public function setUsuario(){
      if($_POST){
        

        if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) 
        || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listRolid']) || empty($_POST['listStatus'])){
          
          $arrResponse = array("status" => false, "msg" => 'Datos Incorrectos');

        }else{

            $idUsuario = intval($_POST['idUsuario']);
            $strIdentificacion = strClean($_POST['txtIdentificacion']);
            $strNombre = ucwords(strClean($_POST['txtNombre']));
            $strApellido = ucwords(strClean($_POST['txtApellido']));
            $intTelefono = intval(strClean($_POST['txtTelefono']));
            $strEmail = strtolower(strClean($_POST['txtEmail']));
            $intTipoId = intval(strClean($_POST['listRolid']));
            $intStatus = intval(strClean($_POST['listStatus']));

            // Crear Usuario
            if($idUsuario == 0){

              $option = 1;
              $strPassword = empty($_POST['txtPassword']) ? hash("SHA256", passGenerator()) : hash("SHA256", $_POST['txtPassword']);

              $request_user = $this->model->insertUsuario($strIdentificacion,
                                                          $strNombre,
                                                          $strApellido,
                                                          $intTelefono,
                                                          $strEmail,
                                                          $strPassword,
                                                          $intTipoId,
                                                          $intStatus );

            }else{

              $option = 2;
              $strPassword = empty($_POST['txtPassword']) ? "" : hash("SHA256", $_POST['txtPassword']);

              $request_user = $this->model->updateUsuario($idUsuario,
                                                          $strIdentificacion,
                                                          $strNombre,
                                                          $strApellido,
                                                          $intTelefono,
                                                          $strEmail,
                                                          $strPassword,
                                                          $intTipoId,
                                                          $intStatus );

            } 

          

           if($request_user > 0){

                // Condicion si se hizo insert = 1 o Update = 2
                if($option == 1){

                  $arrResponse = array('status' => true, 'msg' =>'Datos Guardado Correctamente');

                }else{

                  $arrResponse = array('status' => true, 'msg' =>'Datos Actualizados Correctamente');

                }
              
           }else if($request_user == 'exist'){

                $arrResponse = array('status' => false, 'msg' => 'Atencion El email o identificacion ya Existe, ingrese otro');

           }else{

                $arrResponse = array("status" => false, "msg" => 'No es posible almacenar Datos');
           }
        }

        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
      }
    
      die();
    }

    public function getUsuarios(){

      $arrData = $this->model->selectUsuarios();
      
      for($i=0; $i < count($arrData); $i++){

        // Varaibles para Sessiones de permisos
        $btnView = '';
        $btnEdit = '';
        $bntDelete = '';
        

        // VALIDAD ESTADO
        if($arrData[$i]['status'] == 1){
          
            $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
        }else{

            $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
        }

        // BOTON 01 Permisos (r=>read)(LEER) Boton Ojito
        if($_SESSION['permisosMod']['r']){

          $btnView = '<button class="btn btn-info btn-sm btnViewUsuario" onClick="fntViewUsuario('.$arrData[$i]['idpersona'].')" title="Ver usuario"><i class="far fa-eye"></i></button>';
        }

        // BOTON 02 Permisos (u=>update)(ACTUALIZAR) Boton Lapiz
        if($_SESSION['permisosMod']['u']){

          // validacion para evitar que usuario root de permisos a terceros solo puedo hacer eso el SUPERADMIN(stiveroncal)
          // si este es el usuario master tanto el iduser y el idrol primero // indicando si la varaible de seccion es la 1 o deferente de 1 no es administrador
          if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrol'] == 1) || ($_SESSION['userData']['idrol'] == 1 and $arrData[$i]['idrol'] != 1)){

            $btnEdit = '<button class="btn btn-primary btn-sm btnEditUsuario" onClick="fntEditUsuario('.$arrData[$i]['idpersona'].')" title="Editar usuario"><i class="fas fa-pencil-alt"></i></button>';


          }else{

            $btnEdit = '<button class="btn btn-secondary btn-sm" disabled><i class="fas fa-pencil-alt"></i></button>';
          }

        
        }

        // BOTON 03 Permisos (d=>delte)(ELIMINAR) Boton tacho de basura
        if($_SESSION['permisosMod']['d']){
          
          // validacion para evitar que usuario root de permisos a terceros solo puedo hacer eso el SUPERADMIN(stiveroncal)
          // si este es el usuario master tanto el iduser y el idrol primero // indicando si la varaible de seccion es la 1 o deferente de 1 no es administrador
          // Indicar si la varaible si tanbia es la misma persona del super admin

            if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrol'] == 1) ||
              ($_SESSION['userData']['idrol'] == 1 and $arrData[$i]['idrol'] != 1) and 
              ($_SESSION['userData']['idpersona'] != $arrData[$i]['idpersona'])){

                $bntDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelUsuario('.$arrData[$i]['idpersona'].')" title="Eliminar usuario"><i class="far fa-trash-alt"></i></button>';
            }else{
                $bntDelete = '<button class="btn btn-secondary btn-sm" disabled><i class="far fa-trash-alt"></i></button>';
            }
        }

      //  Concadenamiento de varaibles para mostras botones de acciones
        $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$bntDelete.' </div>';
      }
      
      echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
      die();

    }


    public function getUsuario(int $idpersona){

      $idusuario = intval($idpersona);
      if($idpersona > 0){

        $arrData = $this->model->selectUsuario($idusuario);
        
        // Condiciona y hay o se excede de numero no existe
        if(empty($arrData)){
          
          $arrResponse = array('status' => false, 'msg' => 'Datos No Encontrado, Se Excedio de Numero');

        }else{

          $arrResponse = array('status' => true, 'data' => $arrData);

        }

        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
      }
      die();
    }

    // Eliminar Usuario

    public function delUsuario(){
      if($_POST){

        $intIdpersona = intval($_POST['idUsuario']);
        $requestDelete = $this->model->deleteUsuario($intIdpersona);

        if($requestDelete){

          $arrResponse = array('status' => true, 'msg' => 'Se Ha Eliminado El Usuario');
        }else{

          $arrResponse = array('status' => false, 'msg' => 'Error al eliminar Usuario');
        }

        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
      }

      die();
    }

    // METODO PARA PERFIL con Funciones Similares
    public function perfil(){

       // arreglo de un parametro $data
       $data['page_tag'] = "Perfil";
       $data['page_title'] = "Perfil de Usuario";
       $data['page_name'] = "perfil";
       $data['page_functions_js'] = "functions_usuarios.js";

       // invocar la vista su metodo libraries/Core/Views.php
       $this->views->getView($this,"perfil",$data);

    }
  

  }
?>