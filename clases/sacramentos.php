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

}


?>