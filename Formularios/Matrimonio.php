<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<!-- Bootstrap css -->
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

	<title>Registro Matrimonio</title>
</head>
<body>
	<?php
		require_once '../clases/parroquia.php';
		require_once '../clases/sacerdote.php';
		require_once '../clases/fiel.php';
		function set_id($persona)
		{

			if(!empty($_GET[$persona]))
			{
				$esposo=new fiel();
				$esposo=fiel::withID($_GET[$persona]);
				if($esposo->nombre=="ERROR")
				{
					echo "<label for='$persona'>ID $persona:</label>
					  <div class = 'input-group'>
							<input type='number' class='form-control' id='$persona' name='$persona' value='".$_GET[$persona]."'>
							<span class = 'input-group-btn'>
								<button class = 'btn btn-info' type = 'button' onclick = 'this.form.submit()'>Verificar</button>
							</span>
					  </div>";
					echo "<div class='alert alert-danger'><strong>Error!</strong> Este ID es incorrecto.</div>";
				}
				else
				{
					echo "<label for='$persona'>ID $persona:</label>
					  <div class = 'input-group'>
							<input type='number' class='form-control' id='$persona' name='$persona' value='".$_GET[$persona]."'>
							<span class = 'input-group-btn'>
								<button class = 'btn btn-info' type = 'button' onclick = 'this.form.submit()'>Verificar</button>
							</span>
					  </div>";
					echo "<label>Nombre $persona:</label>
						  <input type='text' class='form-control'  value='".$esposo->nombre."' readonly>";
					echo "<label>Apellido $persona:</label>
						  <input type='text' class='form-control'  value='".$esposo->apellido."' readonly>";	
				}
				
					  
			}
			else 
				echo "<label for='$persona'>ID $persona:</label>
					  <div class = 'input-group'>
							<input type='number' class='form-control' id='$persona' name='$persona'>
							<span class = 'input-group-btn'>
								<button class = 'btn btn-info' type = 'button' onclick = 'this.form.submit()'>Verificar</button>
							</span>
					  </div>";
		}
	?>
	<div class="container">
		<div class="page-header">
		  <h1>Registro Matrimonio</h1>
		</div>
		<form>
			<div class = "panel panel-default">
				<div class = "panel-heading">
     				<h3 class = "panel-title">Datos Parroquia</h3>
     			</div>
     			<div class = "panel-body">
     				<div class="form-group">
						<label for="parroquia">Iglesia Parroquial:</label>
						<select class="form-control" name="parroquia">
							<option value="">Escoja una Iglesia Parroquial</option>
							<?php
							$parr= new parroquia(1,"aa");
							$parrs=$parr->GetAll();
							while($fila=DatabaseHandler::fetchrow($parrs)){
								echo "<option value='".$fila['idParroquia']."'>".$fila['Nombre']."</option>";
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
								echo "<option value='".$fila['idSacerdote']."'>".$fila['Nombre']." ".$fila['Apellido']."</option>";
							}
							?>
						</select>
					</div>
     			</div>
     		</div>

			<div class = "panel panel-default">
				<div class = "panel-heading">
					<h3 class = "panel-title">Datos Esposos</h3>
				</div>
				<div class = "panel-body">
					<div class="form-group">
						<?php 
							set_id("esposa");
						?>
						
					</div>
					<div class="form-group">
						<?php 
							set_id("esposo");
						?>
					</div>
					<div class="form-group">
						<label for="fecha">Fecha Matrimonio:</label>
						<input type="date" class="form-control" id="fecha" name="fecha">
					</div>
				</div>
			</div>

			<div class = "panel panel-default">
				<div class = "panel-heading">
					<h3 class = "panel-title">Datos Testigos</h3>
				</div>
				<div class = "panel-body">
					<div class="form-group">
						<?php 
							set_id("padrino1");
							set_id("padrino2");
							set_id("padrino3");
							set_id("padrino4");
						?>
					</div>
					
				</div>
			</div>

			<div class = "panel panel-default">
				<div class = "panel-heading">
					<h3 class = "panel-title">Datos Registro Civil</h3>
				</div>
				<div class = "panel-body">
					<div class="form-group">
						<label for="oficialia">Oficialia del Registo Civil:</label>
						<input type="text" class="form-control" id="oficialia" name="oficialia">
						<label for="partido">Partido:</label>
						<input type="text" class="form-control" id="partido" name="partido">
						<label for="numero">Numero:</label>
						<input type="text" class="form-control" id="numero"  name"numero">
					</div>
					
				</div>
			</div>

			<button type="submit" class="btn btn-success btn-lg btn-block" name="coso" value="coso">Registrar</button>
		</form>




	</div>

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

	<!-- Bootstrap javascript -->
	<script src="../bootstrap/js/bootstrap.min.js"></script>

</body>
</html>