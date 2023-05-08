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

            $return = "exist";
        }
        return $return;
    }



    // 

    public function selectClientes(){
        
        // porque rolid = 7 porque alli esta el cliente
        // Extraer todos los registro con ID 7 porque son todos los cliente
         $sql = "SELECT idpersona, identificacion, nombres, apellidos, telefono, email_user, status
                FROM persona 
                WHERE rolid = 7 and status != 0";

         $request = $this->select_all($sql);
 
         return $request;
    }


}

?>