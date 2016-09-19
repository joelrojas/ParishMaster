<?php
/**
 * Created by PhpStorm.
 * User: Pamela
 * Date: 9/17/2016
 * Time: 10:32 PM
 */

    require_once "../clases/request.php";
    $req= new request();
    $req->createreimpreq($_POST['idPersona'],$_POST['idSacramento'],$_POST['idParroquia']);

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
        <h1>Se ha enviado su solicitud!</h1>
        <p>Se le notificara por email cuando la hayamos atendido.</p>
        <p><a class='btn btn-primary btn-lg' href='../Principal/principalfiel.php' role='button'>Volver al Menu</a></p>
    </div>
</div>



<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Bootstrap javascript -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>

