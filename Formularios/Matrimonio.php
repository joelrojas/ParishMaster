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
		ini_set("display_errors", TRUE);
		require_once "../general/headersac.php";

		require_once '../clases/parroquia.php';
		require_once '../clases/sacerdote.php';
		require_once '../clases/fiel.php';
		require_once '../clases/persona.php';

		require_once '../clases/Lugar.php';
		require_once '../clases/certificado.php';
		function set_id($persona)
		{

			if(!empty($_GET[$persona]))
			{
				$esposo=new fiel();
				$esposo=fiel::withID($_GET[$persona]);
				$pp= new persona('','','','','','','','');
				$res=$pp->buscarper($_GET[$persona]);
				if($res!='ERROR') {
					$fila=$res->fetch_array(MYSQLI_ASSOC);
					$pid=$fila['idPersona'];
				}
				$msjnobautizo="<div class='alert alert-danger'><strong>Error!</strong> Esta persona no ha sido bautizada en la Fe Catolica.</div>";
				$msjnocomunion="<div class='alert alert-danger'><strong>Error!</strong> Esta persona no ha realizado la primera comunion</div>";
				$msjnoconfir="<div class='alert alert-danger'><strong>Error!</strong> Esta persona no ha realizado su conformacion</div>";
				$v_b=$pp->tienesacramento($pid,1);
				$v_pc=$pp->tienesacramento($pid,2);
				$v_co=$pp->tienesacramento($pid,3);
				$btrue=false;
				$pctrue=false;
				$cotrue=false;
				if($v_b) $btrue=true;
				if($v_pc) $pctrue=true;
				if($v_co) $cotrue=true;
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
				if(!$v_b) echo $msjnobautizo;
				if(!$v_pc) echo $msjnocomunion;
				if(!$v_co) echo $msjnoconfir;
				
					  
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
	<div class="container" style="max-width: 500px">
		<div class="page-header">
		  <h1>Registro Matrimonio</h1>
		</div>
		<form>

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
					<h3 class = "panel-title">Datos Libro</h3>
				</div>
				<div class = "panel-body">
					
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
						<input type="text" value="<?php if(isset($_POST['numeroli'])) echo $_POST['numeroli']; ?>" maxlength="20" required class="form-control" id="numeroli" name="numeroli">
					</div>
				</div>
			</div>

			<div class = "panel panel-default">
				<div class = "panel-heading">
     				<h3 class = "panel-title">Datos Parroquia</h3>
     			</div>
     			<div class = "panel-body">
     				<div class="form-group">
						<label for="parroquia">Iglesia Parroquial:</label>
						<?php
						echo "<select class='form-control' name='parroquia'";
						 if(!isset($_GET['esposo'])||!isset($_GET['esposa'])|| empty($_GET['esposo'])|| empty($_GET['esposa'])) echo "disabled";
						 	echo ">";
							echo "<option value=''>Escoja una Iglesia Parroquial</option>";
							if(isset($_GET['esposo'])&&isset($_GET['esposa'])&& !empty($_GET['esposo'])&& !empty($_GET['esposa']))
							{
								$parr= new parroquia(1,"aa");
								$parrs=$parr->get_parr_matrimonio($_GET['esposa'],$_GET['esposo']);
								while($fila=DatabaseHandler::fetchrow($parrs)){
									echo "<option value='".$fila['idParroquia']."'";
									if(isset($_GET['parroquia']))if($_GET['parroquia'] == $fila['idParroquia']){echo("selected");}
									echo">".$fila['Nombre']."</option>";
								}
							}
							?>
						</select>
					</div>

     				<div class="form-group">
						<label for="lugar">Lugar:</label>
						<select class="form-control" name="lugar">
							<option value="">Escoja un Lugar</option>
							<?php
							$lug= new Lugar("aa");
							$lugs=$lug->GetAll();
							while($fila=DatabaseHandler::fetchrow($lugs)){
								echo "<option value='".$fila['idLugar']."'";
								if(isset($_GET['lugar']))if($_GET['lugar'] == $fila['idLugar']){echo("selected");}
								echo">".$fila['lugar']."</option>";
							}
							?>
						</select>
					</div>

					<div class="form-group">
						<label for="presbitero">Presbitero:</label>
						<?php
						echo "<select class='form-control' name='presbitero'";
						if(!isset($_GET['parroquia'])|| empty($_GET['parroquia'])) echo "disabled";
						 	echo ">";
							
							echo "<option value=''>Escoja un Presbitero</option>";
							if(isset($_GET['parroquia'])|| !empty($_GET['parroquia']))
							{
								$sac= new sacerdote(1,"aa","a");
								$sacs=$sac->get_sac_parr($_GET['parroquia']);
								while($fila=DatabaseHandler::fetchrow($sacs)){
									echo "<option value='".$fila['idSacerdote']."'";
									if(isset($_GET['presbitero']))if($_GET['presbitero'] == $fila['idSacerdote']){echo("selected");}
									echo">".$fila['Nombre']." ".$fila['Apellido']."</option>";

								}
							}
							?>
						</select>
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
						<input type="text" class="form-control" id="numero" name="numero">
					</div>
					
				</div>
			</div>

			<button type="submit" class="btn btn-success btn-lg btn-block" name="enviar" value="true">Registrar</button>
		</form>
 		<?php
 			if(!empty($_GET['parroquia'])&&!empty($_GET['lugar'])&&!empty($_GET['presbitero'])&&!empty($_GET['fecha'])&&!empty($_GET['oficialia'])&&!empty($_GET['numero'])&&!empty($_GET['enviar'])) 
 			{
 				$cert=new certificado($_GET['parroquia'], $_GET['presbitero'], $_GET['presbitero'], $_GET['lugar'], $_GET['fecha']);
 				$cert->setlibroinfo($_GET['libro'],$_GET['pagina'],$_GET['numeroli']);
 				$cert->reg_matrimonio(fiel::withID($_GET['padrino1'])->id,fiel::withID($_GET['padrino2'])->id,fiel::withID($_GET['padrino3'])->id,fiel::withID($_GET['padrino4'])->id,fiel::withID($_GET['esposa'])->id,fiel::withID($_GET['esposo'])->id,$_GET['oficialia'],$_GET['numero'],$_GET['partido']);
 				echo ("<SCRIPT LANGUAGE='JavaScript'>
 					window.alert('Se guardaron sus cambios')
 					window.location.href='Matrimonio.php';</SCRIPT>");
 			}
 		?>



	</div>

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

	<!-- Bootstrap javascript -->
	<script src="../bootstrap/js/bootstrap.min.js"></script>

</body>
</html>