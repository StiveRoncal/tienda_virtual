<?php

    // Esto Es Un Trait(Tcategoria =>Trait Categoria )

    require_once("Libraries/Core/Mysql.php");

    trait Tcategoria{

        // conexion
        public $con;

        // #1 Metodo para Extaer Las Categorias

        public function getCategoriasT(string $categorias){

            // variable con instacion al clase Mysql a un objeto
            $this->con = new Mysql();

            // Consulta pra extraer todo los datos de categoria, que esten Activo y idcategoria extrae las categorias que queramos extrear no todo
            // Si las que queremos con El idcategoria in (1,2,3)= lo que queramos dependiendo al parametro
            $sql = "SELECT idcategoria, nombre, descripcion, portada
                    FROM categoria 
                    WHERE status != 0 AND idcategoria IN ($categorias) ";

            // alamcena  una funcion de la clase mysql
            $request = $this->con->select_all($sql);

            // Valida el numero de Extracion de datos, si es mas de 0 signifca que hay registros
            if(count($request) > 0){

                // Recorremos todos los registro de la base de datos de categorias
                for($stive = 0; $stive < count($request) ; $stive++){

                    // for que alamcena una url d ela imagen con el nombre de la portada
                    $request[$stive]['portada'] = BASE_URL.'/Assets/images/uploads'.$request[$stive]['portada'];

                }

            }

            return $request;

        }



    }

?>