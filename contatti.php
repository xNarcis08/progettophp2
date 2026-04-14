<?php
include("dbconf.php");
session_start();

if(!isset($_SESSION["id_utente"])){
    header("Location: login.php");
    exit();
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contatti</title>
</head>
<body>
    <center>
        <h1>Pagina Contatti</h1>
        <p>Qui puoi trovare i nostri contatti.</p>
        
        <br>
        <button onclick="window.location.href='pannellocontrollo.php'">Torna al MENU</button>
    </center>
</body>
</html>