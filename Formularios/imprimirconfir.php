<?php
/**
 * Created by PhpStorm.
 * User: Pamela
 * Date: 9/5/2016
 * Time: 3:34 PM
 */

session_start();

require_once "../mpdf2/mpdf.php";
require_once "../clases/certificado.php";
require_once "../clases/imprimirQR.php";

$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");


$mpdf= new mPDF('c','Letter');
$css= file_get_contents('../Certificados/Nacimiento/nac.css');

$c= new certificado('',"","","","");
//$_SESSION['idPersona']=16;
$fila=$c->get_confir_info($_SESSION['idPersona']);
//$res2= new sacerdote("", '', "");
//$tiposac=$res2->gettipo($fila[2]['idSacerdote']);
//$tipocert=$res2->gettipo($fila[2]['idCertificante']);
$dte=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
$qr=new QR();


$html= "<html><head>
    <title>Matrimonio</title>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <script type='text/javascript' src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js'></script>
    <script type='text/javascript' src='http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js'></script>
    <link href='http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
    <link href='nac.css' rel='stylesheet' type='text/css'>
  </head><body>
    <div class='section'>
      <div class='container'>
        <div class='row'>
          <div class='col-md-12'>
            </b><h4 class='text-left' contenteditable='true'><b>CERTIFICADO DE MATRIMONIO</b></h4> <br>
            <h4 contenteditable='true' class='text-center'><b>ARQUIDIOCESIS DE NUESTRA SEÑORA DE LA PAZ - BOLIVIA</b></h4> <br>
            <h4 class='text-center'><b> ".strtoupper($fila['parroquia'])."</b></h4>
            <br><br>
            <p class='text-justify cert'>El ".$fila['tipocert']." ".$fila['nombrecertificante']." ".$fila['apellidocertificante']." "." &nbsp;de la ".$fila['parroquia']." CERTIFICA que:
              <br>
              <br>En esta iglesia parroquial el ".$fila['fecha']." el ".$fila['tipocura']." ".$fila['nombrecura']." ".$fila['apellidocura'].", celebro la misa de confirmacion de,
              <br>
              ".strtoupper($fila['nombrefiel'])." ".strtoupper($fila['apellidofiel'])." 
               fue Padrino 
               ".strtoupper($fila['nombrepadrino'])." ".strtoupper($fila['apellidopadrino'])." 
              <br>
              
              <br>
              <br>Certifico: ".$fila['tipocert']." ".$fila['nombrecertificante']." ".$fila['apellidocertificante']."</p>
          </div>
        </div>
        <div class='row'>
          <div class='col-md-12'>
            <br>
            <p class='cert'>La Paz ".$dte."</p>
            <br>
          </div>
        </div>
      </div>
    </div>
    <div class='section'>
      <div class='container'>
        <div class='row'>
          <div class='col-md-7'>
            <p class='text-center cert' contenteditable='true'>
             --------------------------------------------------------------</p>
            <p class='text-center cert '> ".$fila['tipocert']." ".$fila['nombrecertificante']." ".$fila['apellidocertificante']."</p>
            ".$qr->crea($fila['idCertificado'])."
            <hr>
          </div>
        </div>
      </div>
    </div>

  

</body></html>";
$mpdf->writeHTML($css,1);
$mpdf->writeHTML($html);
$mpdf->Output("reporte.pdf",'I');




?>