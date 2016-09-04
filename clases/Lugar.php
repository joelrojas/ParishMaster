<?php

/**
 * Created by PhpStorm.
 * User: Pamela
 * Date: 9/3/2016
 * Time: 6:39 PM
 */
class Lugar
{
    private $lugar;

    private $dbh;
    private $conexion;

    public function __construct($lugar)
    {
        $this->lugar = $lugar;
        require_once 'dbaccess.php';
        $this->dbh=DatabaseHandler::Instance();
        $this->dbh->init($this->dbh->getDb());
        $this->conexion=$this->dbh->connecttodb();
    }

    public function GetAll(){
        $q="select * from lugar";
        $res=$this->dbh->exequery($q);
        if(!$res) die('Invalid query'.mysql_error());
        return $res;
    }
}