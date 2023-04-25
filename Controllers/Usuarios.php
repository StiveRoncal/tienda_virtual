<?php

  //Creamos la Ruta http://localhost:81/tienda_virtual/usuarios    

  class Usuarios extends Controllers{

    public function __construct(){

    parent::__construct();

    }

    // 1er Metodo

    public function Usuarios(){
        // arreglo de un parametro $data
   
        $data['page_tag'] = "Usuarios";
        $data['page_title'] = "Usuarios <small>Tienda Virtual</small>";
        $data['page_name'] = "usuarios";
        

        // invocar la vista su metodo libraries/Core/Views.php
        $this->views->getView($this,"usuarios",$data);
    }

    public function setUsuario(){
      if($_POST){

        if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) 
        || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listRolid']) || empty($_POST['listStatus'])){
          
          $arrResponse = array("status" => false, "msg" => 'Datos Incorrectos');

        }else{

            $strIdentificacion = strClean($_POST['txtIdentificacion']);
            $strNombre = ucwords(strClean($_POST['txtNombre']));
            $strApellido = ucwords(strClean($_POST['txtApellido']));
            $intTelefono = intval(strClean($_POST['txtTelefono']));
            $strEmail = strtolower(strClean($_POST['txtEmail']));
            $intTipoId = intval(strClean($_POST['listRolid']));
            $intStatus = intval(strClean($_POST['listStatus']));

            $strPassword = empty($_POST['txtPassword']) ? hash("SHA256", passGenerator()) : hash("SHA256", $_POST['txtPassword']);

            $request_user = $this->model->insertUsuario($strIdentificacion,
                                                        $strNombre,
                                                        $strApellido,
                                                        $intTelefono,
                                                        $strEmail,
                                                        $strPassword,
                                                        $intTipoId,
                                                        $intStatus );

           if($request_user > 0){

                $arrResponse = array('status' => true, 'msg' =>'Datos Guardado Correctamente');
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


  

  }
?>