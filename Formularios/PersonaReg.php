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

        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre">
        </div>
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" class="form-control" id="apellido" name="apellido">
        </div>
        <div class="form-group">
            <label for="fechanac">Fecha Nacimiento:</label>
            <input type="date" class="form-control" id="fechanac" name="fechanac">
        </div>
        <div class="form-group">
            <label for="genro">Genero:</label>
            <select class="form-control" name="genero">
                <option value="1">Masculino</option>
                <option value="2">Femenino</option>
            </select>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" name="email">
        </div>


        <div class="form-group">
            <label for="ci">CI:</label>
            <input type="text" class="form-control" id="ci" name="ci">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password">
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