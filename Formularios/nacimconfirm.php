<?php
/**
 * Created by PhpStorm.
 * User: Pamela
 * Date: 9/4/2016
 * Time: 8:20 PM
 */
session_start();
require_once '../clases/certificado.php';
echo $_POST['lugar'];
$cer = new certificado($_POST['parroquia'],$_POST['sacerdote'],$_POST['certificante'],$_POST['lugar'],$_POST['fechabau']);
$cerid=$cer->reg_bautizo($_POST['nombre'],$_POST['apellido'],$_POST['fechanac'],$_POST['cipadrino'],$_POST['cipadre'],$_POST['cimadre'],$_SESSION['ci']);
$cer->addregciv($_POST['oficialia'], $_POST['libro'], $_POST['partida'], $cerid);



?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

</head>
<body>
<div class="container">
    <div class="jumbotron">
        <h1>Su certificado fue creado exitosamente!</h1>
        <p>Ahora puede pasar por la parroquia mas cercana y reclamar su certificado.</p>
        <p><a class="btn btn-primary btn-lg" href="../Principal/principal.html" role="button">Inicio</a></p>
    </div>
</div>



<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Bootstrap javascript -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>