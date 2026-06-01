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
    <title>Gestione Utenti</title>
    <link rel="stylesheet" href="css/style.css">
	<script>
		function cancella(id){
			if(confirm("Vuoi eliminare l'utente selezionato?")){
				window.open("utenti.php?azione=elimina&id="+id, "_top");
			}
		}
		function recupera(id){
			if(confirm("Vuoi recuperare l'utente selezionato?")){
				window.open("utenti.php?azione=recupera&id="+id, "_top");
			}
		}
	</script>
</head>
<body>
    <div class="container container-wide">
		<?php
		$azione = $_GET['azione'] ?? '';
		if($azione == "insertok"){
			echo "<div class='status-msg status-success'>Utente inserito con successo!</div>";
			$azione = "";
		}
		
		if(empty($azione)){ 
			$result = mysqli_query($conn, "select * from utenti where attivo = 1 and canc = 0"); 
			$totale = mysqli_num_rows($result)
		?>
			<h1>Utenti - Tot. <?php echo $totale ?> 
				<a href="utenti.php?azione=nuovo"><img src="images/add.png" width="25px" height="auto" class="icon-btn"></a> 
				<a href="utenti.php?azione=cestino"><img src="images/bin.png" width="25px" height="auto" class="icon-btn"></a>
			</h1>
            <div class="table-container">
                <table>
                    <thead>
                        <tr><th> ID </th><th> Username </th><th> Password </th><th> Email </th><th style="background-color: #0984e3"> Azioni </th></tr>
                    </thead>
                    <tbody>
                    <?php
                    while($query = mysqli_fetch_array($result)) {
                        $id = $query["id"]; $username = $query["username"]; $email = $query["email"];
                    ?>
                        <tr>
                            <td> <?php echo $id ?> </td><td> <?php echo $username ?> </td>
                            <td> <code style="background: #eee; padding: 2px 5px; border-radius: 4px;">********</code> </td>
                            <td> <a href="mailto:<?php echo $email ?>"><?php echo $email ?></a> </td>
                            <td>
                                <a href="utenti.php?azione=modifica&id=<?php echo $id ?>"><img src="images/edit.png" width="18px" height="auto" class="icon-btn"> </a> &nbsp; 
                                <img src="images/remove.png" width="18px" height="auto" title="Cancella" onClick="cancella(<?php echo $id ?>);" class="icon-btn">
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
			<div style="text-align: center; margin-top: 20px;"><a href="pannellocontrollo.php" class="btn btn-back" style="width: auto;">Torna al MENU</a></div>
		<?php
		}
		if($azione == "nuovo"){	
		?>
			<h1>Inserisci Nuovo Utente</h1>
			<form action="utenti.php" method="get">
				<input type="hidden" id="azione" name="azione" value="salva">
				<div class="card" style="max-width: 500px; text-align: left;">
                    <div class="form-group"><label>Username *</label><input type="text" name="username" required></div>
                    <div class="form-group"><label>Password *</label><input type="password" name="password" required></div>
                    <div class="form-group"><label>Email *</label><input type="email" name="email" required></div>
                    <input type="submit" value="Salva" class="btn btn-save">
                    <a href="utenti.php" class="btn btn-back">Annulla</a>
                </div>
			</form>
		<?php
		}
		if($azione == "modifica"){	
			$id = $_GET["id"];
			$result = mysqli_query($conn, "select * from utenti where id = $id");
			while($query = mysqli_fetch_array($result)) {
				$username = $query["username"]; $email = $query["email"];
			}
		?>
			<h1>Modifica Utente</h1>
			<form action="utenti.php" method="get">
				<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
				<input type="hidden" id="azione" name="azione" value="aggiorna">
				<div class="card" style="max-width: 500px; text-align: left;">
                    <div class="form-group"><label>Username *</label><input type="text" name="username" required value="<?php echo $username; ?>"></div>
                    <div class="form-group"><label>Password *</label><input type="password" name="password" required placeholder="Nuova Password"></div>
                    <div class="form-group"><label>Email *</label><input type="email" name="email" required value="<?php echo $email; ?>"></div>
                    <input type="submit" value="Aggiorna" class="btn btn-save">
                    <a href="utenti.php" class="btn btn-back">Annulla</a>
                </div>
			</form>
		<?php
		}
		if($azione == "salva"){
			$username = $_GET["username"]; $password = $_GET["password"]; $email = $_GET["email"];
			mysqli_query($conn, "INSERT INTO `utenti` (`username`, `password`, `email`, `attivo`, `canc`) VALUES ('$username', PASSWORD('$password'), '$email', 1, 0)");
			header("Location: utenti.php?azione=insertok"); exit;
		}
		if($azione == "aggiorna"){
			$id = $_GET["id"]; $username = $_GET["username"]; $password = $_GET["password"]; $email = $_GET["email"];
			mysqli_query($conn, "UPDATE `utenti` SET `username`='$username', `password`= PASSWORD('$password'), `email`='$email' WHERE id = $id");
			header("Location: utenti.php"); exit;
		}
		if($azione == "elimina"){
			$id = $_GET["id"];
			mysqli_query($conn, "UPDATE `utenti` SET canc = 1, attivo = 0 WHERE id = $id");
			header("Location: utenti.php"); exit;
		}
		if($azione == "recupera"){
			$id = $_GET["id"];
			mysqli_query($conn, "UPDATE `utenti` SET canc = 0, attivo = 1 WHERE id = $id");
			header("Location: utenti.php?azione=cestino"); exit;
		}
		if($azione == "cestino"){
		?>
			<h1>Cestino Utenti</h1>
			<div class="table-container">
				<table>
					<thead><tr><th> ID </th><th> Username </th><th> Email </th><th> Azioni </th></tr></thead>
					<tbody>
					<?php
					$result = mysqli_query($conn, "select * from utenti where canc = 1");
					while($query = mysqli_fetch_array($result)) {
						$id = $query["id"]; $username = $query["username"]; $email = $query["email"];
					?>
						<tr><td> <?php echo $id ?> </td><td> <?php echo $username ?> </td><td> <?php echo $email ?> </td>
							<td><img src="images/recover.png" width="20px" height="auto" title="Recupera" onClick="recupera(<?php echo $id ?>);" class="icon-btn"></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div style="text-align: center; margin-top: 20px;"><a href="utenti.php" class="btn btn-back" style="width: auto;">Torna ad Utenti</a></div>
		<?php } ?>
    </div>
</body>
</html>
