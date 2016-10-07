<?php

    require_once "../general/headersac.php";

    require_once "../clases/persona.php";
    require_once '../clases/Lugar.php';
    require_once '../clases/parroquia.php';

    session_start();
    $mailexitoso=false;
    $nadie=false;

    $lug="";
    $fecha="";
    $parr="";
    $pf="";
    $edmin="";
    $edmax="";

    $parrsac="";

    if(!empty($_POST['bau']) )$bau=$_POST['bau'];
    if(!empty($_POST['confir'])) $confir=$_POST['confir'];
    if(!empty($_POST['matri'])) $matri=$_POST['matri'];
    if(!empty($_POST['sac'])) $sac=$_POST['sac'];
    if(!empty($_POST['pc'])) $pc=$_POST['pc'];



    //if(empty($_POST['bau']) && empty($_POST['confir']) && empty($_POST['matri']) && empty($_POST['sac']) && empty($_POST['pc']) && !empty($_POST))
        //$nadie=true;

    if(!empty($_POST['asunto']) && !empty($_POST['mensaje'])){
        $asunto=$_POST['asunto'];
        $mensaje=$_POST['mensaje'];
    }

    if(!empty($_POST)){ //&& !$nadie){

        $p = new persona("", "", "", "", "", "", "");

        if(!empty($_POST['lugar']))$lug=$_POST['lugar'];
        if(!empty($_POST['fecha']))$fecha=$_POST['fecha'];
        if(!empty($_POST['parroquia']))$parr=$_POST['parroquia'];
        if(!empty($_POST['padres']))$pf=$_POST['padres'];
        if(!empty($_POST['edadmin']))$edmin=$_POST['edadmin'];
        if(!empty($_POST['edadmax']))$edmax=$_POST['edadmax'];
        if(!empty($_POST['parroquiasac'])) $parrsac=$_POST['parroquiasac'];


        $para="";

        if($bau=="si"){
            $cont=1;
            $res=$p->GetEmailsSac(1,$lug,$fecha,$parr,$pf, $edmin,$edmax);
            while($fila=$res->fetch_array(MYSQLI_ASSOC)) {
                if($cont==1) $para=$fila['email'];
                else $para=$para.",".$fila['email'];
                $cont++;
            }
        }

        if($pc=="si"){
            $cont=1;
            $res=$p->GetEmailsSac(2,$lug,$fecha,$parr,$pf, $edmin,$edmax);
            while($fila=$res->fetch_array(MYSQLI_ASSOC)) {
                if($cont==1) $para=$fila['email'];
                else $para=$para.",".$fila['email'];
                $cont++;
            }
        }

        if($confir=="si"){
            $cont=1;
            $res=$p->GetEmailsSac(3,$lug,$fecha,$parr,$pf, $edmin,$edmax);
            while($fila=$res->fetch_array(MYSQLI_ASSOC)) {
                if($cont==1) $para=$fila['email'];
                else $para=$para.",".$fila['email'];
                $cont++;
            }
        }

        if($matri=="si"){
            $cont=1;
            $res=$p->GetEmailsSac(4,$lug,$fecha,$parr,$pf, $edmin,$edmax);
            while($fila=$res->fetch_array(MYSQLI_ASSOC)) {
                if($cont==1) $para=$fila['email'];
                else $para=$para.",".$fila['email'];
                $cont++;
            }
        }

        if($sac=="si"){
            $cont=1;
            $res=$p->GetEmailsSacerdotes($parrsac);
            while($fila=$res->fetch_array(MYSQLI_ASSOC)) {
                if($cont==1) $para=$fila['email'];
                else $para=$para.",".$fila['email'];
                $cont++;
            }
        }





        $sacpuesto=$p->GetInfoSac($_SESSION['idPersona']);
        $pues=$sacpuesto->fetch_array(MYSQLI_ASSOC);

        $mensaje.="

        Saludos
        ".$pues['tipo']." ".$_SESSION['nombre']." ".$_SESSION['apellido'];

        $meil="contacto@parishmaster.gwiddle.co.uk";
        if( strpos($_SESSION['email'], '@parishmaster.gwiddle.co.uk') !== false) $meil=$_SESSION['email'];

        $headers = 'From:'. $pues['tipo']." ".$_SESSION['nombre']." ".$_SESSION['apellido'].' <'.$meil.'>'. "\r\n" .
            'Reply-To:'. $pues['tipo']." ".$_SESSION['nombre']." ".$_SESSION['apellido'].' <'.$meil.'>' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        //Dobrescribimos el email para probar y no spamear XD
        $para="i.pfp94@gmail.com";

        if(!empty($_POST['cc']) ){
            $cc=$_POST['cc'];
            $para=$para.",".$cc;
        }


        mail($para, $asunto, $mensaje, $headers);
        $mailexitoso=true;
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
<div class="container" >
    <div class="container" style="max-width: 500px">
        <?php

            if($mailexitoso) echo '<div class="alert alert-success" role="alert"<strong>Exito!</strong> Su mail ha sido enviado exitosamente!</div>';
            if($nadie) echo '<div class="alert alert-danger" role="alert"><strong>Error!</strong> Debe marcar por lo menos un receptor! </div>'
        ?>
        <div class="page-header">
            <h1>Envio de Emails <small>A grupos focales</small></h1>
        </div>
        <form action="mandadoremails.php" method="post">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Informacion del Mail</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="asunto">Asunto:</label>
                        <input value="" required type="text" class="form-control" id="asunto" name="asunto">
                    </div>
                    <div class="form-group">
                        <label for="cc">CC:</label>
                        <input placeholder="Ingrese los emails a los que desea reenviar una copia de este email separados por comas" value="" type="text" class="form-control" id="cc" name="cc">
                    </div>
                    <div class="form-group">
                        <label for="mensaje">Mensaje:</label>
                        <textarea required style="max-width: 100%; max-height: 100%; height: 200px;" value="" required type="text" class="form-control" id="mensaje" name="mensaje"></textarea>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Opciones de envio - Grupos Focales - Sacramentos</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="checkbox-inline"><input type="checkbox" value="si" name="bau">Bautizados</label>
                        <label class="checkbox-inline"><input type="checkbox" value="si" name="pc">Con Primera Comunion</label>
                        <label class="checkbox-inline"><input type="checkbox" value="si" name="confir">Confirmados</label>
                        <label class="checkbox-inline"><input type="checkbox" value="si" name="matri">Casados</label>
                        <br> <br>
                        <div class="form-group">
                            <label for="lugar">Lugar de realizacion de sacramento:</label>
                            <select class="form-control" name="lugar">
                                <option value="">Todos</option>
                                <?php
                                $lug= new Lugar();
                                $lugs=$lug->GetAll();
                                while($fila2=$lugs->fetch_array(MYSQLI_ASSOC)){
                                    echo "<option value='".$fila2['idLugar']."'";
                                    if(isset($_POST['lugar']))
                                        if($_POST['lugar'] == $fila2['idLugar'])
                                            echo("selected");
                                    echo ">".$fila2['lugar']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha de realizacion del Sacramento:</label>
                            <input type="date" value="<?php if(isset($_POST['fecha'])) echo $_POST['fecha']; ?>"  class="form-control" id="fecha" name="fecha">
                        </div>

                        <div class="form-group">
                            <label for="parroquia">Parroquia donde se realizo el Sacramento:</label>
                            <select class="form-control" name="parroquia" >
                                <option value="">Cualquiera</option>
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

                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Opciones de envio - Grupos Focales - Otros</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="checkbox-inline"><input type="checkbox" value="si" name="padres">Padres de Familia</label>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Opciones de envio - Grupos Focales - Sacerdotes</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">

                        <div class="form-group">
                            <label class="checkbox-inline"><input type="checkbox" value="si" name="sac">Sacerdotes</label>
                        </div>
                        <div class="form-group">
                            <label for="parroquiasac">Parroquia a la que pertenecen:</label>
                            <select class="form-control" name="parroquiasac" >
                                <option value="">Cualquiera</option>
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
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Opciones de envio - Datos Personales</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="edadmin">Edad Minima:</label>
                            <input  value="" placeholder="0"  type="text" class="form-control" id="edadmin" name="edadmin"></input>
                        </div>
                        <div class="form-group">
                            <label for="edadmax">Edad Maxima:</label>
                            <input  value="" placeholder="99" type="text" class="form-control" id="edadmax" name="edadmax"></input>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success btn-lg btn-block">Enviar</button>
        </form>

    </div>



<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Bootstrap javascript -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>