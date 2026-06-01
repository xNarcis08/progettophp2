<?php
include("dbconf.php");
session_start();

if(!isset($_SESSION["id_utente"])){
    header("Location: login.php");
    exit();
}
?>
<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <title>Anagrafica</title>
    <link rel="stylesheet" href="css/style.css">
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
    <div class="container container-wide">
		<?php
		$azione = $_GET['azione'] ?? '';
		if($azione == "insertok"){
			echo "<div class='status-msg status-success'>Cliente inserito con successo!</div>";
			$azione = "";
		}
		
		if($azione == ""){ 
			$select="select * from anagrafica where attivo = 1 and canc = 0";
			$result = mysqli_query($conn, $select); 
			$totale = mysqli_num_rows($result)
		?>
			<h1>Anagrafica - Tot. <?php echo $totale ?> 
				<a href="anagrafica.php?azione=nuovo"><img src="images/add.png" width="25px" height="auto" class="icon-btn"></a> 
				<a href="anagrafica.php?azione=cestino"><img src="images/bin.png" width="25px" height="auto" class="icon-btn"></a>
			</h1>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
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
                            <th style="background-color: #0984e3"> Azioni </th>
                        </tr>
                    </thead>
                    <tbody>
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
                        <tr>
                            <td> <?php echo $id ?> </td>
                            <td> <?php echo $nome ?> </td>
                            <td> <?php echo $cognome ?> </td>
                            <td> <?php echo $sesso ?> </td>
                            <td> <?php echo $datadinascita ?> </td>
                            <td> <a href="https://www.google.com/maps/place/<?php echo urlencode($indirizzo . ', ' . $cap . ' ' . $citta . ' ' . $provincia) ?>" target="_blank"> <?php echo $indirizzo ?> </a> </td>
                            <td> <?php echo $cap ?> </td>
                            <td> <?php echo $citta ?> </td>
                            <td> <?php echo $provincia ?> </td>
                            <td> <a href="tel:<?php echo $telefono ?>"><?php echo $telefono ?></a> </td>
                            <td> <a href="https://wa.me/<?php echo $cellulare ?>"><?php echo $cellulare ?></a> </td>
                            <td> <a href="mailto:<?php echo $email ?>"><?php echo $email ?></a> </td>
                            <td>
                                <a href="anagrafica.php?azione=modifica&id=<?php echo $id ?>"><img src="images/edit.png" width="18px" height="auto" class="icon-btn"> </a> &nbsp; 
                                <img src="images/remove.png" width="18px" height="auto" title="Cancella Cliente" alt="Cancella Cliente" onClick="cancella(<?php echo $id ?>);" style="cursor: pointer" class="icon-btn">
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
			<div style="text-align: center; margin-top: 20px;">
			    <a href="pannellocontrollo.php" class="btn btn-back" style="width: auto;">Torna al MENU</a>
            </div>
		<?php
		}
		if($azione == "nuovo"){	
		?>
			<h1>Inserisci Nuovo Cliente</h1>
			<form action="anagrafica.php" method="get">
				<input type="hidden" id="azione" name="azione" value="salva">
				<div class="card" style="max-width: 600px; text-align: left;">
                    <div class="form-group"><label>Nome *</label><input type="text" name="nome" required></div>
                    <div class="form-group"><label>Cognome *</label><input type="text" name="cognome" required></div>
                    <div class="form-group"><label>Sesso</label><input type="text" name="sesso" maxlength="1"></div>
                    <div class="form-group"><label>Data di nascita</label><input type="date" name="datadinascita"></div>
                    <div class="form-group"><label>Indirizzo</label><input type="text" name="indirizzo"></div>
                    <div class="form-group"><label>CAP</label><input type="text" name="cap" maxlength="5"></div>
                    <div class="form-group"><label>Citta</label><input type="text" name="citta"></div>
                    <div class="form-group"><label>Provincia</label><input type="text" name="provincia" maxlength="2"></div>
                    <div class="form-group"><label>Telefono *</label><input type="tel" name="telefono" required></div>
                    <div class="form-group"><label>Cellulare</label><input type="tel" name="cellulare"></div>
                    <div class="form-group"><label>Email *</label><input type="email" name="email" required></div>
                    <input type="submit" value="Salva" class="btn btn-save">
                    <a href="anagrafica.php" class="btn btn-back">Annulla</a>
                </div>
			</form>
		<?php
		}
		if($azione == "modifica"){	
			$id = $_GET["id"];
			$select="select * from anagrafica where id = " . $id;
			$result = mysqli_query($conn, $select);
			while($query = mysqli_fetch_array($result)) {
				$nome = $query["nome"]; $cognome = $query["cognome"]; $sesso = $query["sesso"];
				$datadinascita = $query["data_nascita"]; $indirizzo = $query["indirizzo"];
				$cap = $query["cap"]; $citta = $query["citta"]; $provincia = $query["provincia"];
				$telefono = $query["telefono"]; $cellulare = $query["cellulare"]; $email = $query["email"];
			}
		?>
			<h1>Modifica Cliente</h1>
			<form action="anagrafica.php" method="get">
				<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
				<input type="hidden" id="azione" name="azione" value="aggiorna">
				<div class="card" style="max-width: 600px; text-align: left;">
                    <div class="form-group"><label>Nome *</label><input type="text" name="nome" required value="<?php echo $nome; ?>"></div>
                    <div class="form-group"><label>Cognome *</label><input type="text" name="cognome" required value="<?php echo $cognome; ?>"></div>
                    <div class="form-group"><label>Sesso</label><input type="text" name="sesso" maxlength="1" value="<?php echo $sesso; ?>"></div>
                    <div class="form-group"><label>Data di nascita</label><input type="date" name="datadinascita" value="<?php echo $datadinascita; ?>"></div>
                    <div class="form-group"><label>Indirizzo</label><input type="text" name="indirizzo" value="<?php echo $indirizzo; ?>"></div>
                    <div class="form-group"><label>CAP</label><input type="text" name="cap" maxlength="5" value="<?php echo $cap; ?>"></div>
                    <div class="form-group"><label>Citta</label><input type="text" name="citta" value="<?php echo $citta; ?>"></div>
                    <div class="form-group"><label>Provincia</label><input type="text" name="provincia" value="<?php echo $provincia; ?>"></div>
                    <div class="form-group"><label>Telefono *</label><input type="tel" name="telefono" required value="<?php echo $telefono; ?>"></div>
                    <div class="form-group"><label>Cellulare</label><input type="tel" name="cellulare" value="<?php echo $cellulare; ?>"></div>
                    <div class="form-group"><label>Email *</label><input type="email" name="email" required value="<?php echo $email; ?>"></div>
                    <input type="submit" value="Aggiorna" class="btn btn-save">
                    <a href="anagrafica.php" class="btn btn-back">Annulla</a>
                </div>
			</form>
		<?php
		}
		if($azione == "salva"){
			$nome = $_GET["nome"]; $cognome = $_GET["cognome"]; $sesso = $_GET["sesso"];
			$datadinascita = $_GET["datadinascita"]; $indirizzo = $_GET["indirizzo"];
			$cap = $_GET["cap"]; $citta = $_GET["citta"]; $provincia = $_GET["provincia"];
			$telefono = $_GET["telefono"]; $cellulare = $_GET["cellulare"]; $email = $_GET["email"];
			if($nome != ""){
				$insert = "insert into anagrafica (nome, cognome, sesso, data_nascita, indirizzo, cap, citta, provincia, telefono, cellulare, email, attivo, canc) 
						   values ('$nome', '$cognome', '$sesso', '$datadinascita', '$indirizzo', '$cap', '$citta', '$provincia', '$telefono', '$cellulare', '$email', 1, 0)";
				mysqli_query($conn, $insert);
				echo "<script>window.open('anagrafica.php?azione=insertok', '_top');</script>";
			}
		}
		if($azione == "aggiorna"){
			$id = $_GET["id"]; $nome = $_GET["nome"]; $cognome = $_GET["cognome"]; $sesso = $_GET["sesso"];
			$datadinascita = $_GET["datadinascita"]; $indirizzo = $_GET["indirizzo"];
			$cap = $_GET["cap"]; $citta = $_GET["citta"]; $provincia = $_GET["provincia"];
			$telefono = $_GET["telefono"]; $cellulare = $_GET["cellulare"]; $email = $_GET["email"];
			$update = "update anagrafica set nome='$nome', cognome='$cognome', sesso='$sesso', data_nascita='$datadinascita', indirizzo='$indirizzo', cap='$cap', citta='$citta', provincia='$provincia', telefono='$telefono', cellulare='$cellulare', email='$email' where id=$id";
			mysqli_query($conn, $update);
			echo "<script>window.open('anagrafica.php', '_top');</script>";
		}
		if($azione == "elimina"){
			$id = $_GET["id"];
			mysqli_query($conn, "update anagrafica set canc = 1 where id = $id");
			echo "<script>window.open('anagrafica.php', '_top');</script>";
		}
		if($azione == "recupera"){
			$id = $_GET["id"];
			mysqli_query($conn, "update anagrafica set canc = 0 where id = $id");
			echo "<script>window.open('anagrafica.php?azione=cestino', '_top');</script>";
		}
		if($azione == "cestino"){
		?>
			<h1>Cestino Clienti</h1>
			<div class="table-container">
				<table>
					<thead><tr><th> ID </th><th> Nome </th><th> Cognome </th><th> Azioni </th></tr></thead>
					<tbody>
					<?php
					$result = mysqli_query($conn, "select * from anagrafica where canc = 1");
					while($query = mysqli_fetch_array($result)) {
						$id = $query["id"]; $nome = $query["nome"]; $cognome = $query["cognome"];
					?>
						<tr><td> <?php echo $id ?> </td><td> <?php echo $nome ?> </td><td> <?php echo $cognome ?> </td>
							<td><img src="images/restore.png" width="20px" height="auto" title="Recupera" onClick="recupera(<?php echo $id ?>);" class="icon-btn"></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div style="text-align: center; margin-top: 20px;"><a href="anagrafica.php" class="btn btn-back" style="width: auto;">Torna ad Anagrafica</a></div>
		<?php } ?>
    </div>
</body>
</html>
