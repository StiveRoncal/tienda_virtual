<?php

    // Usando Funciones Existente desde CategoriasModel
    // require_once("CategoriasModel.php");
    
    class HomeModel extends Mysql{

        // Varaible propia 
        private $objCategoria;


        public function __construct(){

           
            parent::__construct();

            // instancio de obj de una clase
            // $this->objCategoria = new CategoriasModel();

        }

    

        // #1 Metodo

        public function getCategorias(){
            
            // retornamso funcion existente de CategoriasModel.php
            // return $this->objCategoria->selectCategorias();

        }
       

    }

?>
