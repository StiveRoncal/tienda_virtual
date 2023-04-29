<?php

    // Variables globales
    // define("BASE_URL" , "http://localhost/tienda_virtual/");
    const BASE_URL = "http://localhost:81/tienda_virtual";
    


    // Zona Horaria Peru
    date_default_timezone_set('America/Lima');

    // variables globales para conectarmos a la BD
    const DB_HOST="localhost";
    const DB_NAME="db_tiendavirtual";
    const DB_USER="root";
    const DB_PASSWORD = ""; 
    const DB_CHARSET = "utf8";

    // Delimitador decimal y millar ej. 24,50.00
    const SPD = ".";
    const SPM = ',';
?>