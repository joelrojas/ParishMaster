<?php

/**
 * Created by PhpStorm.
 * User: Pamela
 * Date: 9/4/2016
 * Time: 8:21 PM
 */
class certificado
{
    private $parroquia;
    private $sacerdote;
    private $certificante;
    private $lugar;
    private $legacy;
    private $fecha;

    private $dbh;
    private $conexion;

    /**
     * certificado constructor.
     * @param $parroquia
     * @param $sacerdote
     * @param $certificante
     * @param $lugar
     * @param $legacy
     * @param $fecha
     */
    public function __construct($parroquia, $sacerdote, $certificante, $lugar, $fecha)
    {
        $this->parroquia = $parroquia;
        $this->sacerdote = $sacerdote;
        $this->certificante = $certificante;
        $this->lugar = $lugar;
        $this->fecha = $fecha;

        require_once 'dbaccess.php';
        $this->dbh=DatabaseHandler::Instance();
        $this->dbh->init($this->dbh->getDb());
        $this->conexion=$this->dbh->connecttodb();

    }

    public function addregciv($oficialia,$nro_libro,$partida,$idcertificado){
        $q="INSERT INTO registro_civil(oficialia, nro_libro, partida, idCertificado) VALUES ('".$oficialia."','".$nro_libro."','".$partida."','".$idcertificado."')";
        $res=$this->dbh->exequery($q);
        if(!$res) die('Invalid query'.mysql_error());
    }

    public function reg_bautizo($nombre,$apellido,$fechanac,$idpadrino,$idpadre,$idmadre,$idp){

        $q="INSERT INTO certificado(fecha, idParroquia, idSacerdote, idSacramento, idCertificante, idLugar) VALUES ('".$this->fecha."',".$this->parroquia.",".$this->sacerdote.",1,".$this->certificante.",".$this->lugar.")";
        $res=$this->dbh->exequery($q);
        if(!$res) die('Invalid query'.mysql_error());
        $certnum =mysql_insert_id();
        $q1= "INSERT INTO certificado_padrino(idCertificado, idPersona) VALUES ('".$certnum."',".$idpadrino.")";
        $res=$this->dbh->exequery($q1);
        if(!$res) die('Invalid query'.mysql_error());
        $q4="INSERT INTO persona_padre(idPersona, idPadre) VALUES (".$idp.",".$idpadre.")";
        $res=$this->dbh->exequery($q4);
        if(!$res) die('Invalid query'.mysql_error());
        $q5="INSERT INTO persona_padre(idPersona, idPadre) VALUES (".$idp.",".$idmadre.")";
        $res=$this->dbh->exequery($q5);
        if(!$res) die('Invalid query'.mysql_error());
        $q3="INSERT INTO certificado_beneficiario(idCertificado, idPersona) VALUES (".$certnum.",".$idp.")";
        $res=$this->dbh->exequery($q3);
        if(!$res) die('Invalid query'.mysql_error());
        return $certnum;

    }

    public function reg_comunion($nombre,$apellido,$cipadrino,$cicreador){
        $q="INSERT INTO certificado(fecha, idParroquia, idSacramento, idLugar,idSacerdote,idCertificante) VALUES ('".$this->fecha."',".$this->parroquia.",2,".$this->lugar.",".$this->sacerdote.",".$this->certificante.")";
        $res=$this->dbh->exequery($q);
        $certnum=mysql_insert_id();
        if(!$res) die('Invalid query'.mysql_error());
        $q1= "INSERT INTO certificado_padrino(idCertificado, idPersona) VALUES ('".$certnum."',".$cipadrino.")";
        $res=$this->dbh->exequery($q1);
        if(!$res) die('Invalid query'.mysql_error());
        $q3="INSERT INTO certificado_beneficiario(idCertificado, idPersona) VALUES (".$certnum.",".$cicreador.")";
        $res=$this->dbh->exequery($q3);
        if(!$res) die('Invalid query'.mysql_error());
    }


    public function certificado_com(){
        $q1= "INSERT INTO certificado_beneficiario(idCertificado, idPersona) VALUES ([value-1],[value-2])";
    }

}