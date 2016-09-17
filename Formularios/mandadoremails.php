<?php

    require_once "../clases/persona.php";

    session_start();
    $mailexitoso=false;
    $nadie=false;

    if(!empty($_POST['bau']) )$bau=$_POST['bau'];
    if(!empty($_POST['confir'])) $confir=$_POST['confir'];
    if(!empty($_POST['matri'])) $matri=$_POST['matri'];
    if(!empty($_POST['sac'])) $sac=$_POST['sac'];
    if(!empty($_POST['pc'])) $pc=$_POST['pc'];

    if(empty($_POST['bau']) && empty($_POST['confir']) && empty($_POST['matri']) && empty($_POST['sac']) && empty($_POST['pc']) && !empty($_POST))
        $nadie=true;

    if(!empty($_POST['asunto']) && !empty($_POST['mensaje'])){
        $asunto=$_POST['asunto'];
        $mensaje=$_POST['mensaje'];
    }

    if(!empty($_POST) && !$nadie){

        $p = new persona("", "", "", "", "", "", "");

        $para="";
        if($bau=="si"){
            $cont=1;
            $res=$p->GetEmailsSac(1);
            while($fila=$res->fetch_array(MYSQLI_ASSOC)) {
                if($cont==1) $para=$fila['email'];
                else $para=$para.",".$fila['email'];
                $cont++;
            }
        }

        if($pc=="si"){
            $cont=1;
            $res=$p->GetEmailsSac(2);
            while($fila=$res->fetch_array(MYSQLI_ASSOC)) {
                if($cont==1) $para=$fila['email'];
                else $para=$para.",".$fila['email'];
                $cont++;
            }
        }

        if($confir=="si"){
            $cont=1;
            $res=$p->GetEmailsSac(3);
            while($fila=$res->fetch_array(MYSQLI_ASSOC)) {
                if($cont==1) $para=$fila['email'];
                else $para=$para.",".$fila['email'];
                $cont++;
            }
        }

        if($matri=="si"){
            $cont=1;
            $res=$p->GetEmailsSac(4);
            while($fila=$res->fetch_array(MYSQLI_ASSOC)) {
                if($cont==1) $para=$fila['email'];
                else $para=$para.",".$fila['email'];
                $cont++;
            }
        }

        if($sac=="si"){
            $cont=1;
            $res=$p->GetEmailsSacerdotes();
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
<div class="container">
    <div class="container">
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
                    <h3 class="panel-title">A quienes desea mandar el email?</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="checkbox-inline"><input type="checkbox" value="si" name="bau">Bautizados</label>
                        <label class="checkbox-inline"><input type="checkbox" value="si" name="pc">Con Primera Comunion</label>
                        <label class="checkbox-inline"><input type="checkbox" value="si" name="confir">Confirmados</label>
                        <label class="checkbox-inline"><input type="checkbox" value="si" name="matri">Casados</label>
                        <label class="checkbox-inline"><input type="checkbox" value="si" name="sac">Sacerdotes</label>
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