<?php

/**
 * Created by PhpStorm.
 * User: Pamela
 * Date: 9/17/2016
 * Time: 11:51 PM
 */
class request
{
    private $dbh;
    private $conexion;

    /**
     * request constructor.
     */
    public function __construct()
    {
        require_once 'dbaccess.php';
        $this->dbh=DatabaseHandler::Instance();
        $this->dbh->init($this->dbh->getDb());
        $this->conexion=$this->dbh->connecttodb();
    }

    public function createreimpreq($idp,$sac,$idparr){
        $q="INSERT INTO request(idPersona, idSacramento,idParroquia) VALUES (".$idp.",".$sac.",".$idparr.")";
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessaged: %s\n", $this->dbh->mysqli->error);
        }
        return $res;
    }
    public function  createrequesp($idp,$sac,$men,$lib,$pag,$num,$idparr){
        $q="INSERT INTO request(idPersona, idSacramento, mensaje, libro, pagina, numero, idParroquia) VALUES (".$idp.",".$sac.",'".$men."','".$lib."','".$pag."','".$num."',".$idparr.")";
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessaged: %s\n", $this->dbh->mysqli->error);
        }
        return $res;
    }

}