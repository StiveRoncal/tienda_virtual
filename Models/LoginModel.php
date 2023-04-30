<?php

    class LoginModel extends Mysql{

        // Propiedades
        private $intIdUsuario;
        private $strUsuario;
        private $strPassword;
        private $strToken;


        public function __construct(){

            parent::__construct();

        }


        //#1 Metodo para
        public function loginUser(string $usuario, string $password){

            $this->strUsuario = $usuario;
            $this->strPassword = $password;

            // Consulta donde valida que los datos sean iguales al de la base de datos y sea d
            $sql = "SELECT idpersona, status FROM persona WHERE
                    email_user = '$this->strUsuario' and
                    password = '$this->strPassword' and
                    status != 0";
            
            $request = $this->select($sql);
            return $request;

        }


        

    }

?>
