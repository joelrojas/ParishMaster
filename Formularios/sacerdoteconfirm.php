<?php
/**
 * Created by PhpStorm.
 * User: Pamela
 * Date: 9/4/2016
 * Time: 12:58 PM
 */
require_once '../clases/persona.php';
require_once '../clases/sacerdote.php';

$per = new persona($_POST["ci"],$_POST['nombre'],$_POST['apellido'],$_POST['fechanac'],1,$_POST['email'],$_POST['password']);
$res=$per->buscarper($_POST["ci"]);
if(mysql_num_rows($res)==1){
    $fila=mysql_fetch_array($res);
    $per->regcuenta($fila['idPersona']);
    $sac= new sacerdote($fila['idPersona'], $_POST['tiposac'], $_POST['parroquia']);
    $sac->reg();
}
else{
    $idpersona=$per->registrar();
    $per->regcuenta($idpersona);
    $sac= new sacerdote($idpersona, $_POST['tiposac'], $_POST['parroquia']);
    $sac->reg();
}




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
        <h1>Su cuenta ha sido creada exitosamente!</h1>
        <p>Ahora puede ingresar a su cuenta.</p>
        <p><a class="btn btn-primary btn-lg" href="../Formularios/login" role="button">Login</a></p>
    </div>
</div>



<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Bootstrap javascript -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>