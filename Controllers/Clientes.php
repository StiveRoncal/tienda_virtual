<?php


class Clientes extends Controllers{

    
    public function __construct(){

      // Reempalzo de session_start y usar un helper con timer de session activa
      sessionStart();
      
      
      parent::__construct();
      
      // session_start();


      // Indiciar que el id(SESSION(memoria interna)) Anterior se eliminar cuando cerramos seccion
      // session_regenerate_id(true); 


      if(empty($_SESSION['login'])){

          header('Location:'.base_url().'/login');
          die();
      }

    //   Modulo Cliente(3) tbl.modulo -> Clientes
      getPermisos(3);

    }

    // 1er Metodo

    public function Clientes(){

        //validacion si no tiene permisos asignados redireccion 
        if(empty($_SESSION['permisosMod']['r']) ){

          header("Location:".base_url().'/dashboard');

        }
        // arreglo de un parametro $data
   
        $data['page_tag'] = "Clientes";
        $data['page_title'] = "CLIENTES <small>Tienda Virtual</small>";
        $data['page_name'] = "clientes";
        $data['page_functions_js'] = "functions_clientes.js";

        // invocar la vista su metodo libraries/Core/Views.php
        $this->views->getView($this,"clientes",$data);
    }



    // 2do Metodo Agregar Y Actualizar cliente 

    public function setCliente(){

  
      if($_POST){
      
   
        if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) 
        || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['txtDni']) ||
         empty($_POST['txtNomFiscal']) || empty($_POST['txtDirFiscal'])){
          
          $arrResponse = array("status" => false, "msg" => 'Datos Incorrectos');

        }else{

            $idUsuario = intval($_POST['idUsuario']);
            $strIdentificacion = strClean($_POST['txtIdentificacion']);
            $strNombre = ucwords(strClean($_POST['txtNombre']));
            $strApellido = ucwords(strClean($_POST['txtApellido']));
            $intTelefono = intval(strClean($_POST['txtTelefono']));
            $strEmail = strtolower(strClean($_POST['txtEmail']));
            
            // Variable de DATOS FISCALES
            $strDni = strClean($_POST['txtDni']);
            $strNomFiscal = strClean($_POST['txtNomFiscal']);
            $strDirFiscal = strClean($_POST['txtDirFiscal']);


            // Roles de los clientes Corresponden al Id=7
            $intTipoId = 7;


            // VALOR VACIO
            $request_user = "";
            // Crear Usuario

            if($idUsuario == 0){

              $option = 1;
              $strPassword = empty($_POST['txtPassword']) ? passGenerator() : $_POST['txtPassword'];

              $strPasswordEncript = hash("SHA256", $strPassword) ;
              if($_SESSION['permisosMod']['w']){
              
              $request_user = $this->model->insertCliente($strIdentificacion,
                                                          $strNombre,
                                                          $strApellido,
                                                          $intTelefono,
                                                          $strEmail,
                                                          $strPasswordEncript,
                                                          $intTipoId,
                                                          $strDni,
                                                          $strNomFiscal,
                                                          $strDirFiscal );
              }
             } else{

              $option = 2;
              $strPassword = empty($_POST['txtPassword']) ? "" : hash("SHA256", $_POST['txtPassword']);


              if($_SESSION['permisosMod']['u']){
                $request_user = $this->model->updateCliente($idUsuario,
                                                          $strIdentificacion,
                                                          $strNombre,
                                                          $strApellido,
                                                          $intTelefono,
                                                          $strEmail,
                                                          $strPassword,
                                                          $strDni,
                                                          $strNomFiscal,
                                                          $strDirFiscal);
              }
            } 

          

           if($request_user > 0){

                // Condicion si se hizo insert = 1 o Update = 2
                if($option == 1){

                  $arrResponse = array('status' => true, 'msg' =>'Datos Guardado Correctamente');
                      //Variable par nombre usuario
                      $nombreUsuario = $strNombre.' '.$strApellido; 
                      // Codigo : Para El Correo Electronico Recuerda
                      $dataUsuario = array('nombreUsuario'=> $nombreUsuario,
                                        'email' => $strEmail,
                                        'password' => $strPassword,
                                        'asunto' => 'Bienvenido a Tu tienda en Línea');
                      $sendEmail = sendEmail($dataUsuario,'email_bienvenida');

                }
                else{

                  $arrResponse = array('status' => true, 'msg' =>'Datos Actualizados Correctamente');

                }

              
           }else if($request_user == false){

                $arrResponse = array('status' => false, 'msg' => 'Atencion El email o identificacion ya Existe, ingrese otro');

           }else{

                $arrResponse = array("status" => false, "msg" => 'No es posible almacenar Datos');
           }
        }
        // sleep(3);
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
      }
    
      die();
    }



    // 3er Metodo LISTAR CLIENTES y Botones
    public function getClientes(){

      // Validacion para que no accesar roles secundarios sin permisos de root
      if($_SESSION['permisosMod']['r']){

     
      $arrData = $this->model->selectClientes();
        

      for($i=0; $i < count($arrData); $i++){

        // Varaibles para Sessiones de permisos
        $btnView = '';
        $btnEdit = '';
        $bntDelete = '';
        

        // BOTON 01 Permisos (r=>read)(LEER) Boton Ojito
        if($_SESSION['permisosMod']['r']){

          $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['idpersona'].')" title="Ver Cliente"><i class="far fa-eye"></i></button>';
        }

        // BOTON 02 Permisos (u=>update)(ACTUALIZAR) Boton Lapiz
        if($_SESSION['permisosMod']['u']){

            $btnEdit = '<button class="btn btn-primary btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['idpersona'].')" title="Editar Cliente"><i class="fas fa-pencil-alt"></i></button>';
  
        }

        // BOTON 03 Permisos (d=>delte)(ELIMINAR) Boton tacho de basura
        if($_SESSION['permisosMod']['d']){
          
            $bntDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idpersona'].')" title="Eliminar Cliente"><i class="far fa-trash-alt"></i></button>';

        }

      //  Concadenamiento de varaibles para mostras botones de acciones
        $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$bntDelete.' </div>';
      }
      
      echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
    }
      die();

    }


    // 3er Metodo SELECIONAR UN CLIENTE ESPECIFICO
    public function getCliente($idpersona){

      // Validacion de para acceso de resticcion de roles secundario sin o tienen permisos
      if($_SESSION['permisosMod']['r']){

        $idusuario = intval($idpersona);
        if($idpersona > 0){

          $arrData = $this->model->selectCliente($idusuario);
          
          // Condiciona y hay o se excede de numero no existe
          if(empty($arrData)){
            
            $arrResponse = array('status' => false, 'msg' => 'Datos No Encontrado, Porque no es Un CLiente Sino  Datos de Otros Roles Senatino x( ');

          }else{

            $arrResponse = array('status' => true, 'data' => $arrData);

          }

          echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
      }
      die();
    }


    // Eliminar Cliente
    public function delCliente(){
      if($_POST){
        

        if($_SESSION['permisosMod']['d']){

            $intIdpersona = intval($_POST['idUsuario']);
            $requestDelete = $this->model->deleteCliente($intIdpersona);

            if($requestDelete){

              $arrResponse = array('status' => true, 'msg' => 'Se Ha Eliminado El Cliente');
            }else{

              $arrResponse = array('status' => false, 'msg' => 'Error al eliminar al Cliente');
            }

            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
    }
      die();
    }



    }
?>