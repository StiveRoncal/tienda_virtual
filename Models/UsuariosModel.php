<?php

class UsuariosModel extends Mysql{

    private $intIdUsuario;
    private $strIdentificacion;
    private $strNombre;
    private $strApellido;
    private $intTelefono;
    private $strEmail;
    private $strPassword;
    private $strToken;
    private $intTipoId;
    private $intStatus;
    private $strDni;
    private $strNomFiscal;
    private $strDirFiscal;


    public function __construct(){

        
        parent::__construct();
    }


    public function insertUsuario(string $identificacion,string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid, int $status){


        $this->strIdentificacion = $identificacion;
        $this->strNombre = $nombre;
        $this->strApellido = $apellido;
        $this->intTelefono = $telefono;
        $this->strEmail = $email;
        $this->strPassword = $password;
        $this->intTipoId = $tipoid;
        $this->intStatus = $status;
        $return = 0;

        $sql = "SELECT * FROM persona WHERE email_user = '{$this->strEmail}' or identificacion = '{$this->strIdentificacion}'";

        $request = $this->select_all($sql);


        if(empty($request)){

            $query_insert = "INSERT INTO persona(identificacion,nombres,apellidos,telefono,email_user,password,rolid,status) VALUES(?,?,?,?,?,?,?,?) ";

            $arrData = array(
                $this->strIdentificacion,
                $this->strNombre,
                $this->strApellido,
                $this->intTelefono,
                $this->strEmail,
                $this->strPassword,
                $this->intTipoId,
                $this->intStatus
            );

            $request_insert = $this->insert($query_insert,$arrData);
            $return = $request_insert;
        }else{

            $return = "exist";
        }
        return $return;
    }

    
    #2 Para Seleccionar varios Usuarios
    public function selectUsuarios(){

        // Validacion si La session no esta logeo con el super admin cambia de setencia para que no extariga a su super usuario
        $whereAdmin = "";
        if($_SESSION['idUser'] != 1){

            $whereAdmin = " and p.idpersona != 1";
        }
        $sql = "SELECT p.idpersona,p.identificacion,p.nombres,p.apellidos,p.telefono,p.email_user,p.status,r.idrol,
                        r.nombrerol
                        FROM persona p
                        INNER JOIN rol r
                        ON p.rolid = r.idrol
                        WHERE p.status != 0".$whereAdmin;
        $request = $this->select_all($sql);

        return $request;
    }

    public function selectUsuario(int $idpersona){

        $this->intIdUsuario = $idpersona;

        $sql = "SELECT p.idpersona, p.identificacion, p.nombres, p.apellidos, p.telefono, p.email_user, p.dni, p.nombrefiscal,
                    r.idrol, r.nombrerol, p.status, DATE_FORMAT(p.datecreated, '%d-%m-%Y') as fechaRegistro
                    FROM persona p
                    INNER JOIN rol r
                    ON p.rolid = r.idrol
                    WHERE p.idpersona = $this->intIdUsuario";
        
        $request = $this->select($sql);
        return $request;
    }

    // Actualizar usaurio
    public function updateUsuario(int $idUsuario, string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid, int $status){

        $this->intIdUsuario = $idUsuario;
        $this->strIdentificacion = $identificacion;
        $this->strNombre = $nombre;
        $this->strApellido = $apellido;
        $this->intTelefono = $telefono;
        $this->strEmail = $email;
        $this->strPassword = $password;
        $this->intTipoId = $tipoid;
        $this->intStatus = $status;

        // Validacion si se repite identificaio o meail

        $sql = "SELECT * FROM persona WHERE (email_user = '{$this->strEmail}' AND idpersona != $this->intIdUsuario)
                                        OR (identificacion = '{$this->strIdentificacion}' AND idpersona != $this->intIdUsuario)";

        $request = $this->select_all($sql);

        // condicioanl si esta no existe actualiza
        if(empty($request)){
            
            // condicional si el password no esta vacio actulia 
            if($this->strPassword != ""){

                $sql = "UPDATE persona SET identificacion = ?, nombres = ?, apellidos = ?, telefono = ?, email_user = ?, password = ?,
                        rolid = ?, status = ?  
                        WHERE idpersona = $this->intIdUsuario ";
                
                $arrData = array( $this->strIdentificacion,
                                $this->strNombre,
                                $this->strApellido,
                                $this->intTelefono,
                                $this->strEmail,
                                $this->strPassword,
                                $this->intTipoId,
                                $this->intStatus);
            }else{
                // Actualizamos todo sin la contraseña por que no lo actualizo
                $sql = "UPDATE persona SET identificacion = ?, nombres = ?, apellidos = ?, telefono = ?, email_user = ?, rolid = ?, status = ?
                        WHERE idpersona = $this->intIdUsuario";
                
                $arrData = array( $this->strIdentificacion,
                                $this->strNombre,
                                $this->strApellido,
                                $this->intTelefono,
                                $this->strEmail,
                                $this->intTipoId,
                                $this->intStatus);
            }

            $request = $this->update($sql,$arrData);

        }else{

            $request = "exist";
        }

        return $request;
    }


    // Eliminar usuario
    public function deleteUsuario(int $intIdpersona){

        $this->intIdUsuario = $intIdpersona;
        $sql = "UPDATE persona SET status = ? WHERE idpersona = $this->intIdUsuario";
        $arrData = array(0);
        $request = $this->update($sql,$arrData);
        return $request;
    }


    // Actualizar Perfil
    public function updatePerfil(int $idUsuario, string $identificacion, string $nombre, string $apellido, int $telefono, string $password){

        $this->intIdUsuario = $idUsuario;
        $this->strIdentificacion = $identificacion;
        $this->strNombre = $nombre;
        $this->strApellido = $apellido;
        $this->intTelefono = $telefono;
        $this->strPassword = $password;

        // Validaciar si se esta envia datos al password ose que se quiere actualizar
        if($this->strPassword != ""){

            $sql = "UPDATE persona SET identificacion = ?, nombres = ?, apellidos = ?, telefono = ?, password = ?
                    WHERE idpersona = $this->intIdUsuario";
            
            $arrData = array( $this->strIdentificacion,
                            $this->strNombre,
                            $this->strApellido,
                            $this->intTelefono,
                            $this->strPassword);

            // Si no se hizo nada en el campo contraseña normal actual sin la contraseña
        }else{

            $sql = "UPDATE persona SET identificacion = ?, nombres = ?, apellidos = ?, telefono = ?
                    WHERE idpersona = $this->intIdUsuario";
            
            $arrData = array( $this->strIdentificacion,
                            $this->strNombre,
                            $this->strApellido,
                            $this->intTelefono);
        }

        $request = $this->update($sql,$arrData);
        return $request;

    }


    // Funcion para actualizar datos fiscales
    public function updateDataFiscal(int $idUsuario, string $strDni, string $strNomFiscal,string $strDirFiscal){

        $this->intIdUsuario = $idUsuario;
        $this->strDni = $strDni;
        $this->strNomFiscal = $strNomFiscal;
        $this->strDirFiscal = $strDirFiscal;

        // consulta par actulizar y setiar
        $sql = "UPDATE persona SET dni = ?, nombrefiscal = ?, direccionfiscal = ?
                WHERE idpersona = $this->intIdUsuario ";
        
        $arrData = array($this->strDni,
                        $this->strNomFiscal,
                        $this->strDirFiscal);

        $request = $this->update($sql,$arrData);

        return $request;

    }
 

}

?>