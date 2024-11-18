<?php

class DataBase{
    public static function connect($host= "localhost", $user="root", $pass="",$db="database"){
        $con = new mysqli($host,$user,$pass,$db);

        if($con == false){
            die("ERROR; No te puedes conectar" . $con->connect_error);
        }

        return $con;
    }
}


?>