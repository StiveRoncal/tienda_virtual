<?php


    // Heredacion
  class Permisos extends Controllers{

    public function __construct(){
        // Ejecucion de dos metodos por su herencia y constructor de libnrtaties controllers
    parent::__construct();

    }

    #1 Funcion para obtener permisos
    public function getPermisosRol(int $idrol){

        // Variable idenpendiente
        $rolid = intval($idrol);

        // Condicional si trae un ID valido
        if($rolid > 0){
            
            // Arreglo de modulos 
            $arrModulos = $this->model->selectModulos();
            // Arreglo de Permisos
            $arrPermisosRol = $this->model->selectPermisosRol($rolid);

            // Creamos Arreglos para los permisos contiene las 4 operaciones
            $arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);

            // Arrelgo permiso rol por id con varaible  local
            $arrPermisoRol = array('idrol' => $rolid);

            // validacion de condicional si esta vacio el arreglo
            if(empty($arrPermisosRol)){

              // for que ve la cantidad que tiene el arreglo de modulos y va aumentado 
              for($i=0; $i < count($arrModulos) ; $i++){

                // anadir item permisos
                $arrModulos[$i]['permisos'] = $arrPermisos;

              }
            }else{
              // Si tiene asignado algunos permisos
              for($i=0; $i< count($arrModulos); $i++){
                // Modificar el array de cada item con la funcion de selecionar roles recorriendo el ciclo
                   
                // poner en false los valores que no se asginaron nada
                   $arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
                // si existe el modulo en la tabla de los permiso, con algun permiso asignado
                if(isset($arrPermisosRol[$i])){
               
                // asignar valor en arreglo deacurdo a lapsociion
                $arrPermisos = array('r' => $arrPermisosRol[$i]['r'],
                                     'w' => $arrPermisosRol[$i]['w'],
                                     'u' => $arrPermisosRol[$i]['u'],
                                     'd' => $arrPermisosRol[$i]['d']
                                    );
                }
                 // asigan y setear el array principal de esta y los valores de permisos
                 $arrModulos[$i]['permisos'] = $arrPermisos;
              }
            }

            $arrPermisoRol['modulos'] = $arrModulos;
            // dep($arrPermisoRol);
            // guardar un funcion 
            $html = getModal("modalPermisos",$arrPermisoRol);

        }
        die();
    }


    #2 Funcion para guardar los permisos
    public function setPermisos(){

      // dep($_POST);
      // die();

      // Validar si enviamos informacion
      if($_POST){

        // guardar variable idrol de asignacion de permisos
        $intIdrol = intval($_POST['idrol']);
        // referencia al arreglo del sub arreglo
        $modulos = $_POST['modulos'];

        // referencia al metodo  del modelo cono parameto de la varaible que tenemos
        $this->model->deletePermisos($intIdrol);

        foreach($modulos as $modulo){
          // recore todos los elementos de los arreglos de los sub arreglos
          $idModulo = $modulo['idmodulo'];
          // condicionales 0 y 1 si son enviados indicandolo los acceso
          $r = empty($modulo['r']) ? 0 : 1;
          $w = empty($modulo['w']) ? 0 : 1;
          $u = empty($modulo['u']) ? 0 : 1;
          $d = empty($modulo['d']) ? 0 : 1; 

          // Metodo del modelo para insertar enviando valores de los parametros
          $requestPermisos = $this->model->insertPermisos($intIdrol, $idModulo, $r , $w, $u, $d);
        }

        // Si hay registro es mayor a 0
        if($requestPermisos > 0){

          $arrResponse = array('status'=> true, 'msg' => 'Permisos Asignados Correctamente.');
        }else{

          $arrResponse = array("status" => false, "msg" => 'No es Posible Asignar los Permisos');
        }
        // arreglo en formato json
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
      }
      die();
    }
  

  }
?>