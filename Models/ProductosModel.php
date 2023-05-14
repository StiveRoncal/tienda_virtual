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

     

    }

?>
