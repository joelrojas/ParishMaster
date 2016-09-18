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

?>
<div class="container">
    <div class="page-header">
        <h1>Reimpresion de Certificados <small>Sacramentos</small></h1>
    </div>
    <form action="reqreimp.php" method="post">


        <div class="form-group">
            <label for="ci">CI:</label>
            <input value="<?php echo $_SESSION['ci']; ?>" disabled type="text" required pattern ='^\d+$' title='Ingrese solo el numero de CI, sin letras' maxlength="10" class="form-control" id="ci" name="ci">
        </div>
        <div class="form-group">
            <label for="sacramento">Sacramento:</label>
            <select class="form-control" name="sacramento" required>
                <option value="">Escoja una sacramento</option>
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
        <button type="submit" class="btn btn-primary" name="yo">Reimprimir mi certificado</button>
        <button type="submit" class="btn btn-default" name="hijos">Reimprimir certificado hijos</button>
    </form>
    <hr>

    <?php
    if(!empty($_POST)){
        $ce= new certificado("","","","","");
        if(isset($_POST['yo'])){
            $fila=$ce->getcert($_SESSION['ci'],$_POST['sacramento']);
            $cer=$fila->fetch_array(MYSQLI_ASSOC);
            if(!empty($cer['CI'])){
                echo ' <div class="panel panel-success">
                                        <div class="panel-heading">Certificados Encontrados</div>
                                        <div class="panel-body">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>CI</th>
                                                    <th>Fiel</th>
                                                    <th>Sacramento</th>
                                                    <th>Lugar</th>
                                                    <th>Fecha</th>
                                                    <th>Parroquia</th>
                                                    <th>Sacerdote</th>
                                                    <th>Reimpresion</th>
                                
                                                </tr>
                                                </thead>
                                                <tbody>';
                echo "<tr>";
                echo "<td>".$cer['CI']."</td>";
                echo "<td>".$cer['fiel']."</td>";
                echo "<td>".$cer['sacramento']."</td>";
                echo "<td>".$cer['lugar']."</td>";
                echo "<td>".$cer['fecha']."</td>";
                echo "<td>".$cer['parroquia']."</td>";
                echo "<td>".$cer['parroco']."</td>";
                echo '<form action="reqreimpconfirm.php" method="post">';
                echo '<input type="hidden" name="idPersona" value="'.$cer['idPersona'].'">';
                echo '<input type="hidden" name="idSacramento" value="' . $cer['idSacramento'] . '">';
                echo '<input type="hidden" name="idParroquia" value="' . $cer['idParroquia'] . '">';
                echo '<td><button type="submit" class="btn btn-primary " name="enviar" value="">Solicitar</button></td>';
                echo '</form>';
                echo "</tr>";
                echo '</div></div>';
                echo ' </tbody></table>';
            }
            else{
                echo '<div class="panel panel-danger">
                                        <div class="panel-heading">Certificados No Encontrados</div>
                                        <div class="panel-body">
                                        </div>
                                  </div>';
            }

        }
        else if(isset($_POST['hijos'])) {
            $fila = $ce->getcerthijos($_SESSION['ci'], $_POST['sacramento']);
            if ($fila!=null) {
                echo ' <div class="panel panel-success">
                                        <div class="panel-heading">Certificados Encontrados</div>
                                        <div class="panel-body">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>CI</th>
                                                    <th>Fiel</th>
                                                    <th>Sacramento</th>
                                                    <th>Lugar</th>
                                                    <th>Fecha</th>
                                                    <th>Parroquia</th>
                                                    <th>Sacerdote</th>
                                                    <th>Reimpresion</th>
                                
                                                </tr>
                                                </thead>
                                                <tbody>';
                while ($cer = $fila->fetch_array(MYSQLI_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $cer['CI'] . "</td>";
                    echo "<td>" . $cer['hijo'] . "</td>";
                    echo "<td>" . $cer['sacramento'] . "</td>";
                    echo "<td>" . $cer['lugar'] . "</td>";
                    echo "<td>" . $cer['fecha'] . "</td>";
                    echo "<td>" . $cer['parroquia'] . "</td>";
                    echo "<td>" . $cer['parroco'] . "</td>";
                    echo '<form action="reqreimpconfirm.php" method="post">';
                    echo '<input type="hidden" name="idPersona" value="' . $cer['idPersona'] . '">';
                    echo '<input type="hidden" name="idSacramento" value="' . $cer['idSacramento'] . '">';
                    echo '<input type="hidden" name="idParroquia" value="' . $cer['idParroquia'] . '">';
                    echo '<td><button type="submit" class="btn btn-primary " name="enviar" value="">Solicitar</button></td>';
                    echo '</form>';
                    echo "</tr>";
                }
                echo ' </tbody></table>';
                echo '</div></div>';
            }
            else{
                echo '<div class="panel panel-danger">
                                        <div class="panel-heading">Certificados No Encontrados</div>
                                        <div class="panel-body">
                                        </div>
                                  </div>';
            }
        }
    }
    ?>
</div>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Bootstrap javascript -->
<script src="../bootstrap/js/bootstrap.min.js"></script>

</body>
</html>




