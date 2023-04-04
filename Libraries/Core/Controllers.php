<?php

    class Controllers{

        public function __construct(){

            // Poder invocar la vista por un instancia 
            $this->views = new Views();

            // invokar en construtor  para ejecutar el metodo del modelo
            $this->loadModel();


        }


        // Metodo para Cargar los Modelos
        public function loadModel(){

            // HomeModel.php
            $model = get_class($this)."Model";
            // Variable en ruta en modelos
            $routClass = "Models/".$model.".php";

            if(file_exists($routClass)){

                require_once($routClass);
                // instancia hacia la clase models
                $this->model = new $model;
            }
        }
    }

?>