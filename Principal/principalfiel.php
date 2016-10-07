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
    require_once "../general/headerfiel.php";
?>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Bienvenido al modulo del fiel</h1>
                <p class="text-center"> Realice solicitudes de reimpresion y de digitalizacion de sus certificados </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <a href="../Formularios/reqreimp.php"> <img src="../img/printer.png" class="center-block img-circle img-responsive"></a>
            </div>
            <div class="col-md-4">
                <h3 class="text-left"> Solicitud de copia</h3>
                <p class="text-left">Solicite una copia de un certificado registrado anteriormente.</p>
            </div>
            <div class="col-md-2">
                <a href="../Formularios/reqesp.php"> <img src="../img/documents.png" class="center-block img-circle img-responsive"></a>
            </div>
            <div class="col-md-4">
                <h3 class="text-left">Solicitud especial</h3>
                <p class="text-left">Si su certificado es antiguo y no esta en el sistema, solicite uno aqui.</p>
            </div>
        </div>
    </div>
</div>


</body></html>