<?php

    // cobnvertir primer letra en mayuscula
    $controller = ucwords($controller);
    // LOAD
    // Busque de carpeta con extension .php en el controlador
    $controllerFile = "Controllers/".$controller.".php";
    if(file_exists($controllerFile)){
        
        require_once($controllerFile);
        // instancia para agarar un metodo con una parametro o mas
        $controller = new $controller();

        if(method_exists($controller, $method)){

            $controller->{$method}($params);
        }else{
            // se dirige al error de pagina no encontrada
            require_once("Controllers/Error.php");
        }

    }else{
        // se dirige al error de pagina no encontrada
        require_once("Controllers/Error.php");
    }

?>