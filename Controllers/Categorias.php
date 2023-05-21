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
        // dep($_POST);

        // dep($_FILES);exit;

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
              $imgPortada   = 'portada_categoria.png';

              $request_categoria = "";

              $fecha        = date('ymd');
              $hora         = date('Hms');
              

              // Validacion de img si entra img vacio o no vacia

              // Se esta enviando un img 
              if($nombre_foto != ''){

                $imgPortada = 'img_'.md5(date('d-m-Y H:m:s')).'.jpg';

              }


              // VALIDACION SI se va CREAR O ACTUALIZAR

              if($intIdCategoria == 0){
          
                // Crear
                if($_SESSION['permisosMod']['w']){
                    $request_categoria = $this->model->insertCategoria($strCategoria,$strDescripcion,$imgPortada,$intStatus);
                    $option = 1;
                }
              }else{
    
                // Actualizar se envia ID
                if($_SESSION['permisosMod']['u']){
                    // Condicion para img si esta esta vacio o no para redireicir ruta
                    if($nombre_foto == ''){

                        if($_POST['foto_actual'] != 'portada_categoria.png' && $_POST['foto_remove'] == 0){

                          // toma foto actual no se actualiza
                            $imgPortada = $_POST['foto_actual']; 
                          
                        }
                    }

                    $request_categoria = $this->model->updateCategoria($intIdCategoria,$strCategoria,$strDescripcion,$imgPortada,$intStatus);
                    $option = 2;
                }

              }


              if($request_categoria > 0){

                // Opcion si es 1 crear si es 2 se actualizo
                if($option == 1){
    
                  $arrResponse = array('status'=>true, 'msg'=> 'Datos Guardados Correctamente');

                  // Valacion de Foto
                  if($nombre_foto != ''){uploadImage($foto,$imgPortada);}

                }else{

                  $arrResponse = array('status'=>true, 'msg'=> 'Datos Actualizados Correctamente');
                   // Valacion de Foto
                   if($nombre_foto != ''){uploadImage($foto,$imgPortada);}

                  // Validacion para eliminar foto actual con otro si se cambia
                  // es vacio
                  if( ($nombre_foto == '' && $_POST['foto_remove'] == 1 && $_POST['foto_actual'] != 'portada_categoria.png') 
                    || ($nombre_foto != '' && $_POST['foto_actual'] != 'portada_categoria.png') ){

                      deleteFile($_POST['foto_actual']);
                  }
                }
    
              }else if($request_categoria == false){
    
                $arrResponse = array('status' => false, 'msg' => '¡Atencion! La Categoria  Ya existe');
              }else{
    
                $arrResponse = array("status" => false, 'msg' => 'No es posible almacenar los datos');
              }
          }
          echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
      }
          die();

    }




    // Extraer las Categorias 
    public function getCategorias(){

      // Validacion para que no accesar roles secundarios sin permisos de root
      if($_SESSION['permisosMod']['r']){

     
          $arrData = $this->model->selectCategorias();
            

          for($i=0; $i < count($arrData); $i++){

            // Varaibles para Sessiones de permisos
            $btnView = '';
            $btnEdit = '';
            $bntDelete = '';
            

            // Validar el Status para que se ve en Forma de Texto

            if($arrData[$i]['status'] == 1){

                $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';

            }else{

              $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';

            }


            // BOTON 01 Permisos (r=>read)(LEER) Boton Ojito
            if($_SESSION['permisosMod']['r']){

              $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['idcategoria'].')" title="Ver Categoria"><i class="far fa-eye"></i></button>';
            }

            // BOTON 02 Permisos (u=>update)(ACTUALIZAR) Boton Lapiz
            if($_SESSION['permisosMod']['u']){

                $btnEdit = '<button class="btn btn-primary btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['idcategoria'].')" title="Editar Categoria"><i class="fas fa-pencil-alt"></i></button>';
      
            }

            // BOTON 03 Permisos (d=>delte)(ELIMINAR) Boton tacho de basura
            if($_SESSION['permisosMod']['d']){
              
                $bntDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idcategoria'].')" title="Eliminar Categoria"><i class="far fa-trash-alt"></i></button>';

            }

          //  Concadenamiento de varaibles para mostras botones de acciones
            $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$bntDelete.' </div>';
          }
          
          echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
    }
      die();

    }


    // Metod para Extraer las categorias
    public function getCategoria($idcategoria){

        if($_SESSION['permisosMod']['r']){
          $intIdCategoria = intval($idcategoria);
  
            // condicional si el datos tiene un id validos realizo procesos
            if($intIdCategoria > 0){
  
                  $arrData = $this->model->selectCategoria($intIdCategoria);
               
                  // Si no encontro o esta vacia manda errror
                  // Basicamente hace si detecta el id Existe lo corre si no manda mensahe de error
                  if(empty($arrData)){
  
                    $arrResponse = array('status' => false, 'msg' => 'Datos No Encontrados.');
                  }else{
                    // Variable que alamcena la ruta de Foto
                    $arrData['url_portada'] = media().'/images/uploads/'.$arrData['portada'];
                    $arrResponse = array('status'=> true, 'data' => $arrData);
                  }
                  
                  // dep($arrData);exit;

                  // Retorna en Formato Json no Arreglo
                  echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
  
              }
        }
  
      die();
  
    }


    // Metodo para Eliminar la Categoria
    public function delCategoria(){
      
      // si se envio
      if($_POST){
        if($_SESSION['permisosMod']['d']){
            // varaiblke que guarda el  el idrol
            $intIdCategoria = intval($_POST['idCategoria']);

            // ejecuta un proceso desde el modelo para eliminar
            $requestDelete = $this->model->deleteCategoria($intIdCategoria);

            // Si mi respuesta es OK
            if($requestDelete == 'ok'){

              // Ejecuta el mensaje del proceso
              $arrResponse = array('status' => true, 'msg' => 'Se Ha Eliminado La Categoria');
            // de lo contraio manda error
            }else if($requestDelete == false){

              $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un Categoria con productos asociado ');
            }else{

              $arrResponse = array('status' => false, 'msg' => 'Error Al Eliminar categoria');
            }
            // varaible guardado en json evitando caracteres especiales

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          }
        }
          // De lo contrario muere
          die();

  } 
  

    // Lista despegable
    public function getSelectCategorias(){

      $htmlOptions = "";
      // usa funcion de modelo y lo guarda en variable de sql
      $arrData = $this->model->selectCategorias();

      // valida si devuel algo el metodo del modelo
      // si recibe algo
      if(count($arrData) > 0){

          // realizar un form para mostra las opciones de lista desplegable de categoria
          // recorre la cantidad de elemento que tenga
          for($i=0; $i < count($arrData); $i++){

            // valida el estatus 1 para que no muestre las inactivas
            if($arrData[$i]['status'] == 1){

              // variable que imprime un html con id y nombre de la categoria
              $htmlOptions .= '<option value="'.$arrData[$i]['idcategoria'].'" >'.$arrData[$i]['nombre'].'</option>';
            }
          }
      }
      // Solo devuelve html no json
      echo $htmlOptions;
      die();
    }
  

  }
?>