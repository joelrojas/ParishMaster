<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<!-- Bootstrap css -->
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

	<title>Registro COmunion</title>
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

		$civalido=false;
		$cipadvalido=false;
		$escat=false;
		$nombre=""; $apellido=""; $fechanac=""; $pid ="";

		$msj="<div class='alert alert-danger'><strong>Error!</strong> Este CI es incorrecto.</div>";
		$msjval="<div class='alert alert-success'><strong>Exito!</strong> Este CI es correcto.</div>";
		$msjcat="<div class='alert alert-success'><strong>Exito!</strong> Esta ersona ha sido bautizada en la Fe Catolica.</div>";
		$msjnonac="<div class='alert alert-danger'><strong>Error!</strong> Esta persona no ha sido bautizada en la Fe Catolica.</div>";

		if(isset($_POST['ci']) || !empty($_POST['ci']) ){
			$pp= new persona('','','','','','','','');
			$res=$pp->buscarper($_POST['ci']);
			if($res!='ERROR') {
				$fila=$res->fetch_array(MYSQLI_ASSOC);
				$civalido = true;
				$nombre=$fila['Nombre'];
				$apellido=$fila['Apellido'];
				$fechanac=$fila['fechanac'];
				$pid=$fila['idPersona'];

				$cat=$pp->tienesacramento($pid,1);
				if($cat) $escat=true;
			}
		}

		if(isset($_POST['cipadrino']) || !empty($_POST['cipadrino'])){
			$pp= new persona('','','','','','','','');
			$res=$pp->buscarper($_POST['cipadrino']);
			if($res!='ERROR') {$cipadvalido=true;}
		}

		if($escat && $civalido && $cipadvalido && !empty($_POST['fechacom']) &&!empty($_POST['parroquia']) && !empty($_POST['certificante']) && !empty($_POST['lugar']) && !empty($_POST['sacerdote']) ){
			$per = new persona($_POST['ci'], $nombre,$apellido, $fechanac, "", "", "");
			$pid=$fila['idPersona'];
			$padrinoid=$per->idfromci($_POST['cipadrino']);

			$cert = new certificado($_POST['parroquia'],$_POST['sacerdote'],$_POST['certificante'],$_POST['lugar'],$_POST['fechacom']);
			$cert->setlibroinfo($_POST['libro'],$_POST['pagina'],$_POST['numero']);
			$cert->reg_comunion($padrinoid , $pid);

			$_SESSION['idPersona']=$pid;

			echo ("<SCRIPT LANGUAGE='JavaScript'>
 					window.location.href='comunconfirm.php';</SCRIPT>");
		}



	?>
	<div class="container"  style="max-width: 700px">
		<div class="page-header">
		  <h1>Registro Canonico <small>Primera Comunion</small></h1>
		</div>
		<form action="ComunionReg.php" method="post">

			<label for="ci">CI:</label>
			<div class="input-group">

				<input value="<?php if(isset($_POST['ci'])) echo $_POST['ci']; ?>" type="text" required pattern ='^\d+$' title='Ingrese solo el numero de CI, sin letras' maxlength="10" class="form-control" id="ci" name="ci">
				<span class = 'input-group-btn'>
				<button class = 'btn btn-info' type = 'button' onclick = 'this.form.submit()'>Verificar</button>
				</span>
			</div>
			<?php
				if(isset($_POST['ci']) || !empty($_POST['ci'])){
					if(!$civalido) echo $msj;
					else if($civalido)  echo $msjval;
					if(!$escat) echo $msjnonac;
					else if($escat) echo $msjcat;
				}
			?>

			<div class="form-group">
				<label for="nombre">Nombre:</label>
				<input value="<?php if($civalido) echo $nombre; ?>" disabled  required pattern='^([ \u00c0-\u01ffa-zA-Z\-])+$' title='Ingrese sólo letras'  type="text" class="form-control" id="nombre" name="nombre">
			</div>
			<div class="form-group">
				<label for="apellido">Apellido:</label>
				<input value="<?php if($civalido) echo $apellido; ?>" disabled required pattern='^([ \u00c0-\u01ffa-zA-Z\-])+$' title='Ingrese sólo letras'  type="text" class="form-control" id="apellido" name="apellido">
			</div>
			<div class="form-group">
				<label for="fechanac">Fecha Nacimiento:</label>
				<input value="<?php if($civalido) echo $fechanac; ?>" disabled  required type="date" class="form-control" id="fechanac" name="fechanac">
			</div>
			<div class="form-group">
				<label for="fechacom">Fecha Comunion:</label>
				<input value="<?php if(isset($_POST['fechacom'])) echo $_POST['fechacom']; ?>"  type="date" required class="form-control" id="fechacom" name="fechacom">
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
				<label for="lugar">Lugar de Comunion:</label>
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

			<div class="form-group">
				<label for="libro">Libro:</label>
				<input type="text" value="<?php if(isset($_POST['libro'])) echo $_POST['libro']; ?>" maxlength="20" required class="form-control" id="libro" name="libro">
			</div>
			<div class="form-group">
				<label for="pagina">Pagina:</label>
				<input type="text" value="<?php if(isset($_POST['pagina'])) echo $_POST['pagina']; ?>" maxlength="20" equired class="form-control" id="pagina" name="pagina">
			</div>
			<div class="form-group">
				<label for="numero">Numero:</label>
				<input type="text" value="<?php if(isset($_POST['numero'])) echo $_POST['numero']; ?>" maxlength="20" required class="form-control" id="numero" name="numero">
			</div>

			<hr>
			<label for="cipadrino">CI Padrino/Madrina:</label>
			<div class="input-group">

				<input type="text" value="<?php if(isset($_POST['cipadrino'])) echo $_POST['cipadrino']; ?>"  required pattern ='^\d+$' title='Ingrese solo el numero de CI, sin letras' maxlength="10" class="form-control" id="cipadrino" name="cipadrino">
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
			<button type="submit" class="btn btn-default">Registrar</button>
		</form>




	</div>

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

	<!-- Bootstrap javascript -->
	<script src="../bootstrap/js/bootstrap.min.js"></script>

</body>
</html>