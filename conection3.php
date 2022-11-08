<?php
    function conexion(){
        $conexion= mysqli_connect('localhost','root','123456','dbschool','3306');
        return $conexion;
    }
?>