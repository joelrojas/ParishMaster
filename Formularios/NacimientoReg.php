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
		require_once "../general/headersac.php";

		require_once '../clases/parroquia.php';
		require_once '../clases/sacerdote.php';
		require_once '../clases/Lugar.php';

	session_start();
	require_once '../clases/certificado.php';
	require_once '../clases/persona.php';

	$mcivalido=false;
	$pcivalido=false;
	$cipadvalido=false;

	$msj="<div class='alert alert-danger'><strong>Error!</strong> Este CI es incorrecto.</div>";
	$msjval="<div class='alert alert-success'><strong>Exito!</strong> Este CI es correcto.</div>";

	if(isset($_POST['cipadrino']) || !empty($_POST['cipadrino'])){
		$pp= new persona('','','','','','','','');
		$res=$pp->buscarper($_POST['cipadrino']);
		if($res!='ERROR') {$cipadvalido=true;}
	}

	if(isset($_POST['cipadre']) || !empty($_POST['cipadre'])){
		$pp= new persona('','','','','','','','');
		$res=$pp->buscarper($_POST['cipadre']);
		if($res!='ERROR') {$pcivalido=true;}
	}

	if(isset($_POST['cimadre']) || !empty($_POST['cimadre'])){
		$pp= new persona('','','','','','','','');
		$res=$pp->buscarper($_POST['cimadre']);
		if($res!='ERROR') {$mcivalido=true;}
	}

	if($mcivalido && $pcivalido && $cipadvalido && !empty($_POST['fechanac']) && !empty($_POST['fechabau']) &&!empty($_POST['parroquia']) && !empty($_POST['certificante']) && !empty($_POST['lugar']) && !empty($_POST['sacerdote'])){
		$per= new persona($_POST['ci'], $_POST['nombre'], $_POST['apellido'], $_POST['fechanac'], 1, "", "");
		$pid=$per->registrar();

		$personax= new persona("", "", "", "", "", "", "");

		$idmadre=$personax->idfromci($_POST['cimadre']);
		$idpadre=$personax->idfromci($_POST['cipadre']);
		$idpadrino=$personax->idfromci($_POST['cipadrino']);

		$cer = new certificado($_POST['parroquia'],$_POST['sacerdote'],$_POST['certificante'],$_POST['lugar'],$_POST['fechabau']);
		$cerid=$cer->reg_bautizo($_POST['nombre'],$_POST['apellido'],$_POST['fechanac'],$idpadrino,$idpadre,$idmadre,$pid);
		$cer->addregciv($_POST['oficialia'], $_POST['libro'], $_POST['partida'], $cerid);

		$_SESSION['idPersona']=$pid;

		echo ("<SCRIPT LANGUAGE='JavaScript'>
 					window.location.href='nacimconfirm.php';</SCRIPT>");
	}



	?>

	<div class="container" style="max-width: 700px">
		<div class="page-header">
		  <h1>Registro Canonico <small>Bautizo</small></h1>
		</div>
		<form action="NacimientoReg.php" method="post">
			<div class="form-group">
				<label for="ci">CI:</label>
				<input value="<?php if(isset($_POST['ci'])) echo $_POST['ci']; ?>" required pattern ='^\d+$' title='Ingrese solo el numero de CI, sin letras' maxlength="10" type="text" class="form-control" id="ci" name="ci">
			</div>
			<div class="form-group">
				<label for="nombre">Nombre:</label>
				<input value="<?php if(isset($_POST['nombre'])) echo $_POST['nombre']; ?>" type="text" required pattern='^([ \u00c0-\u01ffa-zA-Z\-])+$' title='Ingrese sólo letras'  class='form-control' class="form-control" id="nombre" name="nombre" >
			</div>
			<div class="form-group">
				<label for="apellido">Apellido:</label>
				<input type="text"  value="<?php if(isset($_POST['apellido'])) echo $_POST['apellido']; ?>" required pattern='^([ \u00c0-\u01ffa-zA-Z\-])+$' title='Ingrese sólo letras'  class='form-control' class="form-control" id="apellido" name="apellido">
			</div>
			<div class="form-group">
				<label for="fechanac">Fecha Nacimiento:</label>
				<input type="date" value="<?php if(isset($_POST['fechanac'])) echo $_POST['fechanac']; ?>" required class="form-control" id="fechanac" name="fechanac">
			</div>
			<div class="form-group">
				<label for="fechabau">Fecha Bautizo:</label>
				<input type="date" value="<?php if(isset($_POST['fechabau'])) echo $_POST['fechabau']; ?>" required class="form-control" id="fechabau" name="fechabau">
			</div>
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
				<label for="sacerdote">Sacerdote:</label>
				<select class="form-control" name="sacerdote" required>
					<option value="">Escoja un sacerdote</option>
					<?php
					$sac= new sacerdote(1,'nombre',1);
					$sacs=$sac->GetAll();
					while($fila=$sacs->fetch_array(MYSQLI_ASSOC)){
						echo "<option value='".$fila['idSacerdote']."'";
						if(isset($_POST['sacerdote']))
							if($_POST['sacerdote'] == $fila['idSacerdote'])
								echo("selected");
						echo ">".$fila['Nombre']." ".$fila['Apellido']."</option>";

					}
					?>
				</select>
			</div>


			<div class="form-group">
				<label for="certificante">Certificante:</label>
				<select class="form-control" name="certificante" required>
					<option value="">Escoja un certificante:</option>
					<?php
					$sac= new sacerdote();
					$sacs=$sac->GetAll();
					while($fila=$sacs->fetch_array(MYSQLI_ASSOC)){
						echo "<option value='".$fila['idSacerdote']."'";
						if(isset($_POST['certificante']))
							if($_POST['certificante'] == $fila['idSacerdote'])
								echo("selected");
						echo ">".$fila['Nombre']." ".$fila['Apellido']."</option>";
					}
					?>
				</select>
			</div>

			<div class="form-group">
				<label for="lugar">Lugar de Nacimiento:</label>
				<select class="form-control" name="lugar" required>
					<option value="">Seleccione un Departamento</option>
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
			<hr>

			<label for="cipadre">CI Padre:</label>
			<div class="input-group">
				<input type="text" value="<?php if(isset($_POST['cipadre'])) echo $_POST['cipadre']; ?>"  required pattern ='^\d+$' title='Ingrese solo el numero de CI, sin letras' maxlength="10" class="form-control" id="cipadre" name="cipadre">
				<span class = 'input-group-btn'>
				<button class = 'btn btn-info' type = 'button' onclick = 'this.form.submit()'>Verificar</button>
				</span>
			</div>
			<?php
			if(isset($_POST['cipadre']) || !empty($_POST['cipadre'])) {
				if (!$pcivalido) echo $msj;
				else echo $msjval;
			}
			?>

			<label for="cimadre">CI Madre:</label>
			<div class="input-group">
				<input type="text" value="<?php if(isset($_POST['cimadre'])) echo $_POST['cimadre']; ?>"  required pattern ='^\d+$' title='Ingrese solo el numero de CI, sin letras' maxlength="10" class="form-control" id="cimadre" name="cimadre">
				<span class = 'input-group-btn'>
				<button class = 'btn btn-info' type = 'button' onclick = 'this.form.submit()'>Verificar</button>
				</span>
			</div>
			<?php
			if(isset($_POST['cimadre']) || !empty($_POST['cimadre'])) {
				if (!$mcivalido) echo $msj;
				else echo $msjval;
			}
			?>

			<label for="cipadrino">CI Padrino/Madrina:</label>
			<div class="input-group">
				<input type="text" value="<?php if(isset($_POST['cipadrino'])) echo $_POST['cipadrino']; ?>" required pattern ='^\d+$' title='Ingrese solo el numero de CI, sin letras' maxlength="10" class="form-control" id="cipadrino" name="cipadrino">
				<span class = 'input-group-btn'>
				<button class = 'btn btn-info' type = 'button' onclick = 'this.form.submit()'>Verificar</button>
				</span>
			</div>
			<?php
			if(isset($_POST['cipadrino']) || !empty($_POST['cipadrino'])) {
				if (!$cipadvalido) echo $msj;
				else echo $msjval;
			}
			?>

			<hr>
			<div class="form-group">
				<label for="oficialia">Oficialia:</label>
				<input type="text" value="<?php if(isset($_POST['oficialia'])) echo $_POST['oficialia']; ?>"  required pattern ='^\d+$' title='Ingrese solo numeros' maxlength="10" class="form-control" id="oficialia" name="oficialia">
			</div>

			<div class="form-group">
				<label for="libro">Libro:</label>
				<input type="text" value="<?php if(isset($_POST['libro'])) echo $_POST['libro']; ?>" required maxlength="10" class="form-control" id="libro" name="libro">
			</div>
			<div class="form-group">
				<label for="partida">Partida:</label>
				<input type="text" value="<?php if(isset($_POST['partida'])) echo $_POST['partida']; ?>"  required pattern ='^\d+$' title='Ingrese solo numeros' maxlength="10" class="form-control" id="partida" name="partida">
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