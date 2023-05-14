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


  }