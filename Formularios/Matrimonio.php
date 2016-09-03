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
							//$parr= new parroquia(1,"aa");
							//$parrs=$parr->GetAll();
							//while($fila=mysql_fetch_array($parrs)){
							//	echo "<option value='".$fila['idParroquia']."'>".$fila['Nombre']."</option>";
							//}
							?>
						</select>
					</div>

					<div class="form-group">
						<label for="presbitero">Presbitero:</label>
						<select class="form-control" name="presbitero">
							<option value="">Escoja un Presbitero</option>
							<?php
							//$sac= new sacerdote();
							//$sacs=$sac->GetAll();
							//while($fila=mysql_fetch_array($sacs)){
							//	echo "<option value='".$fila['idSacerdote']."'>".$fila['Nombre']." ".$fila['Apellido']."</option>";
							//}
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
							if(isset($_GET['esposa']))
							{
								$esposa=new fiel();
								$esposa=fiel::withID($_GET['esposa']);
								if($esposa->nombre=="ERROR")
								{
									echo "<label for='esposa'>ID Esposa:</label>
									  <div class = 'input-group'>
											<input type='number' class='form-control' id='esposa'>
											<span class = 'input-group-btn'>
												<button class = 'btn btn-info' type = 'button'>Verificar</button>
											</span>
									  </div>";
									echo "<div class='alert alert-danger'><strong>Error!</strong> Este ID es incorrecto.</div>";
								}
								else
								{
									echo "<label for='esposa'>ID Esposa:</label>
									  <div class = 'input-group'>
											<input type='number' class='form-control' id='esposa' value='".$_GET['esposa']."'>
											<span class = 'input-group-btn'>
												<button class = 'btn btn-info' type = 'button'>Verificar</button>
											</span>
									  </div>";
									echo "<label for='esposa'>Nombre Esposa:</label>
										  <input type='text' class='form-control' id='esposa' value='".$esposa->nombre."' readonly>";
									echo "<label for='esposa'>Apellido Esposa:</label>
										  <input type='text' class='form-control' id='esposa' value='".$esposa->apellido."' readonly>";	
								}
								
									  
							}
							else 
								echo "<label for='esposa'>ID Esposa:</label>
									  <div class = 'input-group'>
											<input type='number' class='form-control' id='esposa'>
											<span class = 'input-group-btn'>
												<button class = 'btn btn-info' type = 'button'>Verificar</button>
											</span>
									  </div>";
						?>
						
					</div>
					<div class="form-group">
						<?php 
							if(isset($_GET['esposo']))
							{
								$esposo=new fiel();
								$esposo=fiel::withID($_GET['esposo']);
								if($esposo->nombre=="ERROR")
								{
									echo "<label for='esposo'>ID Esposo:</label>
									  <div class = 'input-group'>
											<input type='number' class='form-control' id='esposo'>
											<span class = 'input-group-btn'>
												<button class = 'btn btn-info' type = 'button'>Verificar</button>
											</span>
									  </div>";
									echo "<div class='alert alert-danger'><strong>Error!</strong> Este ID es incorrecto.</div>";
								}
								else
								{
									echo "<label for='esposo'>ID Esposo:</label>
									  <div class = 'input-group'>
											<input type='number' class='form-control' id='esposo' value='".$_GET['esposo']."'>
											<span class = 'input-group-btn'>
												<button class = 'btn btn-info' type = 'button'>Verificar</button>
											</span>
									  </div>";
									echo "<label for='esposo'>Nombre Esposo:</label>
										  <input type='text' class='form-control' id='esposa' value='".$esposo->nombre."' readonly>";
									echo "<label for='esposo'>Apellido Esposo:</label>
										  <input type='text' class='form-control' id='esposa' value='".$esposo->apellido."' readonly>";	
								}
								
									  
							}
							else 
								echo "<label for='esposa'>ID Esposo:</label>
									  <div class = 'input-group'>
											<input type='number' class='form-control' id='esposo'>
											<span class = 'input-group-btn'>
												<button class = 'btn btn-info' type = 'button'>Verificar</button>
											</span>
									  </div>";
						?>
					</div>
					<div class="form-group">
						<label for="fecha">Fecha Matrimonio:</label>
						<input type="date" class="form-control" id="fecha">
					</div>
				</div>
			</div>

			<div class = "panel panel-default">
				<div class = "panel-heading">
					<h3 class = "panel-title">Datos Testigos</h3>
				</div>
				<div class = "panel-body">
					<div class="form-group">
						<label for="padrino">ID Padrino:</label>
						<input type="text" class="form-control" id="padrino">
						<label for="padrino">ID Padrino:</label>
						<input type="text" class="form-control" id="padrino">
						<label for="padrino">ID Padrino:</label>
						<input type="text" class="form-control" id="padrino">
						<label for="padrino">ID Padrino:</label>
						<input type="text" class="form-control" id="padrino">
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
						<input type="text" class="form-control" id="oficialia">
						<label for="partido">Partido:</label>
						<input type="text" class="form-control" id="partido">
						<label for="numero">Numero:</label>
						<input type="text" class="form-control" id="numero">
					</div>
					
				</div>
			</div>

			<button type="submit" class="btn btn-success btn-lg btn-block">Registrar</button>
		</form>




	</div>

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

	<!-- Bootstrap javascript -->
	<script src="../bootstrap/js/bootstrap.min.js"></script>

</body>
</html>