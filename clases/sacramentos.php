<?php
class sacramento
{

	public function __construct()
    {
        require_once 'dbaccess.php';
        $this->dbh=DatabaseHandler::Instance();
        $this->dbh->init($this->dbh->getDb());
        $this->conexion=$this->dbh->connecttodb();
    }

    public function get_sacramento()
    {
   		$q="SELECT * from sacramento";         
		  $res=$this->dbh->exequery($q);
		  if ($this->dbh->mysqli->error)
		  {
			 printf("Errormessage: %s\n", $this->dbh->mysqli->error);
		  }
		  return $res;
    }

    public function get_celebraciones($idSacerdote)
    {
        $q="SELECT fiel.Nombre as nombrefiel, fiel.Apellido as apellidofiel, sacramento.Nombre as sacramento, parroquia.Nombre as parroquia, horario_misa.horario, rm.fecha, horario_misa.idhorario_misa
            FROM reserva_misa rm, sacramento, sacerdote, persona fiel, parroquia, horario_misa 
            WHERE rm.idSacramento=sacramento.idSacramento
            AND rm.idPersona=fiel.idPersona
            AND rm.idSacerdote=sacerdote.idSacerdote
            AND rm.idParroquia=parroquia.idParroquia
            AND rm.idhorario_misa=horario_misa.idhorario_misa
            AND rm.fecha>= NOW()
            AND rm.idSacerdote=".$idSacerdote."
            ORDER BY fecha, horario_misa.idhorario_misa";         
          $res=$this->dbh->exequery($q);
          if ($this->dbh->mysqli->error)
          {
             printf("Errormessage: %s\n", $this->dbh->mysqli->error);
          }
          return $res;
    }

}


?>