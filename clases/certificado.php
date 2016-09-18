<?php

/**
 * Created by PhpStorm.
 * User: Pamela
 * Date: 9/4/2016
 * Time: 8:21 PM
 */
require_once 'fiel.php';
class certificado
{
    private $id;
    private $parroquia;
    private $sacerdote;
    private $certificante;
    private $lugar;
    private $legacy;
    private $fecha;
    private $sacramento;
    private $fiel;

    private $dbh;
    private $conexion;

    /**
     * certificado constructor.
     * @param $parroquia
     * @param $sacerdote
     * @param $certificante
     * @param $lugar
     * @param $legacy
     * @param $fecha
     */
    public function __construct($parroquia, $sacerdote, $certificante, $lugar, $fecha)
    {
        $this->parroquia = $parroquia;
        $this->sacerdote = $sacerdote;
        $this->certificante = $certificante;
        $this->lugar = $lugar;
        $this->fecha = $fecha;

        require_once 'dbaccess.php';
        $this->dbh=DatabaseHandler::Instance();
        $this->dbh->init($this->dbh->getDb());
        $this->conexion=$this->dbh->connecttodb();

    }
    public function getid()
    {
        return $this->id;
    }
    public function getparroquia()
    {
        return $this->parroquia;
    }
    public function getsacerdote()
    {
        return $this->sacerdote;
    }
    public function getlugar()
    {
        return $this->lugar;
    }
    public function getfecha()
    {
        return $this->fecha;
    }
    public function getsacramento()
    {
        return $this->sacramento;
    }
    public function getfiel()
    {
        return $this->fiel;
    }
    public static function withID($id)                                        //llamada publica para otras clases
    {
        $instance = new self("","","","","");
        $instance->loadByID($id);
        return $instance;
    }
    protected function loadByID($id)                                          //Buscar los atributos del ID
    {
        $q="SELECT cer.idCertificado, cer.fecha, pa.Nombre as parroquia, concat(concat(ps.Nombre,' '),ps.Apellido) as parroco, sac.Nombre as sacramento, l.lugar, concat(concat(fiel.Nombre,' '),fiel.Apellido) as fiel, fiel.CI 
        FROM certificado cer, parroquia pa, sacerdote sa, sacramento sac, persona ps, persona fiel, certificado_beneficiario cb, lugar l 
        WHERE cer.idParroquia=pa.idParroquia
        and cer.idSacerdote=sa.idSacerdote
        and cer.idSacramento=sac.idSacramento
        and cer.idLugar=l.idLugar
        and ps.idPersona=sa.idPersona
        and cb.idCertificado=cer.idCertificado
        and cb.idPersona=fiel.idPersona
        and fiel.CI=".$id;
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }

