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
            $whereAdmin = "";   
            // Si la session no es el admin master
            if($_SESSION['idUser'] != 1){

                $whereAdmin =  " and idrol != 1";
            }
            // extraer los roles
            $sql = "SELECT * FROM rol WHERE status != 0".$whereAdmin;
            $request = $this->select_all($sql);
            return $request;
        }

        // 3ra funcion   para selecionar un rol sirve para caputrar solo un id y editar ese id
        public function selectRol(int $idrol){
            // Buscar rol por id
            $this->intIdrol = $idrol;
            // instrucion sql para selcionar unsolo rol
            $sql = "SELECT * FROM rol WHERE idrol = $this->intIdrol";
            $request = $this->select($sql);
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

        #4 Metodo para Actualizar los roles
        public function updateRol(int $idrol, string $rol, string $descripcion, int $status){

            $this->intIdrol = $idrol;
            $this->strRol = $rol;
            $this->strDescripcion = $descripcion;
            $this->intStatus = $status;

            // Consulta SQL
            $sql = "SELECT * FROM rol WHERE nombrerol = '$this->strRol' AND idrol != $this->intIdrol";
            $request = $this->select_all($sql);


            // Condicional Si esta vacio si no cumple la condicion esta actualiza
            if(empty($request)){

                $sql = "UPDATE rol SET nombrerol = ?, descripcion = ?, status = ? WHERE idrol = $this->intIdrol ";
                $arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
                $request = $this->update($sql, $arrData);
            }else{

                $request = "exist";
            }

            return $request;
        }

        // #5 Metodo para Eliminar Rol
        public function deleteRol(int $idrol){

            // invocar varaible publica y asignar con parametro
            $this->intIdrol = $idrol;
            // consulta para selecionar tabla persona si encuentra idrol igual al id enviado
            $sql = "SELECT * FROM persona WHERE rolid = $this->intIdrol";
            // variable que executa una funcion heredad por mysql.php
            $request = $this->select_all($sql);


            // Condicional si esta vacio no hay tabla persona relacionado con el

            if(empty($request)){
                // Realiza el proceso para actualizar los valores de un estado 1 a 0
                $sql = "UPDATE rol SET status = ? WHERE idrol = $this->intIdrol ";
                // Setea el valor 0
                $arrData = array(0);
                // ejecuta funcion de mysql.php
                $request = $this->update($sql,$arrData);

                // Si se cumplio manda ol
                if($request){

                    $request = 'ok';
                }else{

                    $request = 'error';
                }
            }else{

                $request = 'exist';
            }
            
            return $request;
        }
        

    }

?>
