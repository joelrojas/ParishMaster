<?php

/**
 * Created by PhpStorm.
 * User: Pamela
 * Date: 8/31/2016
 * Time: 5:50 PM
 */
class sacerdote
{
    private $id;
    private $nombre;
    private $tipo;

    private $dbh;
    private $conexion;


    public function __construct($id, $nombre, $tipo)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->tipo = $tipo;

        require_once 'dbaccess.php';
        $this->dbh=DatabaseHandler::Instance();
        $this->dbh->init($this->dbh->getDb());
        $this->conexion=$this->dbh->connecttodb();
    }

    public function GetAll(){
        $q="select sacerdote.idSacerdote, tipo_sacerdote.tipo,persona.Nombre,persona.Apellido
            from sacerdote, tipo_sacerdote,persona
            where sacerdote.idPersona=persona.idPersona
            and sacerdote.idtipo_sacerdote=tipo_sacerdote.idtipo_sacerdote";
        $res=$this->dbh->exequery($q);
        if(!$res) die('Invalid query'.mysql_error());
        return $res;
    }

}