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
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }

        return $res;
    }

    public function get_parr_matrimonio($eo,$ea)
    {
        $q="SELECT parroquia.idParroquia, parroquia.Nombre 
            FROM parroquia, certificado, certificado_beneficiario, persona
            WHERE certificado.idParroquia=parroquia.idParroquia
            AND certificado.idCertificado=certificado_beneficiario.idCertificado
            AND certificado.idSacramento=1
            AND certificado_beneficiario.idPersona=persona.idPersona
            AND (persona.CI=".$eo." OR persona.CI=".$ea.")";
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }

        return $res;
    }


}
