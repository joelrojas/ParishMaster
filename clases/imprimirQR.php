<?php
    include('../phpqrcode/qrlib.php');
    require_once 'dbaccess.php';

    class QR
    {
    	private $name="temp01.png";
    	private $url="http://www.parishmaster.gwiddle.co.uk/Formularios/comprobaciondeexistencia.php?id=";

    	public function crea($id,$guardar=false,$name=null)
    	{

    		if(!is_null($name)) $this->name=$name;
    		QRcode::png($this->url.$id,"../temps/".$this->name,QR_ECLEVEL_H,5,1);
    		//$this->imprimir();
            return $this->GetHTML();
    		//if(!$guardar) $this->eliminar();
    	}
    	public function imprimir()
    	{
    		echo '<img src="../temps/'.$this->name.'"/>';
    	}

    	public function GetHTML(){
            return '<img class="img-responsive asd" src="../temps/'.$this->name.'"/>';
        }

    	public function eliminar()
    	{
    		
    		unlink("../temps/".$this->name);
    	}
    	
    }
   // $qr=new QR();
    //$qr->crea("1");
    //sleep(10);
   //$qr->crea("2");

?>