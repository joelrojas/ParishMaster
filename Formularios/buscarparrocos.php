<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap css -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

    <title>Busqueda de sacerdotes</title>
</head>
<body>
    <?php
        require_once "../general/headersac.php";

        require_once '../clases/sacerdote.php';
    ?>
        
    <div class="container">
        <div class="page-header">
          <h1>Busqueda de Sacerdotes</h1>
        </div>
        
            <div class = "panel panel-default">
                <div class = "panel-heading">
                    <h3 class = "panel-title">Consulta</h3>
                </div>
                <div class = "panel-body">
                    <div class="form-group">
                        <form>
                            <label>Inrese el nombre del fiel:</label>
                            <input type="text" class="form-control" id="id" name="id" min="0" <?php if(isset($_GET['id']))echo "value='".$_GET['id']."'";?>>
                            <?php
                            if(isset($_GET['id']))
                            {
                                $cer=sacerdote::withname($_GET['id']);
                                if($cer->nombre=="ERROR") echo "<div class='alert alert-danger'><strong>Error!</strong> No se encontro resultados con este ID.</div>";
                            }
                            ?>
                            <button type="submit" class="btn btn-success btn-lg btn-block" name="Buscar" value="true">Buscar</button>
                        </form>
                    </div>
                </div>
            </div>      
            
        
        
            <div class = "panel panel-default">
                <div class = "panel-heading">
                    <h3 class = "panel-title">Resultados de la busqueda</h3>
                </div>
                <div class = "panel-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Nombre</th>
                                <th>Parroquia</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(isset($_GET['id']))
                                {
                                    $cer=sacerdote::withname($_GET['id']);
                                    echo "<td>".$cer->tipo."</td>";
                                    echo "<td>".$cer->nombre."</td>";
                                    echo "<td>".$cer->parroquia."</td>";
                                    
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