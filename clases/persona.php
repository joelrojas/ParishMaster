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

    public function registrar(){
        $q="INSERT INTO persona(CI, Nombre, Apellido, fechanac, idGenero) VALUES (".$this->ci.",'".$this->nombre."','".$this->apellido."','".$this->fechanac."',".$this->genero.")";
        $idpers=$this->dbh->insert($q);
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
        $q="select persona.idPersona, persona.ci, persona.Nombre, persona.Apellido , persona.fechanac
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