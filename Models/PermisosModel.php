<?php

    // recuperar informacion de BD de enviar al controlador y luego lo enviamos a la vista
    class PermisosModel extends Mysql{

        // Propiedades Basicas
        public $intIdPermiso;
        public $intRolid;
        public $r;
        public $w;
        public $u;
        public $d;

        public function __construct(){

            // echo "Mensaje desde el modelo Home";
            parent::__construct();
        }
    
    #1 Metodo para seleccionar Modulos 
    public function selectModulos(){

        // Selecciona todas las varaibles que sean 1 y no cuenta lo que estan desactivados
        $sql = "SELECT * FROM modulo WHERE status != 0";
        $request = $this->select_all($sql);
        return $request;
        
    }

    #2 Metodo para Seleccionar Permisos
    public function selectPermisosRol(int $idrol){

        $this->intRolid = $idrol;
        $sql = "SELECT * FROM permisos WHERE rolid = $this->intRolid";
        $request = $this->select_all($sql);
        return $request;
    }

      

    }

?>
