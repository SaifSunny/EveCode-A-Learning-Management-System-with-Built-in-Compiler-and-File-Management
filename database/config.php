<?php 

$server = "localhost";
$user = "root";
$pass = "";
$database = "evecode";

$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die(mysql_error());
}

?>