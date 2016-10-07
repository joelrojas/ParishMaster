<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<!-- Bootstrap css -->
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

	<title>Requerimientos de misas</title>
</head>
<body>
	<?php
		require_once "../general/headerfiel.php";
		require_once "../clases/parroquia.php";
		require_once '../clases/certificado.php';
		require_once '../clases/sacerdote.php';
		require_once '../clases/fiel.php';
		require_once '../clases/misa.php';
		require_once '../clases/sacramentos.php';


		session_start();
		//$_SESSION['idPersona']=16;
		$idPersona=$_SESSION['idPersona'];
		$fiel=new fiel();
		$fiel=fiel::withID2($idPersona);
	?>
		
	<div class="container" style="max-width: 500px">
		<div class="page-header">
		  <h1>Requerimientos de misas</h1>
		</div>
		
			<div class = "panel panel-default">
				<div class = "panel-heading">
     				<h3 class = "panel-title">Consulta</h3>
     			</div>
     			<div class = "panel-body">
     				<div class="form-group">
     					<form>
							<?php echo "<label for='fiel'>ID fiel:</label>
					  			<input type='number' class='form-control' id='fiel' name='fiel' value='$idPersona' disabled> ";
							 	echo "<label>Nombre fiel:</label>
						  			<input type='text' class='form-control'  value='".$fiel->nombre."' readonly>";
								echo "<label>Apellido fiel:</label>
						 			<input type='text' class='form-control'  value='".$fiel->apellido."' readonly>";
						 	?>

    						<div class="form-group">
								<label for="parroquia">Iglesia Parroquial:</label>
								<select class="form-control" name="parroquia">
									<option value="">Escoja una Iglesia Parroquial</option>
									<?php
									$parr= new parroquia(1,"aa");
									$parrs=$parr->GetAll();
									while($fila=DatabaseHandler::fetchrow($parrs)){
										echo "<option value='".$fila['idParroquia']."'";
										if(isset($_GET['parroquia']))if($_GET['parroquia'] == $fila['idParroquia']){echo("selected");}
										echo">".$fila['Nombre']."</option>";
									}
									?>
								</select>
							</div>

							<div class="form-group">
								<label for="presbitero">Presbitero:</label>
								<select class="form-control" name="presbitero">
									<option value="">Escoja un Presbitero</option>
									<?php
									$sac= new sacerdote(1,"aa","a");
									$sacs=$sac->GetAll();
									while($fila=DatabaseHandler::fetchrow($sacs)){
										echo "<option value='".$fila['idSacerdote']."'";
										if(isset($_GET['presbitero']))if($_GET['presbitero'] == $fila['idSacerdote']){echo("selected");}
										echo">".$fila['Nombre']." ".$fila['Apellido']."</option>";

									}
									?>
								</select>
							</div>

							<label for='fecha'>Fecha:</label>
							<div class = 'input-group'>
								<input type="date" class="form-control" id="fecha" name="fecha" <?php if(isset($_GET['fecha']))echo "value='".$_GET['fecha']."'";?>>
								<span class = 'input-group-btn'>
									<button class = 'btn btn-info' type = 'button' onclick = 'this.form.submit()'>Verificar horarios</button>
								</span>
					  		</div>


							<div class="form-group">
								<label for="horario">Horario:</label>
								<?php echo "<select class='form-control' id='horario' name='horario' ";  
									if(empty($_GET['fecha'])) echo "disabled"; 
									echo ">";
								?>
									<option value="">Escoja un Horrario</option>
									<?php
									if(!empty($_GET['fecha']))
									{
										$misa= new misa();
										$horario=$misa->get_horarios($_GET['fecha'],$_GET['parroquia'],$_GET['presbitero']);
										while($fila=DatabaseHandler::fetchrow($horario)){
											echo "<option value='".$fila['idhorario_misa']."' >".$fila['horario']."</option>";
										}
									}
									?>
								</select>
							</div>

							<div class="form-group">
								<label for="sacramento">Sacramento:</label>
								<select class="form-control" name="sacramento">
									<option value="">Escoja un Sacramento</option>
									<?php
									$sac= new sacramento();
									$sacs=$sac->get_sacramento();
									while($fila=DatabaseHandler::fetchrow($sacs)){
										echo "<option value='".$fila['idSacramento']."'>".$fila['Nombre']."</option>";

									}
									?>
								</select>
							</div>

							<button type="submit" class="btn btn-success btn-lg btn-block" name="reservar" value="true">Reservar</button>
						</form>
					</div>
     			</div>
     		</div>		
	</div>
	<?php
	if(isset($_GET['reservar']))
		if(!is_null($_GET['fecha'])&&!is_null($_GET['parroquia'])&&!is_null($_GET['presbitero'])&&!is_null($_GET['horario']))
		{
			$misa=new misa();
 			$misa->reservar_misa($_GET['fecha'],$_GET['parroquia'],$_GET['presbitero'],$idPersona,$_GET['sacramento'],$_GET['horario']);
 			echo ("<SCRIPT LANGUAGE='JavaScript'>
 				window.alert('Se envio la solicitud')
				window.location.href='requestmisa.php';</SCRIPT>");
		}
	?>

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

	<!-- Bootstrap javascript -->
	<script src="../bootstrap/js/bootstrap.min.js"></script>

</body>
</html>