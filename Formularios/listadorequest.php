<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<!-- Bootstrap css -->
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

	<title>Request</title>
</head>
<body>
	<?php
	ini_set("display_errors", TRUE);
		require_once '../clases/request.php';
		$_SESSION['idPersona']=5;
		$idPersona=$_SESSION['idPersona'];
	?>
		
	<div class="container">
		<div class="page-header">
		  <h1>Request</h1>
		</div> 		
 			<div class = "panel panel-default">
				<div class = "panel-heading">
					<h3 class = "panel-title">Solicitudes Pendientes</h3>
				</div>
				<div class = "panel-body">
					<table class="table table-hover">
    					<thead>
    						<tr>
        						<th>Nombre Fiel</th>
        						<th>Sacramento</th>
        						<th>Parroquia</th>
        						<th>Seleccionar</th>
        					</tr>
    					</thead>
    					<tbody>
    						<form action="reqespeciales.php">
    						<?php
    								$req=new request();
                                    $reqs=$req->get_reqs();
                                    while($fila=DatabaseHandler::fetchrow($reqs))
                                    {
                                    	echo "<tr>";
                                        echo "<td>".$fila['Nombre']." ".$fila['Apellido']."</td>";
                                        echo "<td>".$fila['sacramento']."</td>";
                                        echo "<td>".$fila['parroquia']."</td>";
                                        echo "<td><button type='submit' class='btn btn-success' id='idreq' name='idreq' value='".$fila['idRequest']."' >Atender</button></td>";
                                        echo "</tr>";
                                    }
    						?>
    						</form>
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