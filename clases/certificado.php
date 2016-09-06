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

    public function reg_bautizo($nombre,$apellido,$fechanac,$cipadrino,$cipadre,$cimadre,$cicreador){

        $q="INSERT INTO certificado(fecha, idParroquia, idSacerdote, idSacramento, idCertificante, idLugar) VALUES ('".$this->fecha."',".$this->parroquia.",".$this->sacerdote.",1,".$this->certificante.",".$this->lugar.")";
        $res=$this->dbh->exequery($q);
        if(!$res) die('Invalid query'.mysql_error());
        $certnum =mysql_insert_id();
        $q1= "INSERT INTO certificado_padrino(idCertificado, idPersona) VALUES ('".$certnum."',".$cipadrino.")";
        $res=$this->dbh->exequery($q1);
        if(!$res) die('Invalid query'.mysql_error());
        $q2= "INSERT INTO hijo(nombre, apellido, fechanac, idPadre, idMadre) VALUES ('".$nombre."','".$apellido."','".$fechanac."','".$cipadre."','".$cimadre."')";
        $res=$this->dbh->exequery($q2);
        if(!$res) die('Invalid query'.mysql_error());
        $q3="INSERT INTO certificado_beneficiario(idCertificado, idPersona) VALUES (".$certnum.",".$cicreador.")";
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

    public function reg_matrimonio($cipadrino1,$cipadrino2,$cipadrino3,$cipadrino4,$ciesposo,$ciesposa,$oficialia,$nro_libro,$partida){
        $q="INSERT INTO certificado(fecha, idParroquia, idSacramento, idLugar,idSacerdote,idCertificante) VALUES ('".$this->fecha."',".$this->parroquia.",4,".$this->lugar.",".$this->sacerdote.",".$this->certificante.")";
        $certnum=$this->dbh->insert($q);
        //if(!$res) die('Invalid query'.mysql_error());
        if(!empty($cipadrino1))
        {
            $q1= "INSERT INTO certificado_padrino(idCertificado, idPersona) VALUES ('".$certnum."',".$cipadrino1.")";
            $res=$this->dbh->exequery($q1);
        }
        if(!empty($cipadrino2))
        {
            $q1= "INSERT INTO certificado_padrino(idCertificado, idPersona) VALUES ('".$certnum."',".$cipadrino2.")";
            $res=$this->dbh->exequery($q1);
        }
        if(!empty($cipadrino3))
        {
            $q1= "INSERT INTO certificado_padrino(idCertificado, idPersona) VALUES ('".$certnum."',".$cipadrino3.")";
            $res=$this->dbh->exequery($q1);
        }
        if(!empty($cipadrino4))
        {
            $q1= "INSERT INTO certificado_padrino(idCertificado, idPersona) VALUES ('".$certnum."',".$cipadrino4.")";
            $res=$this->dbh->exequery($q1);
        }
        //if(!$res) die('Invalid query'.mysql_error());
        $q3="INSERT INTO certificado_beneficiario(idCertificado, idPersona) VALUES (".$certnum.",".$ciesposa.")";
        $res=$this->dbh->exequery($q3);
        $q3="INSERT INTO certificado_beneficiario(idCertificado, idPersona) VALUES (".$certnum.",".$ciesposo.")";
        $res=$this->dbh->exequery($q3);
        //if(!$res) die('Invalid query'.mysql_error());
        $q="INSERT INTO registro_civil(oficialia, nro_libro, partida, idCertificado) VALUES ('".$oficialia."','".$nro_libro."','".$partida."','".$certnum."')";
        $res=$this->dbh->exequery($q);
    }


    public function certificado_com(){
        $q1= "INSERT INTO certificado_beneficiario(idCertificado, idPersona) VALUES ([value-1],[value-2])";
    }

}