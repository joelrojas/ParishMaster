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
		//require_once "../general/headersac.php";

		require_once '../clases/certificado.php';
		require_once '../clases/sacramentos.php';
		$_SESSION['idPersona']=5;
		$idPersona=$_SESSION['idPersona'];
	?>
		
	<div class="container">
		<div class="page-header">
		  <h1>Requerimientos de misas</h1>
		</div> 		
 			<div class = "panel panel-default">
				<div class = "panel-heading">
					<h3 class = "panel-title">Resultados de la busqueda</h3>
				</div>
				<div class = "panel-body">
					<table class="table table-hover">
    					<thead>
    						<tr>
        						<th>Nombre Fiel</th>
        						<th>Sacramento</th>
        						<th>Parroquia</th>
        						<th>Horario</th>
        						<th>Fecha</th>
    						</tr>
    					</thead>
    					<tbody>
    						<?php
    								$sac=new sacramento();
                                    $misas=$sac->get_celebraciones($idPersona);
                                    while($fila=DatabaseHandler::fetchrow($misas))
                                    {
                                    	echo "<tr>";
                                        echo "<td>".$fila['nombrefiel']." ".$fila['apellidofiel']."</td>";
                                        echo "<td>".$fila['sacramento']."</td>";
                                        echo "<td>".$fila['parroquia']."</td>";
                                        echo "<td>".$fila['horario']."</td>";
                                        echo "<td>".$fila['fecha']."</td>";
                                        echo "</tr>";
                                    }
    						?>
    					</tbody>
    				</table>
				</div>
			</div>
	</div>

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

	<!-- Bootstrap javascript -->
	<script src="../bootstrap/js/bootstrap.min.js"></script>

</body>
</html>