        $res=$this->dbh->fetchrow($res);
        if(is_null($res))
            $res = array('idCertificado' =>"ERROR");
        $this->fill($res);
    }
    public static function withcertID($id)                                        //llamada publica para otras clases
    {
        $instance = new self("","","","","");
        $instance->loadBycertID($id);
        return $instance;
    }
    protected function loadBycertID($id)                                          //Buscar los atributos del ID
    {
        $q="SELECT cer.idCertificado, cer.fecha, pa.Nombre as parroquia, concat(concat(ps.Nombre,' '),ps.Apellido) as parroco, sac.Nombre as sacramento, l.lugar, concat(concat(fiel.Nombre,' '),fiel.Apellido) as fiel, fiel.CI 
        FROM certificado cer, parroquia pa, sacerdote sa, sacramento sac, persona ps, persona fiel, certificado_beneficiario cb, lugar l 
        WHERE cer.idParroquia=pa.idParroquia
        and cer.idSacerdote=sa.idSacerdote
        and cer.idSacramento=sac.idSacramento
        and cer.idLugar=l.idLugar
        and ps.idPersona=sa.idPersona
        and cb.idCertificado=cer.idCertificado
        and cb.idPersona=fiel.idPersona
        and cer.idCertificado=".$id;        
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }

        $res=$this->dbh->fetchrow($res);
        if(is_null($res))
            $res = array('idCertificado' =>"ERROR");
        $this->fill($res);
    }

    protected function fill(array $row)                                       //llenar el objeto con los valores de la BDD
    {
        $this->id=$row['idCertificado'];
        if($this->id !="ERROR")
        {
            $this->parroquia=$row['parroquia'];
            $this->sacerdote=$row['parroco'];
            $this->lugar=$row['lugar'];
            $this->fecha=$row['fecha'];
            $this->sacramento=$row['sacramento'];
            $this->fiel=$row['fiel'];
        }
        
    }

    public function addregciv($oficialia,$nro_libro,$partida,$idcertificado){
        $q="INSERT INTO registro_civil(oficialia, nro_libro, partida, idCertificado) VALUES ('".$oficialia."','".$nro_libro."','".$partida."','".$idcertificado."')";
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
    }

    public function reg_bautizo($nombre,$apellido,$fechanac,$idpadrino,$idpadre,$idmadre,$idp){

        $q="INSERT INTO certificado(fecha, idParroquia, idSacerdote, idSacramento, idCertificante, idLugar) VALUES ('".$this->fecha."',".$this->parroquia.",".$this->sacerdote.",1,".$this->certificante.",".$this->lugar.")";
        $certnum=$this->dbh->insert($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        $q1= "INSERT INTO certificado_padrino(idCertificado, idPersona) VALUES ('".$certnum."',".$idpadrino.")";
        $res1=$this->dbh->exequery($q1);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        $q4="INSERT INTO persona_padre(idPersona, idPadre,tipo) VALUES (".$idp.",".$idpadre.",'p')";
        $res2=$this->dbh->exequery($q4);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        $q5="INSERT INTO persona_padre(idPersona, idPadre,tipo) VALUES (".$idp.",".$idmadre.",'m')";
        $res3=$this->dbh->exequery($q5);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        $q3="INSERT INTO certificado_beneficiario(idCertificado, idPersona) VALUES (".$certnum.",".$idp.")";
        $res4=$this->dbh->exequery($q3);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        return $certnum;

    }

    public function reg_comunion($idpadrino,$idcreador){
        $q="INSERT INTO certificado(fecha, idParroquia, idSacramento, idLugar,idSacerdote,idCertificante) VALUES ('".$this->fecha."',".$this->parroquia.",2,".$this->lugar.",".$this->sacerdote.",".$this->certificante.")";
        $certnum=$this->dbh->insert($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        $q1= "INSERT INTO certificado_padrino(idCertificado, idPersona) VALUES (".$certnum.",".$idpadrino.")";
        $res=$this->dbh->exequery($q1);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        $q3="INSERT INTO certificado_beneficiario(idCertificado, idPersona) VALUES (".$certnum.",".$idcreador.")";
        $res=$this->dbh->exequery($q3);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
    }


    public function reg_matrimonio($cipadrino1,$cipadrino2,$cipadrino3,$cipadrino4,$ciesposo,$ciesposa,$oficialia,$nro_libro,$partida){
        $q="INSERT INTO certificado(fecha, idParroquia, idSacramento, idLugar,idSacerdote,idCertificante) VALUES ('".$this->fecha."',".$this->parroquia.",4,".$this->lugar.",".$this->sacerdote.",".$this->certificante.")";
        $certnum=$this->dbh->insert($q);
        //        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        if(!empty($cipadrino1))
        {
            $q1= "INSERT INTO certificado_padrino(idCertificado, idPersona) VALUES ('".$certnum."',".$cipadrino1.")";
            $res=$this->dbh->exequery($q1);
        }
        if(!empty($cipadrino2))
        {
            $q1= "INSERT INTO certificado_padrino(idCertificado, idPersona) VALUES ('".$certnum."',".$cipadrino2.")";
            $res=$this->dbh->exequery($q1);
        }
        if(!empty($cipadrino3))
        {
            $q1= "INSERT INTO certificado_padrino(idCertificado, idPersona) VALUES ('".$certnum."',".$cipadrino3.")";
            $res=$this->dbh->exequery($q1);
        }
        if(!empty($cipadrino4))
        {
            $q1= "INSERT INTO certificado_padrino(idCertificado, idPersona) VALUES ('".$certnum."',".$cipadrino4.")";
            $res=$this->dbh->exequery($q1);
        }
        //        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        $q3="INSERT INTO certificado_beneficiario(idCertificado, idPersona) VALUES (".$certnum.",".$ciesposa.")";
        $res=$this->dbh->exequery($q3);
        $q3="INSERT INTO certificado_beneficiario(idCertificado, idPersona) VALUES (".$certnum.",".$ciesposo.")";
        $res=$this->dbh->exequery($q3);
        //        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        $q="INSERT INTO registro_civil(oficialia, nro_libro, partida, idCertificado) VALUES ('".$oficialia."','".$nro_libro."','".$partida."','".$certnum."')";
        $res=$this->dbh->exequery($q);
    }
    public function reg_confirmacion($cipadrino1,$cipadrino2,$cipersona){
        $q="INSERT INTO certificado(fecha, idParroquia, idSacramento, idLugar,idSacerdote,idCertificante) VALUES ('".$this->fecha."',".$this->parroquia.",3,".$this->lugar.",".$this->sacerdote.",".$this->certificante.")";
        $certnum=$this->dbh->insert($q);
        //        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        if(!empty($cipadrino1))
        {
            $q1= "INSERT INTO certificado_padrino(idCertificado, idPersona) VALUES ('".$certnum."',".$cipadrino1.")";
            $res=$this->dbh->exequery($q1);
        }
        if(!empty($cipadrino2))
        {
            $q1= "INSERT INTO certificado_padrino(idCertificado, idPersona) VALUES ('".$certnum."',".$cipadrino2.")";
            $res=$this->dbh->exequery($q1);
        }
        //        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        $q3="INSERT INTO certificado_beneficiario(idCertificado, idPersona) VALUES (".$certnum.",".$cipersona.")";
        $res=$this->dbh->exequery($q3);
    }

    public function get_bau_info($idp){

        $q="SELECT certificado.idCertificado, certificado.idSacerdote, certificado.idCertificante, certificado.fecha as fechabautizo, parroquia.Nombre as parroquiabautizo, cura.Nombre as nombrecura, cura.Apellido as apellidocura,
        lugar.lugar as lugarnacimiento, cert.Nombre as nombrecertificante,cert.Apellido as apellidocertificante,  fiel.Nombre as nombrefiel, fiel.Apellido as apellidofiel, fiel.fechanac as fechanacimiento,
        padre.Nombre as nombrepadre, padre.Apellido as apellidopadre, madre.Nombre as nombremadre, madre.Apellido as apellidomadre,
        padrino.Nombre as nombrepadrino, padrino.Apellido as apellidopadrino, registro_civil.oficialia, registro_civil.nro_libro as libro, registro_civil.partida
        from certificado, parroquia, persona cura, lugar, persona cert, persona fiel, certificado_beneficiario, persona madre, persona padre, persona padrino, persona_padre ppm, persona_padre ppp, sacerdote sac, sacerdote certificante, registro_civil
        where certificado.idParroquia=parroquia.idParroquia
        and sac.idPersona=cura.idPersona
        and sac.idSacerdote=certificado.idSacerdote
        and certificante.idSacerdote=certificado.idCertificante
        and lugar.idLugar=certificado.idLugar
        and cert.idPersona=certificante.idPersona
        and fiel.idPersona=certificado_beneficiario.idPersona
        and certificado.idCertificado=certificado_beneficiario.idCertificado
        and madre.idPersona=ppm.idPadre
        and fiel.idPersona=ppm.idPersona
        and ppm.tipo='m'
        and padre.idPersona=ppp.idPadre
        and fiel.idPersona=ppp.idPersona
        and ppp.tipo='p'
        and registro_civil.idCertificado=certificado.idCertificado
        and certificado.idSacramento=1
        and fiel.idPersona=".$idp." GROUP BY(certificado.idCertificado)";
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        return $res;
    }

    public function get_comunion_info($idp){


        $q="SELECT certificado.idCertificado, certificado.idSacerdote, certificado.idCertificante, certificado.fecha as fechacomunion, parroquia.Nombre as parroquiacomunion, cura.Nombre as nombrecura, cura.Apellido as apellidocura,
        lugar.lugar as lugarcomunion, cert.Nombre as nombrecertificante,cert.Apellido as apellidocertificante,  fiel.Nombre as nombrefiel, fiel.Apellido as apellidofiel, fiel.fechanac as fechanacimiento,
        padrino.Nombre as nombrepadrino, padrino.Apellido as apellidopadrino
        from certificado, parroquia, persona cura, lugar, persona cert, persona fiel, certificado_beneficiario, persona padrino, sacerdote sac, sacerdote certificante, certificado_padrino
        where certificado.idParroquia=parroquia.idParroquia
        and sac.idPersona=cura.idPersona
        and sac.idSacerdote=certificado.idSacerdote
        and certificante.idSacerdote=certificado.idCertificante
        and lugar.idLugar=certificado.idLugar
        and cert.idPersona=certificante.idPersona
        and fiel.idPersona=certificado_beneficiario.idPersona
        and certificado.idCertificado=certificado_beneficiario.idCertificado
        and certificado.idSacramento=2
        and padrino.idPersona=certificado_padrino.idPersona
        and certificado.idCertificado=certificado_padrino.idCertificado
        and fiel.idPersona=".$idp." GROUP BY(certificado.idCertificado)";
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        return $res;
    }
    
    public function get_matrimonio_info($idp)
    {
        $q="SELECT cer.idCertificado, esposo.idPersona, esposo.Nombre, esposo.Apellido, parroquia.Nombre as parroquiabautizo, papa.Nombre as nombrepapa, papa.Apellido as apellidopapa, mama.Nombre as nombremama, mama.Apellido as apellidomama
            FROM certificado cer, persona esposo, certificado_beneficiario cbm, certificado bautizo, certificado_beneficiario cbb, parroquia, persona papa, persona mama, persona_padre pa, persona_padre ma
            WHERE cer.idSacramento=4
            and cbm.idCertificado=cer.idCertificado
            and cbm.idPersona=esposo.idPersona
            and cer.idCertificado = any(select cb.idCertificado from certificado_beneficiario cb WHERE cb.idPersona=".$idp.")
            and bautizo.idSacramento=1
            and bautizo.idCertificado=cbb.idCertificado
            and cbb.idPersona=esposo.idPersona
            and parroquia.idParroquia=bautizo.idParroquia
            and pa.idPersona=esposo.idPersona
            and ma.idPersona=esposo.idPersona
            and pa.idPadre=papa.idPersona
            and pa.tipo='p'
            and ma.idPadre=mama.idPersona
            and ma.tipo='m'
            GROUP BY esposo.idPersona";
        $res=$this->dbh->exequery($q);
        //if(!$res) die('Invalida query'.mysql_error());
        $todo=array();
        $ar=$this->dbh->fetchrow($res);
        $idcert=$ar['idCertificado'];
        $idesposo=$ar['idPersona'];
        array_push($todo,$ar);
        $ar=$this->dbh->fetchrow($res);
        $idcert=$ar['idCertificado'];
        $idesposo=$ar['idPersona'];
        array_push($todo,$ar);
        $q="SELECT certificado.fecha, cu.Nombre as curanombre, cura.idSacerdote, cert.idSacerdote as idCertificante, cu.Apellido as curaapellido, ce.Nombre as certnombre, ce.Apellido as certapellido, parroquia.Nombre as parroquiamatrimonio, tcu.tipo as tipocura, tce.tipo as tipocert, registro_civil.oficialia, registro_civil.nro_libro, registro_civil.partida
            FROM certificado, parroquia, sacerdote cura, sacerdote cert, persona cu, persona ce, tipo_sacerdote tcu, tipo_sacerdote tce, registro_civil
            WHERE certificado.idParroquia=parroquia.idParroquia
            and cura.idSacerdote=certificado.idSacerdote
            and cert.idSacerdote=certificado.idCertificante
            and ce.idPersona=cert.idPersona
            and cu.idPersona=cura.idPersona
            and cura.idtipo_sacerdote=tcu.idtipo_sacerdote
            and cert.idtipo_sacerdote=tce.idtipo_sacerdote
            and registro_civil.idCertificado=certificado.idCertificado
            and certificado.idCertificado=".$idcert;
        $res=$this->dbh->exequery($q);
       // echo $idcert;
        $ar=$this->dbh->fetchrow($res);
        array_push($todo,$ar);
        return $todo;
    }

    public function get_confir_info($idp){


        $q="SELECT certificado.idCertificado, certificado.fecha, parroquia.Nombre as parroquia, cura.Nombre as nombrecura, cura.Apellido as apellidocura, lugar.lugar, cert.Nombre as nombrecertificante,cert.Apellido as apellidocertificante,  fiel.Nombre as nombrefiel, fiel.Apellido as apellidofiel, padrino.Nombre as nombrepadrino, padrino.Apellido as apellidopadrino, ts.tipo as tipocura, tc.tipo as tipocert
        from certificado, parroquia, persona cura, lugar, persona cert, persona fiel, certificado_beneficiario, persona padrino, sacerdote sac, sacerdote certificante, certificado_padrino, tipo_sacerdote ts, tipo_sacerdote tc
        where certificado.idParroquia=parroquia.idParroquia
        and sac.idPersona=cura.idPersona
        and sac.idSacerdote=certificado.idSacerdote
        and certificante.idSacerdote=certificado.idCertificante
        and lugar.idLugar=certificado.idLugar
        and cert.idPersona=certificante.idPersona
        and fiel.idPersona=certificado_beneficiario.idPersona
        and certificado.idCertificado=certificado_beneficiario.idCertificado
        and certificado.idSacramento=3
        and padrino.idPersona=certificado_padrino.idPersona
        and certificado.idCertificado=certificado_padrino.idCertificado
        and sac.idtipo_sacerdote=ts.idtipo_sacerdote
        and certificante.idtipo_sacerdote=tc.idtipo_sacerdote
        and fiel.idPersona=".$idp." GROUP BY(certificado.idCertificado)";
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        $res=$this->dbh->fetchrow($res);
        return $res;
    }

    public function get_sacramentos(){
        $q="SELECT * from sacramento";
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        return $res;
    }

    public function getcert($ci,$sac){
        $q="SELECT cer.idCertificado, cer.fecha, pa.Nombre as parroquia, concat(concat(ps.Nombre,' '),ps.Apellido) as parroco, sac.Nombre as sacramento, l.lugar, concat(concat(fiel.Nombre,' '),fiel.Apellido) as fiel, fiel.CI , fiel.idPersona,sac.idSacramento,pa.idParroquia
        FROM certificado cer, parroquia pa, sacerdote sa, sacramento sac, persona ps, persona fiel, certificado_beneficiario cb, lugar l 
        WHERE cer.idParroquia=pa.idParroquia
        and cer.idSacerdote=sa.idSacerdote
        and cer.idSacramento=sac.idSacramento
        and cer.idLugar=l.idLugar
        and ps.idPersona=sa.idPersona
        and cb.idCertificado=cer.idCertificado
        and cb.idPersona=fiel.idPersona
        and cer.idSacramento=".$sac." and fiel.CI=".$ci;
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        return $res;
    }

    public function getcerthijos($ci,$sac){
        $q="SELECT cer.idCertificado, cer.fecha, pa.Nombre as parroquia, concat(concat(ps.Nombre,' '),ps.Apellido) as parroco, sac.Nombre as sacramento, l.lugar, concat(concat(hijo.Nombre,' '),hijo.Apellido) as hijo, hijo.CI, hijo.idPersona,sac.idSacramento,pa.idParroquia
        FROM certificado cer, parroquia pa, sacerdote sa, sacramento sac, persona ps, persona fiel, certificado_beneficiario cb, lugar l, persona_padre, persona hijo
        WHERE cer.idParroquia=pa.idParroquia
        and cer.idSacerdote=sa.idSacerdote
        and cer.idSacramento=sac.idSacramento
        and cer.idLugar=l.idLugar
        and ps.idPersona=sa.idPersona
        and cb.idCertificado=cer.idCertificado
        and persona_padre.idPadre=fiel.idPersona
        and cb.idPersona=hijo.idPersona
        and persona_padre.idPersona= hijo.idPersona
        and fiel.ci=".$ci. " and cer.idSacramento=".$sac;
        $res=$this->dbh->exequery($q);
        if ($this->dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $this->dbh->mysqli->error);
        }
        return $res;
    }

}
//$as=new certificado("","",'','','');
//print_r($as->get_matrimonio_info(16));
//echo "<br>";
?>