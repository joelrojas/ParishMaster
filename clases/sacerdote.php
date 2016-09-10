<?php

/**
 * Created by PhpStorm.
 * User: Pamela F.
 * Date: 8/31/2016
 * Time: 5:50 PM 
 */
class sacerdote
{
    private $idpersona;
    private $idtipo;
    private $idparr;

    private $dbh;
    private $conexion;

    /**
     * sacerdote constructor.
     * @param $idpersona
     * @param $idtipo
     * @param $idparr
     */
    public function __construct($idpersona, $idtipo, $idparr)
    {
        $this->idpersona = $idpersona;
        $this->idtipo = $idtipo;
        $this->idparr = $idparr;


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

    public function getTipos(){
        $q="select * from tipo_sacerdote";
        $res=$this->dbh->exequery($q);
        if(!$res) die('Invalid query'.mysql_error());
        return $res;
    }

    public function reg(){
        $q="INSERT INTO sacerdote(idPersona, idtipo_sacerdote, idParroquia) VALUES (".$this->idpersona.",".$this->idtipo.",".$this->idparr.")";
        $res=$this->dbh->exequery($q);
        if(!$res) die('Invalid query'.mysql_error());
        return $res;
    }

    public function gettipo($ids){
        $q="SELECT tipo_sacerdote.tipo 
            from tipo_sacerdote, sacerdote, persona
            where persona.idPersona=sacerdote.idPersona
            and tipo_sacerdote.idtipo_sacerdote=sacerdote.idtipo_sacerdote
            and sacerdote.idSacerdote=".$ids;
        $res=$this->dbh->exequery($q);
        if(!$res) die('Invalida query'.mysql_error());
        $fila=mysql_fetch_array($res);
        return $fila['tipo'];
    }

}