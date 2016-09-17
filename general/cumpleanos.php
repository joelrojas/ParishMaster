<?php
/**
 * Created by PhpStorm.
 * User: Pamela
 * Date: 9/17/2016
 * Time: 3:09 PM
 */

    function WhoseBirthdayIsToday($dbh){
        $q="select cuenta.email from persona,cuenta where persona.idPersona=cuenta.idPersona 
            and day(curdate()) = day(persona.fechanac)
            and month(curdate()) = month(persona.fechanac)";

        $res=$dbh->exequery($q);
        if ($dbh->mysqli->error)
        {
            printf("Errormessage: %s\n", $dbh->mysqli->error);
        }
        return $res;
    }


    require_once '/home/Knightess/web/parishmaster.gwiddle.co.uk/public_html/clases/dbaccess.php';
    $dbh=DatabaseHandler::Instance();
    $dbh->init($dbh->getDb());
    $conexion=$dbh->connecttodb();

    $res=WhoseBirthdayIsToday($dbh);
    $para="";

    $cont=1;
    while($fila=$res->fetch_array(MYSQLI_ASSOC)){
        if($cont==1) $para=$fila['email'];
        else $para=$para.", ".$fila['email'];
        $cont++;
    }

    if($para!=""){
        $asunto="Feliz Cumpleaños te desea la iglesia catolica Boliviana!";
        $mensaje=
            "Que la fe, la esperanza y el amor llenen cada uno de tus días!
        Feliz Cumpleaños! 
        Conferencia Episcopal Boliviana";
        $headers = 'From: Conferencia Episcopal Boliviana <contacto@parishmaster.gwiddle.co.uk>'. "\r\n" .
            'Reply-To:Conferencia Episcopal Boliviana <contacto@parishmaster.gwiddle.co.uk>' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        mail($para, $asunto, $mensaje, $headers);
    }






?>