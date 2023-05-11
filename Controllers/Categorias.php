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
    
      if($_POST){

          if(empty($_POST['txtNombre']) || empty($_POST['txtDescripcion']) || empty($_POST['listStatus']) ){

              $arrResponse = array("status" => false, "msg" => 'Datos Incorrectos.');
              
          }else{

              $intIdCategoria = intval($_POST['idCategoria']);
              $strCategoria = strClean($_POST['txtNombre']);
              $strDescripcion = strClean($_POST['txtDescripcion']);
              $intStatus = intval($_POST['listStatus']);


              // Variable para almacenar los DATOS DE IMG
              $foto         = $_FILES['foto'];
              $nombre_foto  = $foto['name'];
              $type         = $foto['type'];
              $url_temp     = $foto['tmp_name'];

              $fecha        = date('ymd');
              $hora         = date('Hms');
              $imgPortada   = 'img_portada.png';

              // Validacion de img si entra img vacio o no vacia

              // Se esta enviando un img 
              if($nombre_foto != ''){

                $imgPortada = 'img_'.md5(date('d-m-Y H:m:s')).'.jpg';

              }


              // VALIDACION SI se va CREAR O ACTUALIZAR

              if($intIdCategoria == 0){
          
                // Crear
                $request_categoria = $this->model->insertCategoria($strCategoria,$strDescripcion,$imgPortada,$intStatus);
                $option = 1;
              }else{
    
                // Actualizar
                $request_categoria = $this->model->updateCategoria($intIdrol,$strRol,$strDescripcion,$intStatus);
                $option = 2;
    
              }


              if($request_categoria > 0){

                // Opcion si es 1 crear si es 2 se actualizo
                if($option == 1){
    
                  $arrResponse = array('status'=>true, 'msg'=> 'Datos Guardados Correctamente');

                  // Valacion de Foto
                  if($nombre_foto != ''){
                    uploadImage($foto,$imgPortada);
                  }

                }else{
                  $arrResponse = array('status'=>true, 'msg'=> 'Datos Actualizados Correctamente');
                }
    
              }else if($request_categoria == 'exist'){
    
                $arrResponse = array('status' => false, 'msg' => '¡Atencion! La Categoria  Ya existe');
              }else{
    
                $arrResponse = array("status" => false, 'msg' => 'No es posible almacenar los datos');
              }
          }
          echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
      }
          die();

    }

  

  }
?>