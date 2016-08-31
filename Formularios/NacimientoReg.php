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
		require_once '../clases/sacerdote.php'
	?>
	<div class="container">
		<div class="page-header">
		  <h1>Registro de Sacramento <small>Nacimiento</small></h1>
		</div>
		<form>
			<div class="form-group">
				<label for="nombre">Nombre:</label>
				<input type="text" class="form-control" id="nombre">
			</div>
			<div class="form-group">
				<label for="apellido">Apellido:</label>
				<input type="text" class="form-control" id="apellido">
			</div>
			<div class="form-group">
				<label for="fechanac">Fecha Nacimiento:</label>
				<input type="date" class="form-control" id="fechanac">
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
					$sac= new sacerdote();
					$sacs=$sac->GetAll();
					while($fila=mysql_fetch_array($sacs)){
						echo "<option value='".$fila['idSacerdote']."'>".$fila['Nombre']." ".$fila['Apellido']."</option>";
					}
					?>
				</select>
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