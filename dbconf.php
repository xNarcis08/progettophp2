<?php


$host = "localhost";
$port = "3306";
$username = "root";
$password = "";
$database = "progettophp2";
	
$conn = mysqli_connect($host, $username, $password, $database, $port) or die("errore di conessione a mysql");
?>