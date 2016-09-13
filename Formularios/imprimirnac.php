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
require_once "../clases/sacerdote.php";

$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");


$mpdf= new mPDF('c','Letter');
$css= file_get_contents('../Certificados/Nacimiento/nac.css');

$c= new certificado('',"","","","");
$res=$c->get_bau_info($_SESSION['idPersona']);
$fila=$res->fetch_array(MYSQLI_ASSOC);
$res2= new sacerdote("", '', "");
$tiposac=$res2->gettipo($fila['idSacerdote']);
$tipocert=$res2->gettipo($fila['idCertificante']);
$dte=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;



$html= "<html><head>
    <title>Bautizo</title>
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
            </b><h4 class='text-left' contenteditable='true'><b>CERTIFICADO DE BAUTISMO</b></h4> <br>
            <h4 contenteditable='true' class='text-center'><b>ARQUIDIOCESIS DE NUESTRA SEÑORA DE LA PAZ - BOLIVIA</b></h4> <br>
            <h4 class='text-center'><b> ".strtoupper($fila['parroquiabautizo'])."</b></h4>
            <br><br>
            <p class='text-center cert'>El ".$tiposac." ".$fila['nombrecertificante']." ".$fila['apellidocertificante']." "." &nbsp;de la ".$fila['parroquiabautizo']." CCERTIFICA que:
              <br>El ".$fila['fechabautizo']." &nbsp;en esta Iglesia Parroquial el ".$tiposac." ".$fila['nombrecura']." ".$fila['apellidocura']." bautizo
              a:
              <br>
              <br>".$fila['nombrefiel']." ".$fila['apellidofiel']."
              <br>
              <br>Nacido/a en ".$fila['lugarnacimiento'].', '.$fila['parroquiabautizo']."
              el ".$fila['fechanacimiento'].".
              <br>Hijo/a legitima de ".$fila['nombrepadre'].' '.$fila['apellidopadre']." y ".$fila['nombremadre'].' '.$fila['apellidomadre'].".
              <br>Fue padrino/madrina ".$fila['nombrepadrino'].' '.$fila['apellidopadrino']." a quien es adverti el parentesco espiritual contraido
              <br>Oficialia del Registro Civil Nro ".$fila['oficialia']." Libro Nro ".$fila['libro']." Partida Nro ".$fila['partida']."
              <br>Certifico: ".$tiposac." ".$fila['nombrecertificante']." ".$fila['apellidocertificante']."</p>
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
            <p class='text-center cert '> ".$tiposac." ".$fila['nombrecertificante']." ".$fila['apellidocertificante']."</p>
            <img src='C:\Users\Pamela\Downloads\Wikipedia_mobile_en.svg.png' class='img-responsive asd'>
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