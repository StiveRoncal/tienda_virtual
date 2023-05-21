<?php

class ClientesModel extends Mysql{

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


    // Insertar Clientes
    public function insertCliente(string $identificacion,string $nombre, string $apellido, int $telefono, 
    string $email, string $password, int $tipoid, string $dni, string $nomFiscal, string $dirFiscal){


        $this->strIdentificacion = $identificacion;
        $this->strNombre = $nombre;
        $this->strApellido = $apellido;
        $this->intTelefono = $telefono;
        $this->strEmail = $email;
        $this->strPassword = $password;
        $this->intTipoId = $tipoid;
        
        $this->strDni = $dni;
        $this->strNomFiscal = $nomFiscal;
        $this->strDirFiscal = $dirFiscal;

         
        $return = 0;

        $sql = "SELECT * FROM persona WHERE 
                email_user = '{$this->strEmail}' or identificacion = '{$this->strIdentificacion}'";

        $request = $this->select_all($sql);


        if(empty($request)){

            $query_insert = "INSERT INTO persona(
                identificacion,nombres,apellidos,telefono,email_user,password,rolid,dni,nombrefiscal,direccionfiscal) 
                VALUES(?,?,?,?,?,?,?,?,?,?) ";

            $arrData = array(
                $this->strIdentificacion,
                $this->strNombre,
                $this->strApellido,
                $this->intTelefono,
                $this->strEmail,
                $this->strPassword,
                $this->intTipoId,
                $this->strDni,
                $this->strNomFiscal,
                $this->strDirFiscal
            );

            $request_insert = $this->insert($query_insert,$arrData);
            $return = $request_insert;
        }else{

            $return = false;
        }
        return $return;
    }



    // Seleccionar Usuario que Preferimos

    public function selectClientes(){
        
        // porque rolid = 7 porque alli esta el cliente
        // Extraer todos los registro con ID 7 porque son todos los cliente
         $sql = "SELECT idpersona, identificacion, nombres, apellidos, telefono, email_user, status
                FROM persona 
                WHERE rolid = 7 and status != 0";

         $request = $this->select_all($sql);
 
         return $request;
    }


    // SElecionar un Cliente Espefico deacuero a su ID
    public function selectCliente(int $idpersona){

        $this->intIdUsuario = $idpersona;
        // Validar que solo nuestre clientes
        $sql = "SELECT idpersona, identificacion, nombres, apellidos, telefono, email_user, dni, nombrefiscal, direccionfiscal, status,
                    DATE_FORMAT(datecreated,'%d / %m / %Y') as fechaRegistro
                    FROM persona 
                    WHERE idpersona = $this->intIdUsuario and rolid = 7";
        
        $request = $this->select($sql);
        return $request;
    }


    // Actualizar Datos de Cliente Similar alos otros 
    public function updateCliente(int $idUsuario, string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password, string $dni, string $nomFiscal, string $dirFiscal){

        $this->intIdUsuario = $idUsuario;
        $this->strIdentificacion = $identificacion;
        $this->strNombre = $nombre;
        $this->strApellido = $apellido;
        $this->intTelefono = $telefono;
        $this->strEmail = $email;
        $this->strPassword = $password;
        
        $this->strDni = $dni;
        $this->strNomFiscal = $nomFiscal;
        $this->strDirFiscal = $dirFiscal;

        // Validacion si se repite identificaio o meail

        $sql = "SELECT * FROM persona WHERE (email_user = '{$this->strEmail}' AND idpersona != $this->intIdUsuario)
                                        OR (identificacion = '{$this->strIdentificacion}' AND idpersona != $this->intIdUsuario)";

        $request = $this->select_all($sql);

        // condicioanl si esta no existe actualiza
        if(empty($request)){
            
            // condicional si el password no esta vacio actulia 
            if($this->strPassword != ""){

                $sql = "UPDATE persona SET identificacion = ?, nombres = ?, apellidos = ?, telefono = ?, email_user = ?, password = ?,
                        dni = ?, nombrefiscal = ?, direccionfiscal = ?  
                        WHERE idpersona = $this->intIdUsuario ";
                
                $arrData = array( $this->strIdentificacion,
                                $this->strNombre,
                                $this->strApellido,
                                $this->intTelefono,
                                $this->strEmail,
                                $this->strPassword,
                                $this->strDni,
                                $this->strNomFiscal,
                                $this->strDirFiscal);
            }else{
                // Actualizamos todo sin la contraseña por que no lo actualizo
                $sql = "UPDATE persona SET identificacion = ?, nombres = ?, apellidos = ?, telefono = ?, email_user = ?,
                         dni = ?, nombrefiscal = ?, direccionfiscal = ? 
                        WHERE idpersona = $this->intIdUsuario";
                
                $arrData = array( $this->strIdentificacion,
                                $this->strNombre,
                                $this->strApellido,
                                $this->intTelefono,
                                $this->strEmail,
                                $this->strDni,
                                $this->strNomFiscal,
                                $this->strDirFiscal);
            }

            $request = $this->update($sql,$arrData);

        }else{

            $request = false;
        }

        return $request;
    }


    // Eliminar Clinete
    public function deleteCliente(int $intIdpersona){

        $this->intIdUsuario = $intIdpersona;
        $sql = "UPDATE persona SET status = ? WHERE idpersona = $this->intIdUsuario";
        $arrData = array(0);
        $request = $this->update($sql,$arrData);
        return $request;
    }

}

?>