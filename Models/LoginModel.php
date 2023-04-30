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


        //#1 Metodo para validar usuario y contraseña
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


        //#2 Metodo para cargar los datos sin cerrar sesion

        public function sessionLogin(int $iduser){

            $this->intIdUsuario = $iduser;

            //Buscar Rol
            $sql = "SELECT p.idpersona,
                            p.identificacion,
                            p.nombres,
                            p.apellidos,
                            p.telefono,
                            p.email_user,
                            p.dni,
                            p.nombrefiscal,
                            p.direccionfiscal,
                            r.idrol, r.nombrerol,
                            p.status
                    FROM persona p
                    INNER JOIN rol r
                    ON p.rolid = r.idrol
                    WHERE p.idpersona = $this->intIdUsuario";

            $request = $this->select($sql);
            return $request;

        }


        

    }

?>
