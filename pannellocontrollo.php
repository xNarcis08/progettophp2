<?php
include("dbconf.php");
session_start();

if(!isset($_SESSION["id_utente"])){
	?>
	<script language="javascript" type="application/javascript">
		window.open("login.php","_top");
	</script>
	<?php
}
?>

<!doctype html>
<html style="font-family: Segoe UI; ">
<head>
<meta charset="utf-8">
<title>Pannello di Controllo</title>

	
	<script>
		function exit(){
			if(confirm("vuoi davvero uscire?")){
			   window.open("login.php?azione=logout","_top");
			}
		}
	</script>
	
</head>

<body>
	<center>
		<h2>Pannello di Controllo</h2>
		
		Benvenuto, <?php echo $_SESSION["username"]; ?><br> <br>
		
		<?php
		/* esercizio 1
		1. creare una tabella mysql in phpmyadmin MENU con campi id, voce, url, attiva, canc |
		2. voci = anagrafica, contatti e esci |
		3. in questa pagina php fare select del menu e mettere tutti i button dei menu al centro che vanno alle relative pagine. | 
		4. creare le 2 pagine anagrafica.php e contatti.php  | 
		*/
		$select = "select * from menu where attivo = 1 and canc = 0";
		$result = mysqli_query($conn, $select);
		
		while($query = mysqli_fetch_array($result))
		{
			$voce = $query["voce"];
			$url = $query["url"];
			
			?>
			<a href="<?php echo $url;  ?>">		<button style="width: 80px; border-bottom-color: #B7F102; border-radius: 12px; text-align: center; background-color: #B7F102; font-family: 'Trebuchet MS'; "><?php echo $voce;  ?></button></a> <br> <br>
			<?php
			
		}		
		?>
		<button style="width: 80px; border-bottom-color: #B7F102; border-radius: 12px; text-align: center; background-color: #B7F102; font-family: 'Trebuchet MS'; " onClick="exit()">Esci</button> <br>
		
	</center>
</body>
</html>