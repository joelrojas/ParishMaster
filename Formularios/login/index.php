<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap Login Form Template</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

    </head>

    <body>

    <?php
        session_start();
        if(isset($_POST['email']) && isset($_POST['password'])){
            require_once '../../clases/persona.php';
            $p= new persona(1,1,1,1,1,1,1);
            $res=$p->buscar($_POST['email']);
            $text="";
            if(mysql_num_rows($res)==1){
                $fila=mysql_fetch_array($res);
                if($fila['password']==$_POST['password']){
                    $_SESSION['password']=$_POST['password'];
                    $_SESSION['ci']=$fila['ci'];
                    $_SESSION['nombre']=$fila['Nombre'];
                    $_SESSION['apellido']=$fila['Apellido'];
                    $_SESSION['fechanac']=$fila['fechanac'];
                    $_SESSION['email']=$fila['email'];
                    if($p->isSacerdote($fila['ci'])) $_SESSION['sacerdote']=1;
                    else $_SESSION['sacerdote']=0;

                    echo "<script>window.location = '../../Principal/principal.php';</script>";

                }
                else $text= 'Clave incorrecta';
            }
            else $text= 'CI no esta registrado';

            echo "<div class='alert alert-danger' role='alert'>
                    ".$text."
                    </div>";

        }
    ?>


        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>Registro</strong> de Fieles</h1>
                            <div class="description">
                            	<p>
	                            	Ingrese a su cuenta o registrese para emitir sus certificados de sacramentos.
                            	</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Ingrese a nuestro sitio</h3>
                            		<p>Ingrese su usuario y clave para ingresar al sistema:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-lock"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" action="" method="post" class="login-form">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Email</label>
			                        	<input type="text" name="email" placeholder="alguien@gmail.com" class="form-username form-control" id="form-username">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="password" placeholder="Password" class="form-password form-control" id="form-password">
			                        </div>
			                        <button type="submit" class="btn">Entrar!</button>
                                    <br><br>
                                   <a href="../PersonaReg.php"> <button type="button" class="btn">Aun no tienes cuenta? Registrate!</button> </a>
			                    </form>
		                    </div>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>


        <!-- Javascript -->
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>