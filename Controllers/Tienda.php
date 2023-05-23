<?php


  require_once("Models/TCategoria.php");
  require_once("Models/TProducto.php");

  class Tienda extends Controllers{

    
    use TCategoria, TProducto;

    public function __construct(){
     
    parent::__construct();

    }



    public function tienda(){
        

        $data['page_tag'] = NOMBRE_EMPRESA;
        $data['page_title'] = NOMBRE_EMPRESA;
        $data['page_name'] = "tienda";
       
        $data['productos'] = $this->getProductosT();

        
        $this->views->getView($this,"tienda",$data);
    }


    //#1 Metodo para la categoria

    public function categoria($params){

        // validar si el paremtro esta vacio
        if(empty($params)){
            // redireccionar pagina principal
            header("Location: ".base_url());
        }else{

            $categoria = strClean($params);
            dep($this->getProductosCategoriaT($categoria));
          

            $data['page_tag'] = $categoria;
            $data['page_title'] = $categoria;
            $data['page_name'] = "categoria";
            // $data['productos'] = $this->getProductosT();
            $this->views->getView($this,"categoria",$data);
        }

    }


  

  }
?>