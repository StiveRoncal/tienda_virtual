<?php

    // recuperar informacion de BD de enviar al controlador y luego lo enviamos a la vista
    class RolesModel extends Mysql{

        // agregacion de propiedades
        public $intIdrol;
        public $strRol;
        public $strDescripcion;
        public $intStatus;

        public function __construct(){

            // echo "Mensaje desde el modelo Home";
            parent::__construct();
        }

        // 1ra funcion para selecionar roles varios roles
        public function selectRoles(){

            // extraer los roles
            $sql = "SELECT * FROM rol WHERE status != 0";
            $request = $this->select_all($sql);
            return $request;
        }

        // 2da Funcion para insertar datos
        public function insertRol(string $rol, string $descripcion, int $status){
            
            $return ="";
            $this->strRol = $rol;
            $this->strDescripcion = $descripcion;
            $this->intStatus = $status;

            // consulta sql
            $sql = "SELECT * FROM rol WHERE nombrerol = '{$this->strRol}'";

            $request = $this->select_all($sql);

            // si esta vacio esto ejecuta la el request para insertar el rol
            if(empty($request)){

                $query_insert = "INSERT INTO rol(nombrerol,descripcion,status) VALUES(?,?,?)";
                $arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;
            }else{

                $return = "exist";
            }

            return $return;


        }
        

    }

?>
