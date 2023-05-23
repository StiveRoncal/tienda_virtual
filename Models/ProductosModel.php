<?php

  
    class ProductosModel extends Mysql{

        // Propiedad Necesarias
        private $intIdProducto;
        private $strNombre;
        private $strDescripcion;
        private $intCodigo;
        private $intCategoriaId;
        private $intStock;
        private $intStatus;
        private $strPrecio;
        private $strImagen;

        public function __construct(){

            parent::__construct();
        }


        // 1er Metodo para selecionar los productos

        public function selectProductos(){
            // Selecciona los Producto con el la tabla categoria
            $sql = "SELECT p.idproducto,
                        p.codigo,
                        p.nombre,
                        p.descripcion,
                        p.categoriaid,
                        c.nombre as categoria,
                        p.precio,
                        p.stock,
                        p.status
                    FROM producto p
                    INNER JOIN categoria c
                    ON p.categoriaid = c.idcategoria
                    WHERE p.status != 0";

            $request = $this->select_all($sql);

            return $request;
        }


        // 2do Metod para insertar Producto

        public function insertProducto(string $nombre, string $descripcion, int $codigo, int $categoriaid, string $precio, int $stock, int $status){

            $this->strNombre = $nombre;
            $this->strDescripcion = $descripcion;
            $this->intCodigo = $codigo;
            $this->intCategoriaId = $categoriaid;
            $this->strPrecio = $precio;
            $this->intStock = $stock;
            $this->intStatus = $status;

            $return = 0;

            $sql = "SELECT * FROM producto WHERE codigo = '{$this->intCodigo}' ";

            $request = $this->select_all($sql);

            if(empty($request)){

                $query_insert = "INSERT INTO producto(categoriaid,
                                                        codigo,
                                                        nombre,
                                                        descripcion,
                                                        precio,
                                                        stock,
                                                        status)
                                                VALUES(?,?,?,?,?,?,?)";

                $arrData = array($this->intCategoriaId,
                                $this->intCodigo,
                                $this->strNombre,
                                $this->strDescripcion,
                                $this->strPrecio,
                                $this->intStock,
                                $this->intStatus);
                
                $request_insert = $this->insert($query_insert, $arrData);

                $return = $request_insert;
            }else{

                $return = false;

            }

            return $return;




        }


        // 2.1 Metodo para actualizar el producto
        public function updateProducto(int $idproducto,string $nombre, string $descripcion, int $codigo, int $categoriaid, string $precio, int $stock, int $status){

            $this->intIdProducto = $idproducto;
            $this->strNombre = $nombre;
            $this->strDescripcion = $descripcion;
            $this->intCodigo = $codigo;
            $this->intCategoriaId = $categoriaid;
            $this->strPrecio = $precio;
            $this->intStock = $stock;
            $this->intStatus = $status;

            $return = 0;

            $sql = "SELECT * FROM producto WHERE codigo = '{ $this->intCodigo}' AND idproducto !=  $this->intIdProducto";

            $request = $this->select_all($sql);

            if(empty($request)){

                $sql = "UPDATE producto
                        SET categoriaid=?,
                            codigo=?,
                            nombre=?,
                            descripcion=?,
                            precio=?,
                            stock=?,
                            status=?
                            WHERE idproducto = $this->intIdProducto";

                $arrData = array($this->intCategoriaId,
                                $this->intCodigo,
                                $this->strNombre,
                                $this->strDescripcion,
                                $this->strPrecio,
                                $this->intStock,
                                $this->intStatus);
                
                $request = $this->update($sql, $arrData);

                $return = $request;
            }else{

                $return = "exist";

            }

            return $return;




        }

        // 3er Metodo para insertar imagen 
        public function insertImage(int $idproducto, string $imagen){


            $this->intIdProducto = $idproducto;
            $this->strImagen = $imagen;

            $query_insert = "INSERT INTO imagen(productoid,img) 
                            VALUES(?,?)";
            
            $arrData = array($this->intIdProducto,
                            $this->strImagen);

            $request_insert = $this->insert($query_insert,$arrData);

            return $request_insert;
        }
     

        // 4to Metodo para ver en DB un producto
        public function selectProducto(int $idproducto){

            $this->intIdProducto = $idproducto;

            $sql = "SELECT p.idproducto,
                            p.codigo,
                            p.nombre,
                            p.descripcion,
                            p.precio,
                            p.stock,
                            p.categoriaid,
                            c.nombre as categoria,
                            p.status
                    FROM producto p
                    INNER JOIN categoria c
                    ON p.categoriaid = c.idcategoria
                    WHERE idproducto = $this->intIdProducto";

            $request = $this->select($sql);
            return $request;
        }


        // 5to Metodo para selecionar imagenes

        public function selectImages(int $idproducto){

            $this->intIdProducto = $idproducto;

            $sql = "SELECT productoid, img
                    FROM imagen
                    WHERE productoid = $this->intIdProducto";

            $request = $this->select_all($sql);
            return $request;

        }

        // 6to Metodo para Eliminar img

        public function deleteImage(int $idproducto, string $imagen){

            $this->intIdProducto = $idproducto;

            $this->strImagen = $imagen;

            // consulta para eliminar la img directamente
            $query = "DELETE FROM imagen 
                    WHERE productoid = $this->intIdProducto
                    AND img = '{$this->strImagen}'";

            $request_delete = $this->delete($query);

            return $request_delete;

        }


        // 7Mo Eliminar Producto 

        public function deleteProducto(int $idproducto){

            $this->intIdProducto = $idproducto;

            $sql = "UPDATE producto SET status = ? WHERE idproducto = $this->intIdProducto";
            // referencia al ID del arreglo
            $arrData = array(0);
            // almacena funcion de mysql.php
            $request = $this->update($sql,$arrData);

            return $request;
        }
    }

?>
