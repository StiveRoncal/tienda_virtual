<?php

    require_once("Libraries/Core/Mysql.php");
    // trait

    trait TProducto{
        private $con;
        // Funcion para seleccionar Productos
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


    }

?>