<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap css -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

    <title>Registro</title>
</head>
<body>
<?php
require_once '../clases/parroquia.php';
require_once '../clases/sacerdote.php';
require_once '../clases/Lugar.php';
?>
<div class="container">
    <div class="page-header">
        <h1>Registro de Usuarios
        </h1>
    </div>
    <form action="regconfirm.php" method="post">

        <h2>Informacion Personal:</h2>

        <div class="form-group">
            <label for="ci">CI:</label>
            <input  type="text"  required pattern ='^\d+$' title='Ingrese solo el numero de CI, sin letras' maxlength="10" class="form-control" id="ci" name="ci">
        </div>

        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" required pattern='^([ \u00c0-\u01ffa-zA-Z\-])+$' title='Ingrese sólo letras' class="form-control" id="nombre" name="nombre">
        </div>
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" required pattern='^([ \u00c0-\u01ffa-zA-Z\-])+$' title='Ingrese sólo letras' class="form-control" id="apellido" name="apellido">
        </div>
        <div class="form-group">
            <label for="fechanac">Fecha Nacimiento:</label>
            <input type="date" required class="form-control" id="fechanac" name="fechanac">
        </div>
        <div class="form-group">
            <label for="genro">Genero:</label>
            <select class="form-control" name="genero" required >
                <option value="1">Masculino</option>
                <option value="2">Femenino</option>
            </select>
        </div>

        <hr>

        <h2> Informacion de la cuenta: </h2>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Ingrese un email valido, ejemplo nombre@gmail.com" class="form-control" id="email" name="email">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" required class="form-control" id="password" name="password">
        </div>

        <button type="submit" class="btn btn-default">Registrar</button>
    </form>


</div>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Bootstrap javascript -->
<script src="../bootstrap/js/bootstrap.min.js"></script>

</body>
</html>