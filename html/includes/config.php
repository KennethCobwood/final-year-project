<?php 

$server = "localhost";
$user = "root";
$pass = "123";
$database = "container_maker";

$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die('Connection Failed');
}

?>
