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
        $q4="INSERT INTO persona_padre(idPersona, idPadre,tipo) VALUES (".$idp.",".$idpadre.",'p')";
        $res=$this->dbh->exequery($q4);
        if(!$res) die('Invalid query'.mysql_error());
        $q5="INSERT INTO persona_padre(idPersona, idPadre,tipo) VALUES (".$idp.",".$idmadre.",'m')";
        $res=$this->dbh->exequery($q5);
        if(!$res) die('Invalid query'.mysql_error());
        $q3="INSERT INTO certificado_beneficiario(idCertificado, idPersona) VALUES (".$certnum.",".$idp.")";
        $res=$this->dbh->exequery($q3);
        if(!$res) die('Invalid query'.mysql_error());
        return $certnum;

    }

    public function reg_comunion($idpadrino,$idcreador){
        $q="INSERT INTO certificado(fecha, idParroquia, idSacramento, idLugar,idSacerdote,idCertificante) VALUES ('".$this->fecha."',".$this->parroquia.",2,".$this->lugar.",".$this->sacerdote.",".$this->certificante.")";
        $res=$this->dbh->exequery($q);
        $certnum=mysql_insert_id();
        if(!$res) die('Invalida query'.mysql_error());
        $q1= "INSERT INTO certificado_padrino(idCertificado, idPersona) VALUES (".$certnum.",".$idpadrino.")";
        $res=$this->dbh->exequery($q1);
        if(!$res) die('Invalidb query'.mysql_error());
        $q3="INSERT INTO certificado_beneficiario(idCertificado, idPersona) VALUES (".$certnum.",".$idcreador.")";
        $res=$this->dbh->exequery($q3);
        if(!$res) die('Invalidc query'.mysql_error());
    }

    public function get_bau_info($idp){


        $q="SELECT certificado.idCertificado, certificado.idSacerdote, certificado.idCertificante, certificado.fecha as fechabautizo, parroquia.Nombre as parroquiabautizo, cura.Nombre as nombrecura, cura.Apellido as apellidocura,
            lugar.lugar as lugarnacimiento, cert.Nombre as nombrecertificante,cert.Apellido as apellidocertificante,  fiel.Nombre as nombrefiel, fiel.Apellido as apellidofiel, fiel.fechanac as fechanacimiento,
            padre.Nombre as nombrepadre, padre.Apellido as apellidopadre, madre.Nombre as nombremadre, madre.Apellido as apellidomadre,
            padrino.Nombre as nombrepadrino, padrino.Apellido as apellidopadrino, registro_civil.oficialia, registro_civil.nro_libro as libro, registro_civil.partida
            from certificado, parroquia, persona cura, lugar, persona cert, persona fiel, certificado_beneficiario, persona madre, persona padre, persona padrino, persona_padre ppm, persona_padre ppp, sacerdote sac, sacerdote certificante, registro_civil
            where certificado.idParroquia=parroquia.idParroquia
            and sac.idPersona=cura.idPersona
            and sac.idSacerdote=certificado.idSacerdote
            and certificante.idSacerdote=certificado.idCertificante
            and lugar.idLugar=certificado.idLugar
            and cert.idPersona=certificante.idPersona
            and fiel.idPersona=certificado_beneficiario.idPersona
            and certificado.idCertificado=certificado_beneficiario.idCertificado
            and madre.idPersona=ppm.idPadre
            and fiel.idPersona=ppm.idPersona
            and ppm.tipo='m'
            and padre.idPersona=ppp.idPadre
            and fiel.idPersona=ppp.idPersona
            and ppp.tipo='p'
            and registro_civil.idCertificado=certificado.idCertificado
            and certificado.idSacramento=1
            and fiel.idPersona=".$idp." GROUP BY(certificado.idCertificado)";
        $res=$this->dbh->exequery($q);
        if(!$res) die('Invalida query'.mysql_error());
        return $res;
    }

    public function get_comunion_info($idp){


        $q="SELECT certificado.idCertificado, certificado.idSacerdote, certificado.idCertificante, certificado.fecha as fechacomunion, parroquia.Nombre as parroquiacomunion, cura.Nombre as nombrecura, cura.Apellido as apellidocura,
            lugar.lugar as lugarcomunion, cert.Nombre as nombrecertificante,cert.Apellido as apellidocertificante,  fiel.Nombre as nombrefiel, fiel.Apellido as apellidofiel, fiel.fechanac as fechanacimiento,
            padrino.Nombre as nombrepadrino, padrino.Apellido as apellidopadrino
            from certificado, parroquia, persona cura, lugar, persona cert, persona fiel, certificado_beneficiario, persona padrino, sacerdote sac, sacerdote certificante, certificado_padrino
            where certificado.idParroquia=parroquia.idParroquia
            and sac.idPersona=cura.idPersona
            and sac.idSacerdote=certificado.idSacerdote
            and certificante.idSacerdote=certificado.idCertificante
            and lugar.idLugar=certificado.idLugar
            and cert.idPersona=certificante.idPersona
            and fiel.idPersona=certificado_beneficiario.idPersona
            and certificado.idCertificado=certificado_beneficiario.idCertificado
            and certificado.idSacramento=2
            and padrino.idPersona=certificado_padrino.idPersona
            and certificado.idCertificado=certificado_padrino.idCertificado
            and fiel.idPersona=".$idp." GROUP BY(certificado.idCertificado)";
        $res=$this->dbh->exequery($q);
        if(!$res) die('Invalida query'.mysql_error());
        return $res;
    }



}