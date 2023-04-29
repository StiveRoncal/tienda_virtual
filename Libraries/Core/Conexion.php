<?php
    
    class Conexion{

        private $conect;

        // function de conecion en constructor

        public function __construct(){
            $connectionString = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;

            try {
                $this->conect = new PDO($connectionString, DB_USER,DB_PASSWORD);
                $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // echo "Conexion exitosa Stive";
            } catch (PDOException $e) {
                $this->conect = 'Error de Conexión';
                echo "Error: ".$e->getMessage();
            }
        }

        // funcion de retorno de contructor 
        public function conect(){
            return $this->conect;
        }
    }

?>