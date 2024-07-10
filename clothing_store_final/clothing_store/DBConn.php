<?php

// getting the server info
$server = (string) "localhost";
$username = (string) "root";
$password = (string) "";
$database = (string) "clothingstore";
$port_number = (int) 3306;

$connect = mysqli_connect($server, $username, $password, $database, $port_number);
?>