<?php

/**
 * Created by PhpStorm.
 * User: Pamela
 * Date: 9/4/2016
 * Time: 1:16 PM
 */
class persona
{
    private $ci;
    private $nombre;
    private $apellido;
    private $fechanac;
    private $genero;
    private $email;
    private $cel;
    private $fb;

    private $usuario;
    private $pass;

    private $dbh;
    private $conexion;

    /**
     * persona constructor.
     * @param $ci
     * @param $nombre
     * @param $apellido
     * @param $fechanac
     * @param $genero
     */
    public function __construct($ci, $nombre, $apellido, $fechanac, $genero, $email, $pass)
    {
        $this->ci = $ci;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->fechanac = $fechanac;
        $this->genero = $genero;


        $this->email = $email;
        $this->pass=$pass;

        require_once 'dbaccess.php';
        $this->dbh=DatabaseHandler::Instance();
        $this->dbh->init($this->dbh->getDb());
        $this->conexion=$this->dbh->connecttodb();
    }

    public function addsocial($cel,$fb){
        $this->cel=$cel;
        $this->fb=$fb;
    }

    public function updatesoc($id){
        $q="UPDATE persona set celular='".$this->cel."' , facebook='".$this->fb."' 
            where persona.idPersona=".$id;
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        return $res;
    }

    public function registrar(){
        $q="INSERT INTO persona(CI, Nombre, Apellido, fechanac, idGenero, celular, facebook) VALUES (".$this->ci.",'".$this->nombre."','".$this->apellido."','".$this->fechanac."',".$this->genero.",'".$this->cel."','".$this->fb."')";
        $idpers=$this->dbh->insert($q);
        echo $q;
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        return $idpers;
    }

    public function regcuenta($idpers){
        $q1="INSERT INTO cuenta(email, password, idPersona) VALUES ('".$this->email."','".$this->pass."',".$idpers.")";
        $res=$this->dbh->exequery($q1);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        return $res;
    }

    public function buscar($email){
        $q="select persona.idPersona, persona.ci, persona.Nombre, persona.Apellido , persona.fechanac, cuenta.email, cuenta.password
            from persona, cuenta
            where cuenta.idPersona=persona.idPersona
            and cuenta.email='".$email."'";
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        return $res;
    }

    public function buscarper($ci){
        $q="select persona.idPersona, persona.ci, persona.Nombre, persona.Apellido , persona.fechanac, persona.celular, persona.facebook
            from persona
            where persona.ci='".$ci."'";
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        if(mysqli_num_rows($res)==0) return "ERROR";
        return $res;
    }

    public function isSacerdote($ci){
        $q="SELECT * from sacerdote, persona
            where sacerdote.idPersona=persona.idPersona
            and persona.ci=".$ci;
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        return (mysqli_num_rows($res)>=1);
    }

    public function idfromci($ci){
        $q="SELECT persona.idPersona from persona where persona.CI='".$ci."'";
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        $fila=$res->fetch_array(MYSQLI_ASSOC);
        return $fila['idPersona'];
    }

    public function buscarmail($email){
        $q="SELECT * from cuenta where cuenta.email='".$email."'";
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        $rows=mysqli_num_rows($res);
        return $rows>=1;
    }

    public function tienesacramento($idp, $ids){
        $q="select * from persona, certificado, certificado_beneficiario
            WHERE persona.idPersona=certificado_beneficiario.idPersona
            and certificado.idCertificado=certificado_beneficiario.idCertificado
            and persona.idPersona=".$idp." and certificado.idSacramento=".$ids;
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        $rows=mysqli_num_rows($res);
        return $rows>=1;
    }

    public function TieneCuenta($ci){
        $q="select * from persona, cuenta
            where cuenta.idPersona=persona.idPersona
            and persona.CI=".$ci;
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        $rows=mysqli_num_rows($res);
        return $rows>=1;    
    }

    public function GetEmailsSac($sacnum, $lug, $fecha, $parr, $pf,$edmin, $edmax){
        $q="SELECT cuenta.email, (CURDATE() - persona.fechanac) / 365.242199 as edad  from cuenta, persona, certificado, certificado_beneficiario";
        if($pf!="") $q.=", persona_padre ";
        $q.=" where cuenta.idPersona=persona.idPersona
            and certificado.idCertificado=certificado_beneficiario.idCertificado
            and persona.idPersona=certificado_beneficiario.idPersona
            and certificado.idSacramento=".$sacnum;
        if($lug!="") $q.=" and certificado.idLugar=".$lug;
        if($fecha!="") $q.=" and certificado.fecha='".$fecha."'";
        if($parr!="") $q.=" and certificado.idParroquia=".$parr;
        if($edmin!="" && $edmax!="") $q.=" and ((CURDATE() - persona.fechanac) / 365.242199) BETWEEN ".$edmin." AND ".$edmax;
        else if($edmin!="") $q.=" and  ((CURDATE() - persona.fechanac) / 365.242199) BETWEEN 0 AND ".$edmax;
        else if($edmax!="") $q.=" and  ((CURDATE() - persona.fechanac) / 365.242199) BETWEEN ".$edmin." AND 99";
        if($pf!="") $q.=" and persona.idPersona=persona_padre.idPadre";
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        return $res;
    }


    public function GetEmailsSacerdotes($parr){
        $q="SELECT cuenta.email from cuenta, persona, sacerdote
            where cuenta.idPersona=persona.idPersona
            and persona.idPersona=sacerdote.idPersona";
        if($q!="") $q.=" and sacerdote.idParroquia=".$parr;
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        return $res;
    }

    public function GetInfoSac($idp){
        $q="SELECT tipo_sacerdote.tipo, parroquia.Nombre
        from sacerdote,tipo_sacerdote,parroquia,persona
        where sacerdote.idPersona=persona.idPersona
        and tipo_sacerdote.idtipo_sacerdote=sacerdote.idtipo_sacerdote
        and parroquia.idParroquia=sacerdote.idParroquia
        and persona.idPersona=".$idp;
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        return $res;
    }


    public function getCi()
    {
        return $this->ci;
    }

    /**
     * @param mixed $ci
     */
    public function setCi($ci)
    {
        $this->ci = $ci;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * @param mixed $apellido
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    /**
     * @return mixed
     */
    public function getFechanac()
    {
        return $this->fechanac;
    }

    /**
     * @param mixed $fechanac
     */
    public function setFechanac($fechanac)
    {
        $this->fechanac = $fechanac;
    }

    /**
     * @return mixed
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * @param mixed $genero
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;
    }




}