<?php
/**
 * Created by PhpStorm.
 * User: Pamela
 * Date: 9/5/2016
 * Time: 11:02 AM
 */

session_start();

require_once '../clases/certificado.php';
require_once '../clases/persona.php';

$per = new persona($_POST['ci'], $_POST['nombre'],$_POST['apellido'], $_POST['fechanac'], "", "", "");
$p=$per->buscarper($_POST['ci']);
$fila= mysql_fetch_array($p);
$pid=$fila['idPersona'];
$padrinoid=$per->idfromci($_POST['cipadrino']);

$cert = new certificado($_POST['parroquia'],$_POST['sacerdote'],$_POST['certificante'],$_POST['lugar'],$_POST['fechacom']);
$cert->reg_comunion($padrinoid , $pid);

$_SESSION['idPersona']=$pid;

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
        <h1>El certificado fue creado exitosamente!</h1>
        <p><a class='btn btn-primary btn-lg' href='imprimircomun.php' role='button'>Imprimir</a></p>
        <p><a class='btn btn-primary btn-lg' href='../Principal/principal.php' role='button'>Volver al Menu</a></p>
    </div>
</div>



<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Bootstrap javascript -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>