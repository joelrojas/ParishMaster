<?php

/**
 * Created by PhpStorm.
 * User: Pamela
 * Date: 8/31/2016
 * Time: 4:44 PM
 */
class parroquia
{
    private $id;
    private $nombre;

    private $dbh;
    private $conexion;

    public function __construct($id, $nombre)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        require_once 'dbaccess.php';
        $this->dbh=DatabaseHandler::Instance();
        $this->dbh->init($this->dbh->getDb());
        $this->conexion=$this->dbh->connecttodb();

    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function GetAll(){
        $q="SELECT idParroquia, Nombre FROM parroquia";
        echo $q;
        $res=$this->dbh->exequery($q);
        if(!res) die('Invalid query'.mysql_error());
        return res;
    }




}