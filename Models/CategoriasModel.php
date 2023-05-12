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



        #2 Funcion para selecionar las categorias(*)
        public function selectCategorias(){
        
             $sql = "SELECT * FROM categoria 
                    WHERE status != 0";
    
             $request = $this->select_all($sql);
     
             return $request;
        }


        #3 Funcion para Selecionar una Categoria(1)
        public function selectCategoria(int $idcategoria){

            $this->intIdCategoria = $idcategoria;

            $sql = "SELECT * FROM categoria
                    WHERE idcategoria = $this->intIdCategoria";

            $request = $this->select($sql);
            return $request;
        }

        #4 Funcion Para Actuliazar Categoria
        public function updateCategoria(int $idcategoria, string $categoria, string $descripcion, string $portada, int $status){

            $this->intIdCategoria = $idcategoria;
            $this->strCategoria = $categoria;
            $this->strDescripcion = $descripcion;
            $this->strPortada = $portada;
            $this->intStatus = $status;

            // Consulta si exiteste una categoria con el nombre que enviamos y sea difrente al id y no se duplique
            $sql = "SELECT * FROM categoria WHERE nombre = '{$this->strCategoria}' AND idcategoria != $this->intIdCategoria ";

            $request = $this->select_all($sql);

            // Si no existe
            if(empty($request)){


                $sql = "UPDATE categoria SET nombre = ?, descripcion = ?, portada = ?, status = ? WHERE idcategoria = $this->intIdCategoria";

                $arrData = array($this->strCategoria,
                                $this->strDescripcion,
                                $this->strPortada,
                                $this->intStatus 
                            );


                $request = $this->update($sql,$arrData);
            }else{

                $request = "exist";
            }

            return $request;
        }

        
        #5 Funcion Para Eliminar Categoria
        public function deleteCategoria(int $idcategoria){

         
            $this->intIdCategoria = $idcategoria;
          
            $sql = "SELECT * FROM producto WHERE categoriaid = $this->intIdCategoria";
         
            $request = $this->select_all($sql);


            // Condicional si esta vacio no hay tabla persona relacionado con el

            if(empty($request)){
            
                $sql = "UPDATE categoria SET status = ? WHERE idcategoria = $this->intIdCategoria ";
            
                $arrData = array(0);
             
                $request = $this->update($sql,$arrData);

             
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
