<?php

    // recuperar informacion de BD de enviar al controlador y luego lo enviamos a la vista
    class RolesModel extends Mysql{

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

        

    }

?>
