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
		//require_once "../general/headersac.php";
		require_once '../clases/persona.php';
		require_once '../clases/request.php';
		$req=new request();
		$mail="contacto@parishmaster.gwiddle.co.uk";
		$para="i.pfp94@gmail.com";
		$p = new persona("", "", "", "", "", "", "");
		session_start();
		//$_SESSION['idPersona']=15;
		$sacpuesto=$p->GetInfoSac($_SESSION['idPersona']);
        $pues=$sacpuesto->fetch_array(MYSQLI_ASSOC);

		$headers = 'From:'. $pues['tipo']." ".$_SESSION['nombre']." ".$_SESSION['apellido'].' <'.$mail.'>'. "\r\n" .
            'Reply-To:'. $pues['tipo']." ".$_SESSION['nombre']." ".$_SESSION['apellido'].' <'.$mail.'>' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
		if(isset($_GET['mensaje']))
		{
			mail($para, "Requisito atendido", $_GET['mensaje'], $headers);
			$req->set_respuesta($_GET['idreq'],$_GET['mensaje']);
			echo ("<SCRIPT LANGUAGE='JavaScript'>
 					window.alert('Se envio la respuesta')
 					window.location.href='listadorequest.php';</SCRIPT>");
		}
		else 
		{
			mail($para, "Requisito atendido", "Estimado Fiel, su requisito ya fue atendido por el ". $pues['tipo']." ".$_SESSION['nombre']." ".$_SESSION['apellido']."puede pasar por la parroquia a recoger su certificado", $headers);
	        $reqs=$req->get_req($_GET['idreq']);
	        $_SESSION['idPersona']=$reqs['idPersona'];
			$idPersona=$_SESSION['idPersona'];
			$req->set_respuesta($_GET['idreq'],'');
			if(empty($req->isespecial($_GET['idreq']))) {
				if($reqs['idSacramento']==1)
				{
					header("Location: imprimirnac.php");
					die();
				}
				if($reqs['idSacramento']==2)
				{
					header("Location: imprimircomun.php");
					die();
				}
				if($reqs['idSacramento']==3)
				{
					//echo $req->isespecial($_GET['idreq']);
					header("Location: imprimirconfir.php");
					die();
				}
				if($reqs['idSacramento']==4)
				{
					header("Location: imprimirmatrimonio.php");
					die();
				}
				
			}
		}
		
	?>
		
	<div class="container">
		<div class="page-header">
		  <h1>Respuesta a solicitud especial</h1>
		</div> 	

		<div class = "panel-body">
			<table class="table table-hover">
     			<tbody>
  					<?php
  						$req=new request();
  						$fila=$req->get_req($_GET['idreq']);
							echo "<tr><th>Nombre Fiel</th><td>".$fila['Nombre']." ".$fila['Apellido']."</td></tr>";
							echo "<tr><th>Sacramento</th><td>".$fila['sacramento']."</td></tr>";
							echo "<tr><th>Parroquia</th><td>".$fila['parroquia']."</td></tr>";
							echo "<tr><th>Mensaje</th><td>".$fila['mensaje']."</td></tr></tr>";
							echo "<tr><th>Libro</th><td>".$fila['libro']."</td></tr></tr>";
							echo "<tr><th>Pagina</th><td>".$fila['pagina']."</td></tr></tr>";
							echo "<tr><th>Numero</th><td>".$fila['numero']."</td></tr></tr>";
    				?>
				</tbody>
			</table>
		</div>

 		<div class = "panel panel-default">
			<div class="well">
                   <h4>Mensaje de Respuesta:</h4>
                   <form>
                       <div class="form-group">
                           <textarea class="form-control" rows="3" name="mensaje" id="mensaje"></textarea>
                           <?php echo "<input type='hidden' name='idreq' value='".$_GET['idreq']."'>";?>
                       </div>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                   </form>
			</div>
		</div>
	</div>

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

	<!-- Bootstrap javascript -->
	<script src="../bootstrap/js/bootstrap.min.js"></script>

</body>
</html>