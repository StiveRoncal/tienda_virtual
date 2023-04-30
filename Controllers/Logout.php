<?php

    class Logout{

        public function __construct(){

            // inicialiciando session
            session_start();
            //limpiar todoas la variable de seesion  
            session_unset();
            // desctruir session todos
            session_destroy();
            //redireccionar ruta del login
            header('Location: '.base_url().'/login');
        }

    }

?>