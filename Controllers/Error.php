<?php


    // Heredacion
  class Errors extends Controllers{

    public function __construct(){
        // Ejecucion de dos metodos por su herencia y constructor de libnrtaties controllers
    parent::__construct();

 
    }

    public function notFound(){

        $this->views->getView($this,"error");
    }
  }

// Creacion de instancia fuera de la clase
$notFound = new Errors();    
// Ejecutar el metodo de la clase fuera
$notFound->notFound();  
?>