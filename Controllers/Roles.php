<?php


    // Heredacion
  class Roles extends Controllers{

    public function __construct(){
        // Ejecucion de dos metodos por su herencia y constructor de libnrtaties controllers
    parent::__construct();

    }

    // 1er Metodo

    public function Roles(){
        // arreglo de un parametro $data
        $data['page_id'] = 3;
        $data['page_tag'] = "Roles Usuarios";
        $data['page_name'] = "rol_usuario"; 
        $data['page_title'] = "Roles Usuario <small>Tienda Virtual</small>";
 

        // invocar la vista su metodo libraries/Core/Views.php
        $this->views->getView($this,"roles",$data);
    }

    // 2do Metodo Obtener Roles
    public function getRoles(){

      $arrData = $this->model->selectRoles();

      // Condicional de contar arregloo y validar si son 1 o 0 i
      for($i=0; $i < count($arrData); $i++){

        // Condicional 1 si es activo el status
        if($arrData[$i]['status'] == 1){
          // Guardamos el valor en un html como boton 
            $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
        }else{

            $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
        }

        // Valor de variables para poner los botones de las acciones no se puede en el mismo html de roles 
        $arrData[$i]['options'] = '<div class="text-center">
        <button class="btn btn-secondary btn-sm btnPermisosRol" rl="'.$arrData[$i]['idrol'].'" title="Permisos"><i class="fas fa-key"></i></button>
        <button class="btn btn-primary btn-sm btnEditRol" rl="'.$arrData[$i]['idrol'].'" title="Editar"><i class="fas fa-pencil-alt"></i></button>
        <button class="btn btn-danger btn-sm btnDelRol" rl="'.$arrData[$i]['idrol'].'" title="Eliminar"><i class="far fa-trash-alt"></i></button>
        </div>';
      }
      // json_encode: devuele los datos de variables en formato json
      // JSON_UNESCAPED_UNICODE: evita caracteres especiales
      echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
      die();
    }

    public function setRol(){
      // dep($_POST);
      // almacenar datos guardano la varaibles del los campos
      $strRol = strClean($_POST['txtNombre']);
      $strDescripcion = strClean($_POST['txtDescripcion']);
      $intStatus = intval($_POST['listStatus']);
      $request_rol = $this->model->insertRol($strRol,$strDescripcion,$intStatus);

      // condicial lo de insertol
      // Si se inserto el registreo 
      if($request_rol > 0){

        $arrResponse = array('status'=>true, 'msg' => 'Datos Guardados Correctamente.');

      }else if($request_rol == 'exist'){

        $arrResponse = array('status' => false, 'msg' => '¡Atencion! El Rol Ya existe');
      }else{

        $arrResponse = array("status" => false, 'msg' => 'No es posible almacenar los datos');
      }
      
      echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
      die();

    }
    

  }
?>