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
                // asignar valor en arreglo deacurdo a lapsociion
                $arrPermisos = array('r' => $arrPermisosRol[$i]['r'],
                                     'w' => $arrPermisosRol[$i]['w'],
                                     'u' => $arrPermisosRol[$i]['u'],
                                     'd' => $arrPermisosRol[$i]['d']
                                    );
                // Validacion de arreglo si estas son iguales as sus
                if($arrModulos[$i]['idmodulo'] == $arrPermisosRol[$i]['moduloid']){
                  // asigan y setear el array principal de esta y los valores de permisos
                  $arrModulos[$i]['permisos'] = $arrPermisos;
                }
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

      dep($_POST);
      die();
    }
  

  }
?>