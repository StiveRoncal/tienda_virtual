<?php


  class Productos extends Controllers{

    
    public function __construct(){

  
        sessionStart();
        
        parent::__construct();
        
        if(empty($_SESSION['login'])){

            header('Location:'.base_url().'/login');
            die();
        }

        // En el tabla modulo esta El nro 4 el ID porque alli esta el producto del modulo
        getPermisos(4);

    }


    public function Productos(){

        //validacion si no tiene permisos asignados redireccion 
        if(empty($_SESSION['permisosMod']['r']) ){

          header("Location:".base_url().'/dashboard');

        }

        $data['page_tag'] = "Productos";
        $data['page_title'] = "PRODUCTOS <small>Tienda Virtual</small>";
        $data['page_name'] = "productos";
        $data['page_functions_js'] = "functions_productos.js";
        $this->views->getView($this,"productos",$data);
    }



    // Funcion para Listar Producto HAciendo json
    public function getProductos(){

      // Validacion para que no accesar roles secundarios sin permisos de root
      if($_SESSION['permisosMod']['r']){

     
          $arrData = $this->model->selectProductos();
            

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


            // Codigo de Formato de Moneda PERU(Soles/PEN)
            // Poner al costado como agrego del precio
            
            $arrData[$i]['precio'] = SMONEY.' '.formatMoney($arrData[$i]['precio']);
            

            // BOTON 01 Permisos (r=>read)(LEER) Boton Ojito
            if($_SESSION['permisosMod']['r']){

              $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['idproducto'].')" title="Ver Producto"><i class="far fa-eye"></i></button>';
            }

            // BOTON 02 Permisos (u=>update)(ACTUALIZAR) Boton Lapiz
            if($_SESSION['permisosMod']['u']){

                $btnEdit = '<button class="btn btn-primary btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['idproducto'].')" title="Editar Producto"><i class="fas fa-pencil-alt"></i></button>';
      
            }

            // BOTON 03 Permisos (d=>delte)(ELIMINAR) Boton tacho de basura
            if($_SESSION['permisosMod']['d']){
              
                $bntDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idproducto'].')" title="Eliminar Producto"><i class="far fa-trash-alt"></i></button>';

            }

          //  Concadenamiento de varaibles para mostras botones de acciones
            $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$bntDelete.' </div>';
          }
          
          echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
    }
      die();

    }


    // Funcion para Guardar Producto cuando agregamos
    public function setProducto(){
     

    if($_POST){
       

  
        // Validar -datos Vacios
        if(empty($_POST['txtNombre']) || empty($_POST['txtCodigo'])  || empty($_POST['listCategoria']) 
        || empty($_POST['txtPrecio'])|| empty($_POST['listStatus']) ){

            $arrResponse = array("status" => false, "msg" => 'Datos Incorrectos.');
            
        }else{

            $idProducto = intval($_POST['idProducto']);
            $strNombre = strClean($_POST['txtNombre']);
            $strDescripcion = strClean($_POST['txtDescripcion']);
            $strCodigo = strClean($_POST['txtCodigo']);
            $intCategoriaId = intval($_POST['listCategoria']);
            $strPrecio = strClean($_POST['txtPrecio']);
            $intStock = intval($_POST['txtStock']);
            $intStatus = intval($_POST['listStatus']);

          // Codigo
          // Condicional para Insertar Datos porque no hay ID
          if($idProducto == 0){

            $option = 1;

            $request_producto = $this->model->insertProducto($strNombre,
                                                            $strDescripcion,
                                                            $strCodigo,
                                                            $intCategoriaId,
                                                            $strPrecio,
                                                            $intStock,
                                                            $intStatus);


          }else{

            $option = 2;


          }

          // Validacion de Resultado de Insertar  Un Producto, Si se inserto el producto
          if($request_producto > 0){

              if($option == 1){
                // Agregamos id dde producto con respuesta de un entero
                $arrResponse = array('status' => true, 'idproducto' => $request_producto, 'msg' => 'Datos Guardado correctamente');

              }else{

              }
              // Si existe el codigo de barras
          }else if($request_producto == 'exist'){

              $arrResponse = array('status' => false, 'msg' => '!Atención¡ Ya existe un producto con El Codigo en Barra Ingresado');
          }else{

            $arrResponse = array("status" => false, "msg" => 'No es Posible Almacenar los Datos');
          }
        

            

          


           
        }
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
    }
        die();

    }



    // Funcion para 
    public function setImage(){
      // dep($_POST);
      // dep($_FILES);

      $arrResponse = array('status' => true, 'imgname' => "img_fsdsdfsddsdf.jpg");
      echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
      die();
    }

  }