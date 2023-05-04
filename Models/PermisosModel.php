<?php

    // recuperar informacion de BD de enviar al controlador y luego lo enviamos a la vista
    class PermisosModel extends Mysql{

        // Propiedades Basicas
        public $intIdPermiso;
        public $intRolid;
        public $r;
        public $w;
        public $u;
        public $d;

        public function __construct(){

            // echo "Mensaje desde el modelo Home";
            parent::__construct();
        }
    
    #1 Metodo para seleccionar Modulos 
    public function selectModulos(){

        // Selecciona todas las varaibles que sean 1 y no cuenta lo que estan desactivados
        $sql = "SELECT * FROM modulo WHERE status != 0";
        $request = $this->select_all($sql);
        return $request;
        
    }

    #2 Metodo para Seleccionar Permisos
    public function selectPermisosRol(int $idrol){

        $this->intRolid = $idrol;
        $sql = "SELECT * FROM permisos WHERE rolid = $this->intRolid";
        $request = $this->select_all($sql);
        return $request;
    }

    #3 Metodo para Eliminar un permisos
    public function deletePermisos(int $idrol){

        $this->intRolid = $idrol;
        $sql = "DELETE FROM permisos WHERE rolid = $this->intRolid";
        $request = $this->delete($sql);
        return $request;
    }


    #4 Metodo Insertar Permisos para almacenar en DDBB
    public function insertPermisos(int $idrol, int $idmodulo, int $r, int $w, int $u, int $d){

    //   Asignacion de variables publicas con parametros
        $this->intRolid = $idrol;
        $this->intModuloid = $idmodulo; 
        $this->r = $r;
        $this->w = $w;
        $this->u = $u;
        $this->d = $d;

        $query_insert = "INSERT INTO permisos(rolid,moduloid,r,w,u,d) VALUES(?,?,?,?,?,?)";

        $arrData = array($this->intRolid, $this->intModuloid, $this->r, $this->w, $this->u, $this->d);
        $request_insert = $this->insert($query_insert,$arrData);
        return $request_insert;
    }


    //# 5 Metodo para asignar permsio deacurdo al logeo

    public function permisosModulo(int $idrol){
        $this->intRolid = $idrol;

        $sql = "SELECT p.rolid,
                        p.moduloid,
                        m.titulo as modulo,
                        p.r,
                        p.w,
                        p.u,
                        p.d
                FROM permisos p
                INNER JOIN modulo m
                ON p.moduloid = m.idmodulo
                WHERE p.rolid = $this->intRolid";
        
        
        $request = $this->select_all($sql);
        // dep($request);
        //Crear nuevo arreglo
        $arrPermisos = array();

        // recorrer todos los elemento de este array($request)

        for($i=0; $i < count($request); $i++){
            // arreglpo animado perro aun nunca vi este en miv idad
            $arrPermisos[$request[$i]['moduloid']] = $request[$i];
        }

        // dep($arrPermisos);
        return $arrPermisos;

    }
      

    }

?>
