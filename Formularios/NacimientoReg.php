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
		require_once '../clases/parroquia.php';
		require_once '../clases/sacerdote.php';
		require_once '../clases/Lugar.php';

	?>
	<div class="container">
		<div class="page-header">
		  <h1>Registro de Sacramento <small>Bautizo</small></h1>
		</div>
		<form action="nacimconfirm.php" method="post">
			<div class="form-group">
				<label for="ci">CI:</label>
				<input type="text" class="form-control" id="ci" name="ci">
			</div>
			<div class="form-group">
				<label for="nombre">Nombre:</label>
				<input type="text" class="form-control" id="nombre" name="nombre" >
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
				<label for="fechabau">Fecha Bautizo:</label>
				<input type="date" class="form-control" id="fechabau" name="fechabau">
			</div>
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
				<label for="sacerdote">Sacerdote:</label>
				<select class="form-control" name="sacerdote">
					<option value="">Escoja un sacerdote</option>
					<?php
					$sac= new sacerdote(1,'nombre',1);
					$sacs=$sac->GetAll();
					while($fila=mysql_fetch_array($sacs)){
						echo "<option value='".$fila['idSacerdote']."'>".$fila['Nombre']." ".$fila['Apellido']."</option>";
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="certificante">Certificante:</label>
				<select class="form-control" name="certificante">
					<option value="">Escoja un certificante:</option>
					<?php
					$sac= new sacerdote();
					$sacs=$sac->GetAll();
					while($fila=mysql_fetch_array($sacs)){
						echo "<option value='".$fila['idSacerdote']."'>".$fila['Nombre']." ".$fila['Apellido']."</option>";
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="lugar">Lugar de Nacimiento:</label>
				<select class="form-control" name="lugar">
					<option value="">Seleccione un Departamento</option>
					<?php
					$lug= new Lugar('l');
					$lugs=$lug->GetAll();
					while($fila2=mysql_fetch_array($lugs)){
						echo "<option value='".$fila2['idLugar']."'>".$fila2['lugar']." </option>";
					}
					?>
				</select>
			</div>
			<hr>
			<div class="form-group">
				<label for="cipadre">CI Padre:</label>
				<input type="text" class="form-control" id="cipadre" name="cipadre">
			</div>
			<div class="form-group">
				<label for="cimadre">CI Madre:</label>
				<input type="text" class="form-control" id="cimadre" name="cimadre">
			</div>
			<div class="form-group">
				<label for="cipadrino">CI Padrino/Madrina:</label>
				<input type="text" class="form-control" id="cipadrino" name="cipadrino">
			</div>
			<hr>
			<div class="form-group">
				<label for="oficialia">Oficialia:</label>
				<input type="text" class="form-control" id="oficialia" name="oficialia">
			</div>

			<div class="form-group">
				<label for="libro">Libro:</label>
				<input type="text" class="form-control" id="libro" name="libro">
			</div>
			<div class="form-group">
				<label for="partida">Partida:</label>
				<input type="text" class="form-control" id="partida" name="partida">
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