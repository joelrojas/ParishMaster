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
?>
<div class="container">
    <div class="page-header">
        <h1>Registro de Sacerdotes
        </h1>
    </div>
    <form action="sacerdoteconfirm.php" method="post">

        <h2>Informacion Personal:</h2>

        <div class="form-group">
            <label for="ci">CI:</label>
            <input type="text" class="form-control" id="ci" name="ci">
        </div>

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

        <hr>

        <h2>Informacion de Sacerdote:</h2>

        <div class="form-group">
            <label for="parroquia">Parroquia:</label>
            <select class="form-control" name="parroquia">
                <option value="">Escoja una parroquia</option>
                <?php
                $parr= new parroquia(1,"aa");
                $parrs=$parr->GetAll();
                while($fila=mysql_fetch_array($parrs)){
                    echo "<option value='".$fila['idParroquia']."'>".$fila['Nombre']."</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="tiposac">Tipos de Sacerdote</label>
            <select class="form-control" name="tiposac">
                <option value="">Escoja un tipo</option>
                <?php
                $sac = new sacerdote("", "", "");
                $res= $sac->getTipos();
                while($fila=mysql_fetch_array($res)){
                    echo "<option value='".$fila['idtipo_sacerdote']."'>".$fila['tipo']."</option>";
                }
                ?>
            </select>
        </div>

        <hr>

        <h2> Informacion de la cuenta: </h2>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" name="email">
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