<?php

    require_once("Libraries/Core/Mysql.php");
    // trait

    trait TProducto{

        private $con;
        private $strCategoria;
        private $intIdCategoria;






        // #1 Funcion para seleccionar Productos
        public function getProductosT(){

            $this->con = new Mysql();
            // Selecciona los Producto con el la tabla categoria
            $sql = "SELECT p.idproducto,
                        p.codigo,
                        p.nombre,
                        p.descripcion,
                        p.categoriaid,
                        c.nombre as categoria,
                        p.precio,
                        p.stock
                    FROM producto p
                    INNER JOIN categoria c
                    ON p.categoriaid = c.idcategoria
                    WHERE p.status != 0";

            $request = $this->con->select_all($sql);

                // Validacion si hay registro
                if(count($request) > 0){

                    for($c = 0; $c < count($request); $c++){

                        // alamcena id y recore cada uno de eelos
                        $intIdProducto = $request[$c]['idproducto'];

                        $sqlImg = "SELECT img
                                FROM imagen
                                WHERE productoid = $intIdProducto";

                        $arrImg = $this->con->select_all($sqlImg);

                        // Vadidar Si encontra una imagen del prodcutp
                        if(count($arrImg) > 0){

                            for($i=0; $i < count($arrImg); $i++){

                                // varaibel de arreglo que alamcena una ruta de imagen
                                $arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
                            }
                        }

                        $request[$c]['images'] = $arrImg;
                    }


                }

            return $request;
        }




        // #2 funcion para dar categoria en tienda y sacar id y nombre de la categoria
        // http://localhost:81/tienda_virtual/tienda/categoria/Laptop ==> eso
        public function getProductosCategoriaT(string $categoria){

            $this->strCategoria = $categoria;

            $this->con = new Mysql();
            
            // consulta para categoria
            $sql_cat = "SELECT idcategoria FROM categoria WHERE nombre = '{$this->strCategoria}' ";
            $request = $this->con->select($sql_cat);

            // Validar si se encontro el registro, si Existe el Registro
            if(!empty($request)){

                $this->intIdCategoria = $request['idcategoria'];

                // selecion todos los prodc¿uctos donde esta activo y tenga id
                $sql = "SELECT p.idproducto,
                        p.codigo,
                        p.nombre,
                        p.descripcion,
                        p.categoriaid,
                        c.nombre as categoria,
                        p.precio,
                        p.stock
                    FROM producto p
                    INNER JOIN categoria c
                    ON p.categoriaid = c.idcategoria
                    WHERE p.status != 0 AND p.categoriaid = $this->intIdCategoria ";

                $request = $this->con->select_all($sql);

                // Validacion si hay registro
                    if(count($request) > 0){

                        for($c = 0; $c < count($request); $c++){

                        // alamcena id y recore cada uno de eelos
                         $intIdProducto = $request[$c]['idproducto'];

                            $sqlImg = "SELECT img
                                FROM imagen
                                WHERE productoid = $intIdProducto";

                         $arrImg = $this->con->select_all($sqlImg);

                        // Vadidar Si encontra una imagen del prodcutp
                            if(count($arrImg) > 0){

                                for($i=0; $i < count($arrImg); $i++){

                                // varaibel de arreglo que alamcena una ruta de imagen
                                $arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
                                }
                            }

                            $request[$c]['images'] = $arrImg;
                    }


                }


            }
            return $request;
        }



    }

?>