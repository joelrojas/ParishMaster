<?php
/**
 * Created by PhpStorm.
 * User: Pamela
 * Date: 8/31/2016
 * Time: 3:45 PM
 */

$config = array(
    "db" => array(
        "db1" => array(
            "dbname" => "parishmaster",
            "username" => "root",
            "password" => "",
            "host" => "localhost"
        ),
        "db2" => array(
            "dbname" => "database2",
            "username" => "dbUser",
            "password" => "pa$$",
            "host" => "localhost"
        )
    ),
    "urls" => array(
        "baseUrl" => "http://http://parishmaster.gwiddle.co.uk"
    ),
    "paths" => array(
        "resources" => "/path/to/resources",
        "images" => array(
            "content" => $_SERVER["DOCUMENT_ROOT"] . "/images/content",
            "layout" => $_SERVER["DOCUMENT_ROOT"] . "/images/layout"
        )
    )
);


?>