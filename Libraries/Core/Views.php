<?php

    // Clase sin Constructor
    class views{
        // Envio de otro parametro que contiene array $data
        function getView($controller,$view,$data=""){
            // variable que almacena una clase
            $controller = get_class($controller);
            // Condicional para redirigir vista principal
            if($controller == "Home"){
                $view =  "Views/".$view.".php";
            }else{
                $view = "Views/".$controller."/".$view.".php";
            }
            
            require_once($view);
        }
    }

?>