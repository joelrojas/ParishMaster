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
        require_once "../general/headersac.php";

        require_once '../clases/parroquia.php';
        require_once '../clases/sacerdote.php';


        require_once '../clases/persona.php';


        $cicorr=false;
        $emailcorr=false;
        $essac=false;

        $nombre=""; $apellido=""; $fechanac=""; $pid ="";

        $msj="<div class='alert alert-success'><strong>Exito!</strong> Este CI es nuevo, se registrara una nueva cuenta.</div>";
        $msjval="<div class='alert alert-success'><strong>Exito!</strong> Este CI ya esta en la base de datos, se registrara la cuenta a partir de los datos existentes.</div>";

        $msjmailcorr="<div class='alert alert-success'><strong>Exito!</strong> Este email no ha sido escogido por otro usuario.</div>";
        $msjexiemail="<div class='alert alert-danger'><strong>Error!</strong> Este email ya ha sido escogido por otro usuario.</div>";

        $msjsac="<div class='alert alert-danger'><strong>Error!</strong> Este ci ya corresponde a un sacerdote.</div>";

        if( !empty($_POST['ci']) ){
            $pp= new persona('','','','','','','','');
            $res=$pp->buscarper($_POST['ci']);
            if($pp->isSacerdote($_POST['ci'])){
                $essac=true;
            }
            else if($res!='ERROR') {
                $fila=$res->fetch_array(MYSQLI_ASSOC);
                $cicorr = true;
                $nombre=$fila['Nombre'];
                $apellido=$fila['Apellido'];
                $fechanac=$fila['fechanac'];
                $pid=$fila['idPersona'];
            }
        }

        if(!empty($_POST['email']) ){
            $pp= new persona('','','','','','','','');
            $emailexiste=$pp->buscarmail($_POST['email']);
            if(!$emailexiste) $emailcorr=true;
        }


        if(!empty($_POST['fechanac'])  && !empty($_POST['password'])){
            if($cicorr && $emailcorr && !$essac){
                $per = new persona($_POST["ci"],$nombre,$apellido,$fechanac,1,$_POST['email'],$_POST['password']);
                $per->regcuenta($pid);
                $sac= new sacerdote($pid, $_POST['tiposac'], $_POST['parroquia']);
                $sac->reg();
            }
            if (!$cicorr && $emailcorr && !$essac){
                echo "asd";
                $per = new persona($_POST["ci"],$_POST['nombre'],$_POST['apellido'],$_POST['fechanac'],1,$_POST['email'],$_POST['password']);
                $idpersona=$per->registrar();
                $per->regcuenta($idpersona);
                $sac= new sacerdote($idpersona, $_POST['tiposac'], $_POST['parroquia']);
                $sac->reg();
            }
            echo ("<SCRIPT LANGUAGE='JavaScript'>
                            window.location.href='sacerdoteconfirm.php';</SCRIPT>");
        }


?>
<div class="container"  style="max-width: 700px">
    <div class="page-header">
        <h1>Registro de Sacerdotes
        </h1>
    </div>
    <form action="sacerdotereg.php" method="post">

        <h2>Informacion Personal:</h2>

        <label for="ci">CI:</label>
        <div class="input-group">
            <input  type="text"  value="<?php if(isset($_POST['ci'])) echo $_POST['ci']; ?>"  required pattern ='^\d+$' title='Ingrese solo el numero de CI, sin letras' maxlength="10" class="form-control" id="ci" name="ci">
            <span class = 'input-group-btn'>
				<button class = 'btn btn-info' type = 'button' onclick = 'this.form.submit()'>Verificar</button>
            </span>
        </div>
        <?php
        if(isset($_POST['ci']) || !empty($_POST['ci'])){
            if(!$cicorr) echo $msj;
            else echo $msjval;
            if($essac) echo $msjsac;
        }
        ?>

        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" value="<?php if($cicorr) echo $nombre; else if(isset($_POST['nombre'])) echo $_POST['nombre']; ?>" required pattern='^([ \u00c0-\u01ffa-zA-Z\-])+$' title='Ingrese sólo letras' class="form-control" id="nombre" name="nombre">
        </div>
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" value="<?php if($cicorr) echo $apellido; else if(isset($_POST['apellido'])) echo $_POST['apellido']; ?>" required pattern='^([ \u00c0-\u01ffa-zA-Z\-])+$' title='Ingrese sólo letras' class="form-control" id="apellido" name="apellido">
        </div>
        <div class="form-group">
            <label for="fechanac">Fecha Nacimiento:</label>
            <input type="date" value="<?php if($cicorr) echo $fechanac; else if(isset($_POST['fechanac'])) echo $_POST['fechanac']; ?>" required class="form-control" id="fechanac" name="fechanac">
        </div>

        <hr>

        <h2>Informacion de Sacerdote:</h2>

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
            <label for="tiposac">Tipos de Sacerdote</label>
            <select class="form-control" name="tiposac" required>
                <option value="">Escoja un tipo</option>
                <?php
                $sac = new sacerdote("", "", "");
                $res= $sac->getTipos();
                while($fila=$res->fetch_array(MYSQLI_ASSOC)){
                    echo "<option value='".$fila['idtipo_sacerdote']."'";
                    if(isset($_POST['tiposac']))
                        if($_POST['tiposac'] == $fila['idtipo_sacerdote'])
                            echo("selected");
                    echo ">".$fila['tipo']."</option>";
                }
                ?>
            </select>
        </div>

        <hr>

        <h2> Informacion de la cuenta: </h2>

        <label for="email">Email:</label>
        <div class="input-group">
            <input type="text" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Ingrese un email valido, ejemplo nombre@gmail.com" class="form-control" id="email" name="email">
            <span class = 'input-group-btn'>
				<button class = 'btn btn-info' type = 'button' onclick = 'this.form.submit()'>Verificar</button>
            </span>
        </div>
        <?php
        if(isset($_POST['email']) || !empty($_POST['email'])){
            if($emailcorr) echo $msjmailcorr;
            else echo $msjexiemail;
        }
        ?>

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