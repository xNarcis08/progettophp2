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
    <title>Anagrafica</title>
	
	<script>
		function cancella(id){
			if(confirm("Vuoi eliminare il cliente selezionato ?")){
				window.open("anagrafica.php?azione=elimina&id="+id, "_top");
			}
		}
		function recupera(id){
			if(confirm("Vuoi recuperare il cliente selezionato ?")){
				window.open("anagrafica.php?azione=recupera&id="+id, "_top");
			}
		}
	</script>
	
</head>
<body>
	<?php
	$azione = $_GET['azione'] ?? '';
	//echo "azione: " . $azione . "<br>";
	
	if($azione == "insertok"){
		echo "<center><span style='color:green'><b>Cliente inserito con successo!</b></span></center>";
		$azione = "";
	}
	
	if($azione == ""){ //empty = "", 0 o null
	?>
		<center>
			<?php
				$select="select * from anagrafica where attivo = 1 and canc = 0";
				$result = mysqli_query($conn, $select); 
				$totale = mysqli_num_rows($result)
			?>
			<h1>Anagrafica - Tot. <?php echo $totale ?> 
				<a href="anagrafica.php?azione=nuovo"><img src="images/add.png" width="20px" height="auto"></a> 
				<a href="anagrafica.php?azione=cestino"><img src="images/bin.png" width="20px" height="auto"></a>
			</h1>
			<table>
				<thead>
					<tr style="background-color: brown; color: white;">
						<th> ID </th>
						<th> Nome </th>
						<th> Cognome </th>
						<th> Sesso </th>
						<th> Data di Nascita </th>
						<th> Indirizzo </th>
						<th> CAP </th>
						<th> Citta </th>
						<th> Provincia </th>
						<th> Telefono </th>
						<th> Cellulare </th>
						<th> Email </th>
						<th style="background-color: blue">  Azioni &nbsp;  </th>

					</tr>
					</thead>
				<?php

				while($query = mysqli_fetch_array($result))
				{
					$id = $query["id"];
					$nome = $query["nome"];
					$cognome = $query["cognome"];
					$sesso = $query["sesso"];
					$datadinascita = $query["data_nascita"];
					
					//2026-04-11
					$anno_nascita = substr($datadinascita,0,4);
					$mese_nascita = substr($datadinascita,5,2);
					$giorno_nascita = substr($datadinascita,8,2);
					$datadinascita = $giorno_nascita . "-" . $mese_nascita . "-" . $anno_nascita;
					
					$indirizzo = $query["indirizzo"];
					$cap = $query["cap"];
					$citta = $query["citta"];
					$provincia = $query["provincia"];
					$telefono = $query["telefono"];
					$cellulare = $query["cellulare"];
					$email = $query["email"];
				?>


				<tbody>
					<tr style="height: 22px">
						<td> <?php echo $id ?> </td>
						<td> <?php echo $nome ?> </td>
						<td> <?php echo $cognome ?> </td>
						<td> <?php echo $sesso ?> </td>
						<td> <?php echo $datadinascita ?> </td>
						<td> <a href="https://www.google.com/maps/place/<?php echo $indirizzo ?>,+<?php echo $cap ?>+<?php echo $citta ?>+<?php echo $provincia ?>/@44.6780158,11.0407445,17z/data=!4m6!3m5!1s0x477fe9ed09ed96f5:0x951b40fdcfed0d8b!8m2!3d44.678279!4d11.040825!16s%2Fg%2F11csd90q1r?entry=ttu&g_ep=EgoyMDI2MDQwMS4wIKXMDSoASAFQAw%3D%3D" target="_blank"> <?php echo $indirizzo ?> </a> </td>
						<td> <?php echo $cap ?> </td>
						<td> <?php echo $citta ?> </td>
						<td> <?php echo $provincia ?> </td>
						<td> <a href="tel:<?php echo $telefono ?>"><?php echo $telefono ?></a> </td>
						<td> <a href="https://wa.me/<?php echo $cellulare ?>?text=buongiorno sono narcis."><?php echo $cellulare ?></a> </td>
						<td> <a href="mailto:<?php echo $email ?>?subject=ordine num 3246&message=buongiorno, "><?php echo $email ?></a> </td>
						<td>
							<a href="anagrafica.php?azione=modifica&id=<?php echo $id ?>"><img src="images/edit.png" width="20px" height="auto"> </a> &nbsp; 
							<img src="images/remove.png" width="20px" height="auto" title="Cancella Cliente" alt="Cancella Cliente" onClick="cancella(<?php echo $id ?>);" style="cursor: pointer">
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
		<h1>Inserisci Nuovo Cliente</h1>
		
		<form action="anagrafica.php" method="get">
			<input type="hidden" id="azione" name="azione" value="salva">
			<table> 
				<tr>
					<td style="color: red">Nome *: </td>
					<td>
						<input type="text" id="nome" name="nome" required placeholder="Inserisci il tuo nome"> 
					</td>
				</tr>
				
				<tr>
					<td style="color: red">Cognome *:</td>
					<td>  <input type="text" id="cognome" name="cognome" required placeholder="Inserisci il tuo cognome"> </td>
				</tr>
				
				<tr>
					<td>Sesso:</td>
					<td>  <input type="text" id="sesso" name="sesso" placeholder="Inserisci il tuo sesso" maxlength="1"> </td>
				</tr>

				<tr>
					<td>Data di nascita:</td>
					<td>  <input type="date" id="datadinascita" name="datadinascita" placeholder="Inserisci la tua data di nascita"> </td>
				</tr>				
				
				<tr>
					<td>Indirizzo:</td>
					<td>  <input type="text" id="indirizzo" name="indirizzo" placeholder="Inserisci il tuo indirizzo"> </td>
				</tr>
				
				<tr>
					<td>CAP:</td>
					<td>  <input type="text" id="cap" name="cap" placeholder="Inserisci il tuo CAP" maxlength="5"> </td>
				</tr>
				
				<tr>
					<td>Citta:</td>
					<td>  <input type="text" id="citta" name="citta" placeholder="Inserisci la tua citta"> </td>
				</tr>
				
				<tr>
					<td>Provincia:</td>
					<td>  <input type="text" id="provincia" name="provincia" placeholder="Inserisci la tua provincia"> </td>
				</tr>
				
				<tr>
					<td style="color: red">Telefono *:</td>
					<td>  <input type="tel" id="telefono" name="telefono" required placeholder="Inserisci il tuo telefono"> </td>
				</tr>
				
				<tr>
					<td>Cellulare:</td>
					<td>  <input type="tel" id="cellulare" name="cellulare" placeholder="Inserisci il tuo cellulare"> </td>
				</tr>
				
				<tr>
					<td style="color: red">Email *:</td>
					<td>  <input type="email" id="email" name="email" required placeholder="Inserisci il tuo email"> </td>
				</tr>
				
				<tr>
					<td> <input type="submit" value="Salva"></td>
					<td> <a href="anagrafica.php"><input type="button" value="Torna ad Anagrafica"></a></td>
				</tr>

			</table>
			
		</form>
	</center>
	<?php
	}
	if($azione == "modifica"){	
		$id = $_GET["id"];
		
		$select="select * from anagrafica where attivo = 1 and canc = 0 and id = " . $id;
		$result = mysqli_query($conn, $select);
		
		while($query = mysqli_fetch_array($result))
		{
			$nome = $query["nome"];
			$cognome = $query["cognome"];
			$sesso = $query["sesso"];
			$datadinascita = $query["data_nascita"];	
			$indirizzo = $query["indirizzo"];
			$cap = $query["cap"];
			$citta = $query["citta"];
			$provincia = $query["provincia"];
			$telefono = $query["telefono"];
			$cellulare = $query["cellulare"];
			$email = $query["email"];
		}
	?>
	<center>
		<h1>Modifica Cliente</h1>
		
		<form action="anagrafica.php" method="get">
			<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
			<input type="hidden" id="azione" name="azione" value="aggiorna">
			<table> 
				<tr>
					<td style="color: red">Nome *: </td>
					<td>
						<input type="text" id="nome" name="nome" required placeholder="Inserisci il tuo nome" value="<?php echo $nome; ?>"> 
					</td>
				</tr>
				
				<tr>
					<td style="color: red">Cognome *:</td>
					<td>  <input type="text" id="cognome" name="cognome" required placeholder="Inserisci il tuo cognome" value="<?php echo $cognome; ?>"> </td>
				</tr>
				
				<tr>
					<td>Sesso:</td>
					<td>  <input type="text" id="sesso" name="sesso" placeholder="Inserisci il tuo sesso" maxlength="1" value="<?php echo $sesso; ?>" > </td>
				</tr>

				<tr>
					<td>Data di nascita:</td>
					<td>  <input type="date" id="datadinascita" name="datadinascita" placeholder="Inserisci la tua data di nascita" value="<?php echo $datadinascita; ?>"></td>
				</tr>				
				
				<tr>
					<td>Indirizzo:</td>
					<td>  <input type="text" id="indirizzo" name="indirizzo" placeholder="Inserisci il tuo indirizzo" value="<?php echo $indirizzo; ?>"> </td>
				</tr>
				
				<tr>
					<td>CAP:</td>
					<td>  <input type="text" id="cap" name="cap" placeholder="Inserisci il tuo CAP" maxlength="5" value="<?php echo $cap; ?>"> </td>
				</tr>
				
				<tr>
					<td>Citta:</td>
					<td>  <input type="text" id="citta" name="citta" placeholder="Inserisci la tua citta" value="<?php echo $citta; ?>"> </td>
				</tr>
				
				<tr>
					<td>Provincia:</td>
					<td>  <input type="text" id="provincia" name="provincia" placeholder="Inserisci la tua provincia" value="<?php echo $provincia; ?>"> </td>
				</tr>
				
				<tr>
					<td style="color: red">Telefono *:</td>
					<td>  <input type="tel" id="telefono" name="telefono" required placeholder="Inserisci il tuo telefono" value="<?php echo $telefono; ?>"> </td>
				</tr>
				
				<tr>
					<td>Cellulare:</td>
					<td>  <input type="tel" id="cellulare" name="cellulare" placeholder="Inserisci il tuo cellulare" value="<?php echo $cellulare; ?>"> </td>
				</tr>
				
				<tr>
					<td style="color: red">Email *:</td>
					<td>  <input type="email" id="email" name="email" required placeholder="Inserisci il tuo email" value="<?php echo $email; ?>"> </td>
				</tr>
				
				<tr>
					<td> <input type="submit" value="Aggiorna"></td>
					<td> <a href="anagrafica.php"><input type="button" value="Torna ad Anagrafica"></a></td>
				</tr>

			</table>
			
		</form>
	</center>
	<?php
	}
	if($azione == "salva"){
			
		$nome = $_GET["nome"];
		$cognome = $_GET["cognome"];
		$sesso = $_GET["sesso"];
		$datadinascita = $_GET["datadinascita"];
		$indirizzo = $_GET["indirizzo"];
		$cap = $_GET["cap"];
		$citta = $_GET["citta"];
		$provincia = $_GET["provincia"];
		$telefono = $_GET["telefono"];
		$cellulare = $_GET["cellulare"];
		$email = $_GET["email"];
		
		if($nome != ""){
			$insert = "INSERT INTO `anagrafica`
					(`nome`, `cognome`, `sesso`, `data_nascita`, `indirizzo`, `cap`, `citta`, `provincia`, `telefono`, `cellulare`, `email`) VALUES ('$nome','$cognome','$sesso','$datadinascita','$indirizzo','$cap','$citta','$provincia','$telefono','$cellulare','$email')";
			echo $insert;
			mysqli_query($conn, $insert);
		}
		
		header("Location: http://localhost/php2/anagrafica.php?azione=insertok");
		exit;
		$azione = "";
	}
	if($azione == "aggiorna"){
			
		$id = $_GET["id"];
		$nome = $_GET["nome"];
		$cognome = $_GET["cognome"];
		$sesso = $_GET["sesso"];
		$datadinascita = $_GET["datadinascita"];
		$indirizzo = $_GET["indirizzo"];
		$cap = $_GET["cap"];
		$citta = $_GET["citta"];
		$provincia = $_GET["provincia"];
		$telefono = $_GET["telefono"];
		$cellulare = $_GET["cellulare"];
		$email = $_GET["email"];
		
		$update = "UPDATE `anagrafica` 
					SET `nome`='$nome',
						`cognome`='$cognome',
						`sesso`='$sesso',
						`data_nascita`='$datadinascita',
						`indirizzo`='$indirizzo',
						`cap`='$cap',
						`citta`='$citta',
						`provincia`='$provincia',
						`telefono`='$telefono',
						`cellulare`='$cellulare',
						`email`='$email' 
					WHERE id = $id";
		
		echo $update;
		mysqli_query($conn, $update);
		
		
		header("Location: http://localhost/php2/anagrafica.php");
		exit;
		$azione = "";
	}
	// nuova funzione cestino
	if($azione == "cestino"){
	?>
		<center>
			<?php
				$select="select * from anagrafica where attivo = 0 and canc = 1";
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
						<th> Nome </th>
						<th> Cognome </th>
						<th> Sesso </th>
						<th> Data di Nascita </th>
						<th> Indirizzo </th>
						<th> CAP </th>
						<th> Citta </th>
						<th> Provincia </th>
						<th> Telefono </th>
						<th> Cellulare </th>
						<th> Email </th>
						<th style="background-color: blue">  Azioni &nbsp;  </th>
					</tr>
				</thead>
				<?php
				while($query = mysqli_fetch_array($result))
				{
					$id = $query["id"];
					$nome = $query["nome"];
					$cognome = $query["cognome"];
					$sesso = $query["sesso"];
					$datadinascita = $query["data_nascita"];
					
					$anno_nascita = substr($datadinascita,0,4);
					$mese_nascita = substr($datadinascita,5,2);
					$giorno_nascita = substr($datadinascita,8,2);
					$datadinascita = $giorno_nascita . "-" . $mese_nascita . "-" . $anno_nascita;
					
					$indirizzo = $query["indirizzo"];
					$cap = $query["cap"];
					$citta = $query["citta"];
					$provincia = $query["provincia"];
					$telefono = $query["telefono"];
					$cellulare = $query["cellulare"];
					$email = $query["email"];
				?>
				<tbody>
					<tr style="height: 22px">
						<td> <?php echo $id ?> </td>
						<td> <?php echo $nome ?> </td>
						<td> <?php echo $cognome ?> </td>
						<td> <?php echo $sesso ?> </td>
						<td> <?php echo $datadinascita ?> </td>
						<td> <a href="https://www.google.com/maps/place/<?php echo $indirizzo ?>,+<?php echo $cap ?>+<?php echo $citta ?>+<?php echo $provincia ?>/@44.6780158,11.0407445,17z/data=!4m6!3m5!1s0x477fe9ed09ed96f5:0x951b40fdcfed0d8b!8m2!3d44.678279!4d11.040825!16s%2Fg%2F11csd90q1r?entry=ttu&g_ep=EgoyMDI2MDQwMS4wIKXMDSoASAFQAw%3D%3D" target="_blank"> <?php echo $indirizzo ?> </a> </td>
						<td> <?php echo $cap ?> </td>
						<td> <?php echo $citta ?> </td>
						<td> <?php echo $provincia ?> </td>
						<td> <a href="tel:<?php echo $telefono ?>"><?php echo $telefono ?></a> </td>
						<td> <a href="https://wa.me/<?php echo $cellulare ?>?text=buongiorno sono narcis."><?php echo $cellulare ?></a> </td>
						<td> <a href="mailto:<?php echo $email ?>?subject=ordine num 3246&message=buongiorno, "><?php echo $email ?></a> </td>
						<td>
							<img src="images/recover.png" width="20px" height="auto" title="Recupera Cliente" alt="Recupera Cliente" onClick="recupera(<?php echo $id ?>);" style="cursor: pointer">
						</td>
					</tr>
				</tbody>
				<?php
				}
				?>
			</table>
			<br>
			<button onclick="window.location.href='anagrafica.php'">Torna all'anagrafica</button>
		</center>
	<?php
	}
	// recupera cliente canc = 0 attivo 1 -> menu principale
	if($azione == "recupera"){
		$id = $_GET["id"];
		
		$update = "UPDATE `anagrafica` SET canc = 0, attivo = 1 WHERE id = " . $id;
		echo $update;
		mysqli_query($conn, $update);
		
		header("Location: http://localhost/php2/anagrafica.php?azione=cestino");
		exit;
	}
	// aggiunto attivo = 0
	
	if($azione == "elimina"){
		$id = $_GET["id"];
		
		$delete = "UPDATE `anagrafica` SET canc = 1, attivo = 0 WHERE id = " . $id;
		echo $delete;
		mysqli_query($conn, $delete);	
		
		header("Location: http://localhost/php2/anagrafica.php");
		exit;
	}
	
	?>
</body>
</html>
