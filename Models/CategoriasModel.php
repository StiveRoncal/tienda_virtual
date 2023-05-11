<?php

    
    class CategoriasModel extends Mysql{
     
        public $intIdCategoria;
        public $strCategoria;
        public $intDescripcion;
        public $intStatus;
        public $strPortada;    


        public function __construct(){

            
            parent::__construct();
        }


        #1 Funcion para Insertar Registro en Categoria solo son SQL 
        public function insertCategoria(string $nombre, string $descripcion, string $portada ,int $status){
            
            $return = 0;
            $this->strCategoria = $nombre;
            $this->strDescripcion = $descripcion;
            $this->strPortada = $portada;
            $this->intStatus = $status;

            // consulta sql
            $sql = "SELECT * FROM categoria WHERE nombre = '{$this->strCategoria}'";

            $request = $this->select_all($sql);

            // si esta vacio esto ejecuta la el request para insertar el rol
            if(empty($request)){

                $query_insert = "INSERT INTO categoria(nombre,descripcion,portada,status) VALUES(?,?,?,?)";
                $arrData = array($this->strCategoria,
                                 $this->strDescripcion,
                                 $this->strPortada,
                                $this->intStatus);

                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;
                
            }else{

                $return = "exist";
            }

            return $return;


        }

      

    }

?>
