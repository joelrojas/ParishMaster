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
        $q="REPLACE INTO persona(CI, Nombre, Apellido, fechanac, idGenero,email,password) VALUES (".$this->ci.",'".$this->nombre."','".$this->apellido."','".$this->fechanac."',".$this->genero.",'".$this->email."','".$this->pass."')";
        $res=$this->dbh->exequery($q);
        if(!$res) die('Invalid query'.mysql_error());
        return $res;
    }

    public function buscar($username){
        $q="select persona.ci, persona.Nombre, persona.Apellido, persona.password , persona.fechanac
        from persona
        where persona.ci=".$username;
        $res=$this->dbh->exequery($q);
        if(!$res) die('Invalid query'.mysql_error());
        return $res;
    }

    public function isSacerdote($ci){
        $q="SELECT * from sacerdote
            where sacerdote.idPersona=".$ci;
        echo $q;
        $res=$this->dbh->exequery($q);
        if(!$res) die('Invalid query'.mysql_error());
        return (mysql_num_rows($res)>=1);
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