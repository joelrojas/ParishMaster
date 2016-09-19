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

    public function get_reqs()
    {
        $q="SELECT request.idRequest, persona.Nombre, persona.Apellido, sacramento.Nombre as sacramento, request.mensaje, request.libro, request.pagina, request.numero, parroquia.Nombre as parroquia
            FROM request, persona, sacramento, parroquia 
            WHERE request.idPersona=persona.idPersona
            AND request.idSacramento=sacramento.idSacramento
            AND request.idParroquia=parroquia.idParroquia
            AND atendida=0";
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessaged: %s\n", $this->dbh->mysqli->error);
        }
        return $res;
    }

    public function get_req($id)
    {
        $q="SELECT request.idRequest, persona.Nombre, persona.idPersona, persona.Apellido, sacramento.Nombre as sacramento, sacramento.idSacramento, request.mensaje, request.libro, request.pagina, request.numero, parroquia.Nombre as parroquia
            FROM request, persona, sacramento, parroquia 
            WHERE request.idPersona=persona.idPersona
            AND request.idSacramento=sacramento.idSacramento
            AND request.idParroquia=parroquia.idParroquia
            AND atendida=0
            AND request.idRequest=".$id;
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessaged: %s\n", $this->dbh->mysqli->error);
        }
        $res=$this->dbh->fetchrow($res);
        return $res;
    }

    public function isespecial($id)
    {
        $q="SELECT libro FROM request WHERE idRequest=".$id;
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessaged: %s\n", $this->dbh->mysqli->error);
        }
        $res=$this->dbh->fetchrow($res);
       // if(is_null($res['libro']))
        return $res['libro'];
    }

    public function set_respuesta($id,$msj)
    {
        $q="UPDATE request SET respuesta='".$msj."', atendida=1 WHERE idRequest=".$id;
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessaged: %s\n", $this->dbh->mysqli->error);
        }
        
    }

    

}

//$a=new request();
//if(empty($a->isespecial($_GET['idreq']))) echo"null--".$a->isespecial($_GET['idreq']);
//else echo "not null--".$a->isespecial($_GET['idreq']);
