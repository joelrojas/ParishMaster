<?php

class fiel
{
    private $id;
    public $nombre;
    public $apellido;

    private $dbh;
    private $conexion;


    public function __construct()
    {
        require_once 'dbaccess.php';
        $this->dbh=DatabaseHandler::Instance();
        $this->dbh->init($this->dbh->getDb());
        $this->conexion=$this->dbh->connecttodb();
    }

    public static function withID($id)                                        //llamada publica para otras clases
    {
        $instance = new self();
        $instance->loadByID($id);
        return $instance;
    }
    protected function loadByID($id)                                          //Buscar los atributos del ID
    {
        $q="select nombre, apellido from persona where ci=".$id;         //CAMBIAR QUE SI ES NUL RETORNE NOMBRE = ERROR PARA PONER ALARMA
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        $res=$this->dbh->fetchrow($res);
        if(is_null($res))
        $res = array('nombre' =>"ERROR" , 'apellido' =>"ERROR");
        $this->fill($res);
    }

    protected function fill(array $row)                                       //llenar el objeto con los valores de la BDD
    {
        $this->nombre=$row['nombre'];
        $this->apellido=$row['apellido'];
    }

}