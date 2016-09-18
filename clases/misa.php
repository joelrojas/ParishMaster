<?php
class misa
{

	public function __construct()
    {
        require_once 'dbaccess.php';
        $this->dbh=DatabaseHandler::Instance();
        $this->dbh->init($this->dbh->getDb());
        $this->conexion=$this->dbh->connecttodb();
    }

    public function get_horarios($fecha,$idParroquia,$idSacerdote)
    {
   		$q="SELECT h.idhorario_misa, h.horario 
			FROM horario_misa h
			WHERE h.idhorario_misa NOT IN( SELECT rm.idhorario_misa 
                              			FROM reserva_misa rm 
                              			WHERE rm.fecha='".$fecha."'
                              			AND (rm.idParroquia=".$idParroquia." OR rm.idSacerdote=".$idSacerdote.")) ";         
		$res=$this->dbh->exequery($q);
		if ($this->dbh->mysqli->error)
		{
			printf("Errormessage: %s\n", $this->dbh->mysqli->error);
		}
		return $res;
    }

    public function reservar_misa($fecha,$idParroquia,$idSacerdote,$idPersona, $idSacramento,$idhorario_misa)
    {
    	$q="INSERT INTO reserva_misa(idSacramento, idPersona, idSacerdote, idParroquia, idhorario_misa, fecha) VALUES (".$idSacramento.", ".$idPersona.", ".$idSacerdote.", ".$idParroquia.", ".$idhorario_misa.", '".$fecha."')";         
		$res=$this->dbh->exequery($q);
    }


}



?>