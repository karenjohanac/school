<?php
    $Chost = "localhost";
    $Cuser = "root";
    $Cpass = "123456";
    $Cdb = "dbschool";

$con = new mysqli($Chost,$Cuser,$Cpass,$Cdb);

if($con->connect_errno){
    die("Ha ocurrido un error");
}

?>