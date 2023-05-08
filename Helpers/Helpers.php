<?php


    // Retorna la url del proyecto
    function base_url(){

        return BASE_URL;
    }
    


    // retornar los js y css
    function media(){

        return BASE_URL."/Assets";
    }


    // funcion para retornar el header_admin y footer_admin
    function headerAdmin($data=""){

        $view_header = "Views/Template/header_admin.php";
        require_once ($view_header);
    } 

    function footerAdmin($data = ""){
        $view_footer = "Views/Template/footer_admin.php";
        require_once ($view_footer);
    }

    // Nueva informacion formateada
    function dep($data){

        $format = print_r('<pre>');
        $format .= print_r($data);
        $format .= print_r('</pre>');

        return $format;
    }

    // Retornar modales a nivel global de una solo carpeta, se usa cada vex que se quiera mostrar un modal
    function getModal(string $nameModal, $data){
        // retorna direccion de eso y usa las extension.php para reconocer
        $view_modal = "Views/Template/Modals/{$nameModal}.php";
        require_once $view_modal;
    }


    //Envio por correos
    function sendEmail($data,$template){

        $asunto = $data['asunto'];
        $emailDestino = $data['email'];
        $empresa = NOMBRE_REMITENTE;
        $remitente = EMAIL_REMITENTE;

        // ENVIO DE CORREO

        // encabezado para enviar correctametn y que caiga en span, /(r)retorno (n)salto
        $de = "MIME-Version: 1.0\r\n";
        $de .= "Content-type: text/html; charset=UTF-8\r\n";
        $de .= "From: {$empresa} <{$remitente}>\r\n";

        // cargar menoria una archvio 
        ob_start();
        // el archivo que carga
        require_once("Views/Template/Email/".$template.".php");
        // obtiene archivo para ser uso de datos, que devuel el archivo cargado
        $mensaje =ob_get_clean();
        // mail=funcion de envios de correos con scireto parametros
        
        $send = mail($emailDestino, $asunto, $mensaje, $de);

        return $send;
    }

    // 
    function getPermisos(int $idmodulo){
        // archivo espeficico
        require_once("Models/PermisosModel.php");
        // instancia de todo la clase a un objeto
        $objPermisos = new PermisosModel();


        // obtner el id del rol deacurdo con lo que estamos logeado
        $idrol = $_SESSION['userData']['idrol'];

        $arrPermisos = $objPermisos->permisosModulo($idrol);

        // almacenar todos los permisos del rol
        $permisos = '';
        // alamcanar los permisos de cada modulo
        $permisosMod = '';

        // validad si array viene vacio, si trae registos
        if(count($arrPermisos) > 0){

            $permisos = $arrPermisos;
            // condicional short verificando  si existe en la posicion del arreglo lo que envamos como parametro osea el id
            //lo coloca todo el conjunto de elemento, si en caso no existe lo deja vacio
            $permisosMod = isset($arrPermisos[$idmodulo]) ? $arrPermisos[$idmodulo] : "";
        }
        // Creacion de varaibkes de session para alamcenar esos dos arreglos creados
        $_SESSION['permisos'] = $permisos;
        $_SESSION['permisosMod'] = $permisosMod;
    }


    // Funcion para obtener datos de clase espeficia
    function sessionUser(int $idpersona){
        
        require_once("Models/LoginModel.php");
        // Porque tiene un metodo sessionLogin para extraer todos sus datos

        // Instanciar objrto
        $objLogin = new LoginModel();
        // usa un meto espeficio para extraer sus daots 
        $request = $objLogin->sessionLogin($idpersona);

        return $request;
    }

    // Funcio para tiempo en session limitar
    function sessionStart(){
        session_start();

        $inactive = 360;
        // si existe esa variable de session
        if(isset($_SESSION['timeout'])){

            $session_in = time() - $_SESSION['inicio'];


            // Validacion
            if($session_in > $inactive){

                header("Location: ".BASE_URL."/logout");
            }
        }else{

            header("Location: ".BASE_URL."/logout");

        }
    }

    // Eliminar exceso de espacios entre palabras
    function strClean($strCadena){

        $string = preg_replace(['/\s+/','/^\s|\s$/'],[' ',''], $strCadena);
        $string = trim($string); //Eliminacion de espacio en blanco de inicio y fin
        $string = stripslashes($string);
        $string = str_ireplace("<script>","",$string);
        $string = str_ireplace("</script>","",$string);
        $string = str_ireplace("<script src>","",$string);
        $string = str_ireplace("<script type=>","",$string);
        $string = str_ireplace("SELECT * FROM","",$string);
        $string = str_ireplace("DELETE FROM","",$string);
        $string = str_ireplace("INSERT INTO","",$string);
        $string = str_ireplace("SELECT COUNT(*) FROM","",$string);
        $string = str_ireplace("DROP TABLE","",$string);
        $string = str_ireplace("OR '1'='1","",$string);
        $string = str_ireplace('OR "1"="1"',"",$string);
        $string = str_ireplace('OR ´1´=´1´',"",$string);
        $string = str_ireplace("is NULL; --","",$string);
        $string = str_ireplace("is NULL; --","",$string);
        $string = str_ireplace("LIKE '","",$string);
        $string = str_ireplace('LIKE "',"",$string);
        $string = str_ireplace("LIKE ´","",$string);
        $string = str_ireplace("OR 'a'='a","",$string);
        $string = str_ireplace('OR "a"="a',"",$string);
        $string = str_ireplace("OR ´a´=´a","",$string);
        $string = str_ireplace("OR ´a´=´a","",$string);
        $string = str_ireplace("--","",$string);
        $string = str_ireplace("^","",$string);
        $string = str_ireplace("[","",$string);
        $string = str_ireplace("]","",$string);
        $string = str_ireplace("==","",$string);
        
        return $string;
  
    }

    // OJITO EN EL FUTURO
    // GENERA CONTRASEÑA DE 10 CARACTERES
    function passGenerator($length = 10){

        $pass = "";
        $longitudPass = $length;
        $cadena = "ABCDFGHIJKLMNOPQRSTUVWXYZabcdfghijklmnopqrstuvwxyz1234567890";
        $longitudCadena = strlen($cadena);

        for($i=1; $i<= $longitudPass; $i++){
            $pos = rand(0,$longitudCadena-1);
            $pass .= substr($cadena,$pos,1);
        }

        return $pass;
    }

    // Generacion de token
    function token(){

        $r1 = bin2hex(random_bytes(10));
        $r2 = bin2hex(random_bytes(10));
        $r3 = bin2hex(random_bytes(10));
        $r4 = bin2hex(random_bytes(10));
        $token = $r1.'-'.$r2.'-'.$r3.'-'.$r4;
        return $token;
    }

    // Formato para valores monetarios
    function formatMoney($cantidad){

        $cantidad = number_format($cantidad,2,SPD,SPM);
        return $cantidad;
    }

    // Simbolo de moneda
    const SMONEY = "S/";

?>