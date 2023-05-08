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
            // $request_user = "";
            // Crear Usuario

            if($idUsuario == 0){

              $option = 1;
              $strPassword = empty($_POST['txtPassword']) ? hash("SHA256", passGenerator()) : hash("SHA256", $_POST['txtPassword']);

              // if($_SESSION['permisosMod']['w']){}
              
              $request_user = $this->model->insertCliente($strIdentificacion,
                                                          $strNombre,
                                                          $strApellido,
                                                          $intTelefono,
                                                          $strEmail,
                                                          $strPassword,
                                                          $intTipoId,
                                                          $strDni,
                                                          $strNomFiscal,
                                                          $strDirFiscal );
              
            } //else{

              // $option = 2;
              // $strPassword = empty($_POST['txtPassword']) ? "" : hash("SHA256", $_POST['txtPassword']);


              // if($_SESSION['permisosMod']['u']){
              //   $request_user = $this->model->updateUsuario($idUsuario,
              //                                             $strIdentificacion,
              //                                             $strNombre,
              //                                             $strApellido,
              //                                             $intTelefono,
              //                                             $strEmail,
              //                                             $strPassword,
              //                                             $intTipoId,
              //                                             $intStatus );
              // }

                



            // } 

          

           if($request_user > 0){

                // Condicion si se hizo insert = 1 o Update = 2
                if($option == 1){

                  $arrResponse = array('status' => true, 'msg' =>'Datos Guardado Correctamente');

                }
                else{

                  $arrResponse = array('status' => true, 'msg' =>'Datos Actualizados Correctamente');

                }

              
           }else if($request_user == 'exist'){

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


    }
?>