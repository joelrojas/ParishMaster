<html><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="principal.css" rel="stylesheet" type="text/css">
  </head>
<body>

<?php 

require_once "../general/headersac.php"

?>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-center">Sacramentos</h1>
            <p class="text-center">Registre el sacramento que necesite y recoja su certificado en la parroquia
              mas cercana</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2">
            <a href="../Formularios/NacimientoReg.php"> <img src="img/b.png" class="center-block img-circle img-responsive"></a>
          </div>
          <div class="col-md-4">
             <h3 class="text-left">Bautizo</h3>
            <p class="text-left">El primer sacramento que nos inicia en nuestra vida como catolicos.</p>
          </div>
          <div class="col-md-2">
            <a href="../Formularios/Confirmacion.php"> <img src="img/c.png" class="center-block img-circle img-responsive"></a>
          </div>
          <div class="col-md-4">
            <h3 class="text-left">Confirmacion</h3>
            <p class="text-left">La confirmacion de nuestra fe catolica.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2">
            <a href="../Formularios/ComunionReg.php"><img src="img/pc.png" class="center-block img-circle img-responsive"></a>
          </div>
          <div class="col-md-4">
            <h3 class="text-left">Primera Comunion</h3>
            <p class="text-left">La primera vez que recibimos el cuerpo de Dios.</p>
          </div>
          <div class="col-md-2">
            <a href="../Formularios/Matrimonio.php"> <img src="img/m.png" class="center-block img-circle img-responsive"></a>
          </div>
          <div class="col-md-4 text-center">
            <h3 class="text-left">Matrimonio</h3>
            <p class="text-left">La union entre dos catolicos segun dicta la ley de Dios.</p>
          </div>
        </div>
      </div>
    </div>
  

</body></html>