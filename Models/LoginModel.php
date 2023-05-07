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

            // de la consulta sql va ser almacena en una variable session

            // Sirve para que el usuario no tenga la necesida de cerrar sesion y entra a session 
            $_SESSION['userData'] = $request;
            return $request;

        }

        // #3 Metodo selecionar email con campos de usuarios pero que su estado este activo, solo permite restarblecer contraseña

        public function getUserEmail(string $strEmail){

            $this->strUsuario = $strEmail;

            $sql = "SELECT idpersona, nombres, apellidos, status
                    FROM persona WHERE email_user = '$this->strUsuario' AND status = 1";

            $request = $this->select($sql);
            return $request;
        }


        // #4 funcion para actualiza el token
        public function setTokenUser(int $idpersona, string $token){

            // correspondecia de propieda
            $this->intIdUsuario = $idpersona;
            $this->strToken = $token;

            // cconsutl apra actualizar 
            $sql = "UPDATE persona SET token = ? WHERE idpersona = $this->intIdUsuario";
            // datos que van hacer actualizados
            $arrData = array($this->strToken);  
            // toma calor retornable
            $request = $this->update($sql,$arrData);
            return $request;
        }


        //#5 funcion consultar que esten los mismo email e token con el estado activo
        public function getUsuario(string $email, string $token){

            $this->strUsuario = $email;
            $this->strToken = $token;

            $sql = "SELECT idpersona FROM persona WHERE
                    email_user = '$this->strUsuario' AND token = '$this->strToken' AND status = 1";

            $request = $this->select($sql);
            return $request;
        }

        //#6 funcion para acutliazr contraseña de formulario de resetar password
        public function insertPassword(int $idPersona, string $password){
            
            $this->intIdUsuario = $idPersona;
            $this->strPassword = $password;

            $sql = "UPDATE persona SET password = ?, token = ? WHERE idpersona = $this->intIdUsuario";

            $arrData = array($this->strPassword,"");
            $request = $this->update($sql,$arrData);

            return $request;


        }   

    }

?>
