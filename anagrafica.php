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
<html lang="it">
<head>
    <meta charset="utf-8">
    <title>Anagrafica</title>
    <style>
        /* Design Moderno e Fresh - Coerente con il Pannello di Controllo */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            color: #333;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            margin: 20px auto;
            width: 95%;
            max-width: 1200px;
        }
        h1 {
            color: #2d3436;
            text-align: center;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }
        .table-container {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 12px;
            overflow: hidden;
        }
        th {
            background-color: #2d3436;
            color: white;
            padding: 12px;
            text-align: left;
            font-size: 14px;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .btn {
            display: inline-block;
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            background-color: #B7F102;
            color: #2d3436;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 14px;
            text-align: center;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            filter: brightness(1.05);
        }
        .btn-back {
            background-color: #6c757d;
            color: white;
            margin-top: 20px;
        }
        .btn-save {
            background-color: #2ecc71;
            color: white;
            width: 100%;
        }
        input[type="text"], input[type="email"], input[type="tel"], input[type="date"], textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
        }
        .form-table {
            max-width: 600px;
            margin: auto;
        }
        .form-table td {
            border: none;
        }
        .status-msg {
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .status-success {
            background-color: #d4edda;
            color: #155724;
        }
        .icon-btn {
            cursor: pointer;
            transition: transform 0.2s;
        }
        .icon-btn:hover {
            transform: scale(1.2);
        }
    </style>
	
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
    <div class="container">
		<?php
		$azione = $_GET['azione'] ?? '';
		
		if($azione == "insertok"){
			echo "<div class='status-msg status-success'>Cliente inserito con successo!</div>";
			$azione = "";
		}
		
		if($azione == ""){ 
		?>
				<?php
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
                        <?php
                        }		
                        ?>
                        </tbody>
                    </table>
                </div>
				<div style="text-align: center;">
				    <a href="pannellocontrollo.php" class="btn btn-back">Torna al Menu</a>
                </div>
		<?php
		}
		if($azione == "nuovo"){	
		?>
			<h1>Inserisci Nuovo Cliente</h1>
			
			<form action="anagrafica.php" method="get">
				<input type="hidden" id="azione" name="azione" value="salva">
				<table class="form-table"> 
					<tr>
						<td style="color: #d63031; font-weight: bold;">Nome *: </td>
						<td><input type="text" id="nome" name="nome" required placeholder="Inserisci il tuo nome"></td>
					</tr>
					<tr>
						<td style="color: #d63031; font-weight: bold;">Cognome *:</td>
						<td><input type="text" id="cognome" name="cognome" required placeholder="Inserisci il tuo cognome"></td>
					</tr>
					<tr>
						<td>Sesso:</td>
						<td><input type="text" id="sesso" name="sesso" placeholder="M/F" maxlength="1"></td>
					</tr>
					<tr>
						<td>Data di nascita:</td>
						<td><input type="date" id="datadinascita" name="datadinascita"></td>
					</tr>				
					<tr>
						<td>Indirizzo:</td>
						<td><input type="text" id="indirizzo" name="indirizzo" placeholder="Via/Piazza..."></td>
					</tr>
					<tr>
						<td>CAP:</td>
						<td><input type="text" id="cap" name="cap" placeholder="CAP" maxlength="5"></td>
					</tr>
					<tr>
						<td>Citta:</td>
						<td><input type="text" id="citta" name="citta" placeholder="Città"></td>
					</tr>
					<tr>
						<td>Provincia:</td>
						<td><input type="text" id="provincia" name="provincia" placeholder="Provincia" maxlength="2"></td>
					</tr>
					<tr>
						<td style="color: #d63031; font-weight: bold;">Telefono *:</td>
						<td><input type="tel" id="telefono" name="telefono" required placeholder="Telefono"></td>
					</tr>
					<tr>
						<td>Cellulare:</td>
						<td><input type="tel" id="cellulare" name="cellulare" placeholder="Cellulare"></td>
					</tr>
					<tr>
						<td style="color: #d63031; font-weight: bold;">Email *:</td>
						<td><input type="email" id="email" name="email" required placeholder="Email"></td>
					</tr>
					<tr>
						<td><input type="submit" value="Salva" class="btn btn-save"></td>
						<td><a href="anagrafica.php" class="btn btn-back" style="width: 100%; box-sizing: border-box; display: block;">Annulla</a></td>
					</tr>
				</table>
			</form>
		<?php
		}
		if($azione == "modifica"){	
			$id = $_GET["id"];
			$select="select * from anagrafica where id = " . $id;
			$result = mysqli_query($conn, $select);
			while($query = mysqli_fetch_array($result)) {
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
			<h1>Modifica Cliente</h1>
			<form action="anagrafica.php" method="get">
				<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
				<input type="hidden" id="azione" name="azione" value="aggiorna">
				<table class="form-table"> 
					<tr>
						<td style="color: #d63031; font-weight: bold;">Nome *: </td>
						<td><input type="text" id="nome" name="nome" required value="<?php echo $nome; ?>"></td>
					</tr>
					<tr>
						<td style="color: #d63031; font-weight: bold;">Cognome *:</td>
						<td><input type="text" id="cognome" name="cognome" required value="<?php echo $cognome; ?>"></td>
					</tr>
					<tr>
						<td>Sesso:</td>
						<td><input type="text" id="sesso" name="sesso" maxlength="1" value="<?php echo $sesso; ?>"></td>
					</tr>
					<tr>
						<td>Data di nascita:</td>
						<td><input type="date" id="datadinascita" name="datadinascita" value="<?php echo $datadinascita; ?>"></td>
					</tr>				
					<tr>
						<td>Indirizzo:</td>
						<td><input type="text" id="indirizzo" name="indirizzo" value="<?php echo $indirizzo; ?>"></td>
					</tr>
					<tr>
						<td>CAP:</td>
						<td><input type="text" id="cap" name="cap" maxlength="5" value="<?php echo $cap; ?>"></td>
					</tr>
					<tr>
						<td>Citta:</td>
						<td><input type="text" id="citta" name="citta" value="<?php echo $citta; ?>"></td>
					</tr>
					<tr>
						<td>Provincia:</td>
						<td><input type="text" id="provincia" name="provincia" value="<?php echo $provincia; ?>"></td>
					</tr>
					<tr>
						<td style="color: #d63031; font-weight: bold;">Telefono *:</td>
						<td><input type="tel" id="telefono" name="telefono" required value="<?php echo $telefono; ?>"></td>
					</tr>
					<tr>
						<td>Cellulare:</td>
						<td><input type="tel" id="cellulare" name="cellulare" value="<?php echo $cellulare; ?>"></td>
					</tr>
					<tr>
						<td style="color: #d63031; font-weight: bold;">Email *:</td>
						<td><input type="email" id="email" name="email" required value="<?php echo $email; ?>"></td>
					</tr>
					<tr>
						<td><input type="submit" value="Aggiorna" class="btn btn-save"></td>
						<td><a href="anagrafica.php" class="btn btn-back" style="width: 100%; box-sizing: border-box; display: block;">Annulla</a></td>
					</tr>
				</table>
			</form>
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
				$insert = "insert into anagrafica (nome, cognome, sesso, data_nascita, indirizzo, cap, citta, provincia, telefono, cellulare, email, attivo, canc) 
						   values ('$nome', '$cognome', '$sesso', '$datadinascita', '$indirizzo', '$cap', '$citta', '$provincia', '$telefono', '$cellulare', '$email', 1, 0)";
				mysqli_query($conn, $insert);
				?>
				<script>window.open("anagrafica.php?azione=insertok", "_top");</script>
				<?php
			}
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
			
			$update = "update anagrafica set nome='$nome', cognome='$cognome', sesso='$sesso', data_nascita='$datadinascita', indirizzo='$indirizzo', cap='$cap', citta='$citta', provincia='$provincia', telefono='$telefono', cellulare='$cellulare', email='$email' where id=$id";
			mysqli_query($conn, $update);
			?>
			<script>window.open("anagrafica.php", "_top");</script>
			<?php
		}
		
		if($azione == "elimina"){
			$id = $_GET["id"];
			$delete = "update anagrafica set canc = 1 where id = $id";
			mysqli_query($conn, $delete);
			?>
			<script>window.open("anagrafica.php", "_top");</script>
			<?php
		}
		
		if($azione == "recupera"){
			$id = $_GET["id"];
			$recupera = "update anagrafica set canc = 0 where id = $id";
			mysqli_query($conn, $recupera);
			?>
			<script>window.open("anagrafica.php?azione=cestino", "_top");</script>
			<?php
		}
		
		if($azione == "cestino"){
		?>
			<h1>Cestino Clienti</h1>
			<div class="table-container">

				<table>
					<thead>
						<tr>
							<th> ID </th>
							<th> Nome </th>
							<th> Cognome </th>
							<th> Azioni </th>
						</tr>
					</thead>
					<tbody>
					<?php
					$select="select * from anagrafica where canc = 1";
					$result = mysqli_query($conn, $select);
					while($query = mysqli_fetch_array($result)) {
						$id = $query["id"];
						$nome = $query["nome"];
						$cognome = $query["cognome"];
					?>
						<tr>
							<td> <?php echo $id ?> </td>
							<td> <?php echo $nome ?> </td>
							<td> <?php echo $cognome ?> </td>
							<td>
								<img src="images/restore.png" width="20px" height="auto" title="Recupera Cliente" onClick="recupera(<?php echo $id ?>);" style="cursor: pointer" class="icon-btn">
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div style="text-align: center;">
				<a href="anagrafica.php" class="btn btn-back">Torna ad Anagrafica</a>
			</div>
		<?php
		}
		?>
    </div>
</body>
</html>
