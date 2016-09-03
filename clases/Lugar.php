<?php

/**
 * Created by PhpStorm.
 * User: Pamela
 * Date: 9/3/2016
 * Time: 6:39 PM
 */
class Lugar
{
    private $lugar;

    public function __construct($lugar)
    {
        $this->lugar = $lugar;
    }

    public function GetAll(){
        $q="select * from lugar";
        echo $q;
        $res=$this->dbh->exequery($q);
        if(!$res) die('Invalid query'.mysql_error());
        return $res;
    }
}