<?php

class DataBase{
    public static function connect($host= "localhost", $user="root", $pass="1234",$db="decathloneats", $port = 3307){
        $con = new mysqli($host,$user,$pass,$db, $port);
        
        if($con == false){
            die("ERROR; No te puedes conectar" . $con->connect_error);
        }
        return $con;
    }
}


?>