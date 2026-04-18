<?php
//<<<<< per docente fabio
	
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
    <title>Utenti</title>
	
	<script>
		function cancella(id){
			if(confirm("Vuoi eliminare il utente selezionato ?")){
				window.open("utenti.php?azione=elimina&id="+id, "_top");
			}
		}
		function recupera(id){
			if(confirm("Vuoi recuperare il utente selezionato ?")){
				window.open("utenti.php?azione=recupera&id="+id, "_top");
			}
		}
	</script>
	
</head>
<body>
	<?php
	$azione = $_GET['azione'];
	//echo "azione: " . $azione . "<br>";
	
	if($azione == "insertok"){
		echo "<center><span style='color:green'><b>Utente inserito con successo!</b></span></center>";
		$azione = "";
	}
	
	if(empty($azione)){ //empty = "", 0 o null
	?>
		<center>
			<?php
				$select="select * from utenti where attivo = 1 and canc = 0";
				$result = mysqli_query($conn, $select); 
				$totale = mysqli_num_rows($result)
			?>
			<h1>Utenti - Tot. <?php echo $totale ?> 
				<a href="utenti.php?azione=nuovo"><img src="images/add.png" width="20px" height="auto"></a> 
				<a href="utenti.php?azione=cestino"><img src="images/bin.png" width="20px" height="auto"></a>
			</h1>
			<table>
				<thead>
					<tr style="background-color: brown; color: white;">
						<th> ID </th>
						<th> Username </th>
						<th> Password </th>
						<th> Email </th>
						<th style="background-color: blue">  Azioni &nbsp;  </th>

					</tr>
					</thead>
				<?php

				while($query = mysqli_fetch_array($result))
				{
					$id = $query["id"];
					$username = $query["username"];
					$password = $query["password"];
					$email = $query["email"];
				?>


				<tbody>
					<tr style="height: 22px">
						<td> <?php echo $id ?> </td>
						<td> <?php echo $username ?> </td>
						<td> <?php echo $password ?> </td>
						<td> <a href="mailto:<?php echo $email ?>?subject=ordine num 3246&message=buongiorno, "><?php echo $email ?></a> </td>
						<td>
							<a href="utenti.php?azione=modifica&id=<?php echo $id ?>"><img src="images/edit.png" width="20px" height="auto"> </a> &nbsp; 
							<img src="images/remove.png" width="20px" height="auto" title="Cancella Utente" alt="Cancella Utente" onClick="cancella(<?php echo $id ?>);" style="cursor: pointer">
						</td>


					</tr>
				</tbody>

						<?php
					//echo $id . " - " . $nome . "<br>". $cognome. "<br>". $sesso . " - " . $datadinascita. "<br>". $indirizzo . " - " . $cap ."<br>". $citta . " - " . $provincia. "<br>". $telefono . " - " . $cellulare. "<br>". $email . "<br><br>";

				}		

				?>
			</table>

			<br>
			<button onclick="window.location.href='pannellocontrollo.php'">Torna al MENU</button>
		</center>
	<?php
	}
	if($azione == "nuovo"){	
	?>
	<center>
		<h1>Inserisci Nuovo Utente</h1>
		
		<form action="utenti.php" method="get">
			<input type="hidden" id="azione" name="azione" value="salva">
			<table> 
				<tr>
					<td style="color: red">Username *: </td>
					<td>
						<input type="text" id="username" name="username" required placeholder="Inserisci il tuo Username"> 
					</td>
				</tr>
				
				<tr>
					<td style="color: red">Password *:</td>
					<td>  <input type="text" id="password" name="password" required placeholder="Inserisci la tua password"> </td>
				</tr>
				
				<tr>
					<td style="color: red">Email *:</td>
					<td>  <input type="email" id="email" name="email" required placeholder="Inserisci il tuo email"> </td>
				</tr>
				
				<tr>
					<td> <input type="submit" value="Salva"></td>
					<td> <a href="utenti.php"><input type="button" value="Torna ad Utenti"></a></td>
				</tr>

			</table>
			
		</form>
	</center>
	<?php
	}
	if($azione == "modifica"){	
		$id = $_GET["id"];
		
		$select="select * from utenti where attivo = 1 and canc = 0 and id = " . $id;
		$result = mysqli_query($conn, $select);
		
		while($query = mysqli_fetch_array($result)){
		
			$username = $query["username"];
			$password = $query["password"];
			$email = $query["email"];
			
		}
	?>
	<center>
		<h1>Modifica Utenti</h1>
		
		<form action="utenti.php" method="get">
			<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
			<input type="hidden" id="azione" name="azione" value="aggiorna">
			<table> 
				<tr>
					<td style="color: red">Username *: </td>
					<td>
						<input type="text" id="username" name="username" required placeholder="Inserisci il tuo username" value="<?php echo $username; ?>"> 
					</td>
				</tr>
				
				<tr>
					<td style="color: red">Password *: </td>
					<td>
						<input type="text" id="password" name="password" required placeholder="Inserisci la Nuova Password" value="<?php echo $password; ?>"> 
					</td>
				</tr>
				
				<tr>
					<td style="color: red">Email *:</td>
					<td>  <input type="email" id="email" name="email" required placeholder="Inserisci il tuo email" value="<?php echo $email; ?>"> </td>
				</tr>
				
				<tr>
					<td> <input type="submit" value="Aggiorna"></td>
					<td> <a href="utenti.php"><input type="button" value="Torna ad Utenti"></a></td>
				</tr>

			</table>
			
		</form>
	</center>
	<?php
	}
	if($azione == "salva"){
		
		$username = $_GET["username"];
		$password = $_GET["password"];
		$email = $_GET["email"];
		
		//if($username != ""){
			$insert = "INSERT INTO `utenti`
					(`username`, `password`, `email`) VALUES ('$username',PASSWORD('$password'),'$email')";
			//echo "insert utente: " . $insert;
			mysqli_query($conn, $insert);
		//}
		
		header("Location: http://localhost/php2/utenti.php?azione=insertok");
		exit;
		$azione = "";
	}
	if($azione == "aggiorna"){
			
		$id = $_GET["id"];
		$username = $_GET["username"];
		$password = $_GET["password"];
		$email = $_GET["email"];
		
		$update = "UPDATE `utenti` 
					SET `username`='$username',
						`password`= PASSWORD('$password'),
						`email`='$email' 
					WHERE id = $id";
		
		//echo $update;
		mysqli_query($conn, $update);
		
		
		header("Location: http://localhost/php2/utenti.php");
		exit;
		$azione = "";
	}
	// nuova funzione cestino
	if($azione == "cestino"){
	?>
		<center>
			<?php
				$select="select * from utenti where attivo = 0 and canc = 1";
				$result = mysqli_query($conn, $select); 
				$totale = mysqli_num_rows($result)
			?>
			<h1>Cestino - Tot. <?php echo $totale ?> 
				<img src="images/bin.png" width="20px" height="auto">
			</h1>
			<table>
				<thead>
					<tr style="background-color: brown; color: white;">
						<th> ID </th>
						<th> Username </th>
						<th> Password </th>
						<th> Email </th>
						<th style="background-color: blue">  Azioni &nbsp;  </th>
					</tr>
				</thead>
				<?php
				while($query = mysqli_fetch_array($result))
				{
					$id = $query["id"];
					$username = $query["username"];
					$password = $query["password"];
					$email = $query["email"];
				?>
				<tbody>
					<tr style="height: 22px">
						<td> <?php echo $id ?> </td>
						<td> <?php echo $username ?> </td>
						<td> <?php echo $password ?> </td>
						<td> <a href="mailto:<?php echo $email ?>?subject=ordine num 3246&message=buongiorno, "><?php echo $email ?></a> </td>
						<td>
							<img src="images/recover.png" width="20px" height="auto" title="Recupera Utente" alt="Recupera Utenti" onClick="recupera(<?php echo $id ?>);" style="cursor: pointer">
						</td>
					</tr>
				</tbody>
				<?php
				}
				?>
			</table>
			<br>
			<button onclick="window.location.href='utenti.php'">Torna all'utenti</button>
		</center>
	<?php
	}
	// recupera cliente canc = 0 attivo 1 -> menu principale
	if($azione == "recupera"){
		$id = $_GET["id"];
		
		$update = "UPDATE `utenti` SET canc = 0, attivo = 1 WHERE id = " . $id;
		echo $update;
		mysqli_query($conn, $update);
		
		header("Location: http://localhost/php2/utenti.php?azione=cestino");
		exit;
	}
	// aggiunto attivo = 0
	
	if($azione == "elimina"){
		$id = $_GET["id"];
		
		$delete = "UPDATE `utenti` SET canc = 1, attivo = 0 WHERE id = " . $id;
		echo $delete;
		mysqli_query($conn, $delete);	
		
		header("Location: http://localhost/php2/utenti.php");
		exit;
	}
	
	?>
</body>
</html>
