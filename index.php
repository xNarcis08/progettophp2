<!doctype html>
<html lang="en">


<?php
include "dbconf.php";
?>

<head>   
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>PHP Test</title>
</head>
<body>
<h1>PHP Test</h1>

    Data oggi:

<?php
echo date("d.m.Y H:i:s");

$qta = 2; // intero
$prezzo = 49.99; // double = intero+ decimale
$indirizzo = "Via Roma 1"; // stringa
$data Oggi = date("d/m/Y"); // data
$datamysql = date("Y-d-m"); // data in formato mysql
$isSet = true; // booleano
$sconto = null;

//

if (qta > 3 || sconto ) {
    echo "";
} else (qta <3 && prezzo > 20 && sconto == 5%) {
    echo "";
}

if ($isSet == true) {
    echo "La variabile è stata impostata";
} else if ($qta >= 2 || $prezzo >= 30) {
    echo "La variabile non è stata impostata";
}
else {
    echo "La variabile non è stata impostata e la quantità è inferiore a 2";
}

switch ($qta) {
    case 1:
        //faccio 1
        break;
    case 2:
        //faccio 2
        break;
    default:
        //faccio 3
}

$elencoProdoti = array()
$elencoProdoti[0] = "Prodotto 1";
$elencoProdoti[1] = "Prodotto 2";
$elencoProdoti[2] = "Prodotto 3";
$elencoProdoti[3] = "Prodotto 4";
$elencoProdoti[4] = "Prodotto 5";

echo "<br><br>Elenco prodotti FOR:</br>";

for ($i = 0; $i < count($elencoProdoti); $i++) {
    echo $elencoProdoti[$i] . "<br>";
}

echo "<br><br>Elenco prodotti WHILE:</br>";

$p = 0;

while($p < count($elencoProdoti)) {
    echo "<b>" . $elencoProdoti[$p] . "</b><br>";
    $p++;

}

$host = "localhost";
$port = "3306";
$username = "root";
$password = "";
$database = "progettophp2";
	
$conn = mysqli_connect($host, $username, $password, $database, $port) or die("errore di conessione a mysql");



?>
</body></html>