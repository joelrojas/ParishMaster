
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap css -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

    <title>Document</title>
</head>
<body>
<?php
    session_start();
    require_once "../general/headerfiel.php";

    require_once "../clases/certificado.php";
    require_once "../clases/parroquia.php";
    require_once "../clases/request.php";
    require_once "../clases/persona.php";

    if(!empty($_POST)){
        $per= new persona("","","","","","","");
        $idp=$_SESSION['idPersona'];
        $req= new request();
        $req->createrequesp($idp, $_POST['sacramento'], $_POST['mensaje'], $_POST['libro'], $_POST['pagina'], $_POST['numero'], $_POST['parroquia']);
        echo "<div class='alert alert-success'><strong>Exito!</strong> La solicitud ha sido creada! Se le notificara por email cuando se la atienda.</div>";
    }


?>
<div class="container">
    <div class="page-header">
        <h1>Solicitudes especiales <small>Digitalizacion de certificados</small></h1>
    </div>
    <form action="reqesp.php" method="post">

        <div class="panel panel-default">
            <div class="panel-heading">Informacion Personal</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="ci">CI:</label>
                    <input value="<?php echo $_SESSION['ci']; ?>" disabled type="text" required pattern ='^\d+$' title='Ingrese solo el numero de CI, sin letras' maxlength="10" class="form-control" id="ci" name="ci">
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Informacion Antiguo Certificado</div>
            <div class="panel-body">

                <div class="form-group">

                    <label for="parroquia">Parroquia:</label>
                    <select class="form-control" name="parroquia" required>
                        <option value="">Escoja una parroquia</option>
                        <?php
                        $parr= new parroquia(1,"aa");
                        $parrs=$parr->GetAll();
                        while($fila=$parrs->fetch_array(MYSQLI_ASSOC)){
                            echo "<option value='".$fila['idParroquia']."'";
                            if(isset($_POST['parroquia']))
                                if($_POST['parroquia'] == $fila['idParroquia'])
                                    echo("selected");
                            echo ">".$fila['Nombre']."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="libro">Libro:</label>
                    <input type="text" value="<?php if(isset($_POST['libro'])) echo $_POST['libro']; ?>" required maxlength="10" class="form-control" id="libro" name="libro">
                </div>
                <div class="form-group">
                    <label for="pagina">Pagina:</label>
                    <input type="text" value="<?php if(isset($_POST['pagina'])) echo $_POST['pagina']; ?>"  required pattern ='^\d+$' title='Ingrese solo numeros' maxlength="10" class="form-control" id="partida" name="pagina">
                </div>
                <div class="form-group">
                    <label for="numero">Numero:</label>
                    <input type="text" value="<?php if(isset($_POST['numero'])) echo $_POST['numero']; ?>"  required pattern ='^\d+$' title='Ingrese solo numeros' maxlength="10" class="form-control" id="numero" name="numero">
                </div>
                <div class="form-group">
                    <label for="sacramento">Sacramento:</label>
                    <select class="form-control" name="sacramento" required>
                        <option value="">Escoja un sacramento</option>
                        <?php
                        $cert= new certificado("","","","","");
                        $res=$cert->get_sacramentos();
                        while($fila=$res->fetch_array(MYSQLI_ASSOC)){
                            echo "<option value='".$fila['idSacramento']."'";
                            if(isset($_POST['sacramento']))
                                if($_POST['sacramento'] == $fila['idSacramento'])
                                    echo("selected");
                            echo ">".$fila['Nombre']."</option>";
                        }
                        ?>
                    </select>
                </div>

            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Informacion Extra</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="mensaje">Aclaraciones:</label>
                    <textarea style="max-width: 100%; max-height: 100%; height: 200px;" value="" required type="text" class="form-control" id="mensaje" name="mensaje"></textarea>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" name="yo">Solicitud</button>
    </form>
    <hr>

</div>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Bootstrap javascript -->
<script src="../bootstrap/js/bootstrap.min.js"></script>

</body>
</html>