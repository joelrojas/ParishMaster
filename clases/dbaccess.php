<?php 

class DatabaseHandler
{
	private $host='localhost';
	private $usr='root';
	private $pass='';
	private $db='parishmaster';
	private $conexion;

	//patron singleton
	//devuelve instancia en vez de un nuevo objeto
	public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new DatabaseHandler();
        }
        return $inst;
    }

    //setear la variable de base de datos
    function init($db1){
		$this->db = $db1;	
    }

	//begin connection (empezar conexion)
	function connecttodb(){
		$this->conexion= mysql_connect($this->host ,$this->usr,$this->pass);
    	mysql_select_db($this->db,$this->conexion);	
    	return $this->conexion;
	}

	//execute query (ejecutar consulta)
	function exequery($q){
		$resultado=mysql_query($q, $this->conexion);
		return $resultado;
	}

	//fetch one row from query result (sacar una fila de un resultado)
	function fetchrow($qresul){
		$res=mysql_fetch_array($qresul);
		return $res;
	}

	//cambiar informacion como host, usuario o pass
	function setInfo($host1,$usr1,$pass1){
		$this->host = $host1;
		$this->usr = $usr1;
		$this->pass = $pass1;
	}

	public function getDb()
	{
		return $this->db;
	}



}

?>

 