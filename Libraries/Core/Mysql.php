<?php
    
    // Heredacion
    class Mysql extends Conexion{

        // variables locales
        private $conexion;
        private $strquery;
        private $arrValues;

        function __construct(){
        // constructo con instancia hacia conexion.php
        $this->conexion = new Conexion();
        // llamado a la funcion  fuera del constructor en conexion.php
        $this->conexion = $this->conexion->conect();
    }

    // funcion de Registro usuario
    public function insert(string $query,array $arrValues){

        $this->strquery = $query;
        $this->arrValues = $arrValues;

        $insert = $this->conexion->prepare($this->strquery);
        $reInsert = $insert->execute($this->arrValues);

        // condicional
        if($reInsert){
            $lastInsert = $this->conexion->lastInsertId();
        }else{
            $lastInsert = 0;
        }

        return $lastInsert;

    }


    // Buscar un solo Registro
    public function select(string $query){
        $this->strquery = $query;
        $result = $this->conexion->prepare($this->strquery);
        $result->execute();
        $data = $result->fetch(PDO::FETCH_ASSOC);
        return $data; 
    }


    // Selecionar o buscar todos los registros
    // public function select_all(string $query){

    //     $this->strquery = $query;
    //     $result = $this->conexion->prepare($this->$strquery);
    //     $result->execute();
    //     $data = $result->fetchall(PDO::FETCH);
    //     return $data;
    // }

    public function select_all(string $query){

        $this->strquery = $query;
        $result = $this->conexion->prepare($this->strquery);
        $result->execute();
        $data = $result->fetchall(PDO::FETCH_ASSOC);
        return $data;
    }

    // Actualizacion de Registro
    public function update(string $query, array $arrValues){
        $this->strquery = $query;
        $this->arrValues = $arrValues;

        $update = $this->conexion->prepare($this->strquery);
        $resExecute = $update->execute($this->arrValues);
        return $resExecute;
    }

    // Eliminar un registro
    public function delete(string $query){
        
        $this->strquery = $query;
        $result = $this->conexion->prepare($this->strquery);
        $del = $result->execute();
        return $del;
    }


    }
?>