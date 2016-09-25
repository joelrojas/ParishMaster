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
    public $nombre;
    public $parroquia;
    public $tipo;

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
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        return $res;
    }

    public function getTipos(){
        $q="select * from tipo_sacerdote";
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        return $res;
    }

    public function reg(){
        $q="INSERT INTO sacerdote(idPersona, idtipo_sacerdote, idParroquia) VALUES (".$this->idpersona.",".$this->idtipo.",".$this->idparr.")";
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        return $res;
    }

    public function gettipo($ids){
        $q="SELECT tipo_sacerdote.tipo 
            from tipo_sacerdote, sacerdote, persona
            where persona.idPersona=sacerdote.idPersona
            and tipo_sacerdote.idtipo_sacerdote=sacerdote.idtipo_sacerdote
            and sacerdote.idSacerdote=".$ids;
        echo $q;
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        $fila=$res->fetch_array(MYSQLI_ASSOC);
        return $fila['tipo'];
    }

    public function get_sac_parr($idpar){
        $q="select sacerdote.idSacerdote, tipo_sacerdote.tipo, persona.Nombre, persona.Apellido
            from sacerdote, tipo_sacerdote, persona
            where sacerdote.idPersona=persona.idPersona
            and sacerdote.idtipo_sacerdote=tipo_sacerdote.idtipo_sacerdote
            AND sacerdote.idParroquia=".$idpar;
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        return $res;
    }
    public static function withname($name)                                        //llamada publica para otras clases
    {
        $instance = new self("","","","","");
        $instance->loadByname($name);
        return $instance;
    }
    
    protected function loadByname($id)                                          //Buscar los atributos del ID
    {
        $q="DROP INDEX IF EXISTS Nombre ON persona;
            ALTER TABLE persona ADD FULLTEXT(nombre, apellido);";
        $this->dbh->exequery($q);

        $q="SELECT sacerdote.idSacerdote, tipo_sacerdote.tipo,persona.Nombre,persona.Apellido, parroquia.Nombre as parroquia
            from sacerdote, tipo_sacerdote,persona, parroquia
            where sacerdote.idPersona=persona.idPersona
            and sacerdote.idtipo_sacerdote=tipo_sacerdote.idtipo_sacerdote
            and MATCH (persona.Nombre,persona.Apellido) AGAINST ('".$id."' IN BOOLEAN MODE)";
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }

        $res=$this->dbh->fetchrow($res);
        if(is_null($res))
            $res = array('Nombre' =>"ERROR");
        $this->fill($res);
    }
    protected function fill(array $row)                                       //llenar el objeto con los valores de la BDD
    {
        if($row['Nombre'] !="ERROR")
        {
            $this->parroquia=$row['parroquia'];
            $this->nombre=$row['Nombre']." ".$row['Apellido'];
            $this->tipo=$row['tipo'];
        }
        
    }


}