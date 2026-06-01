<?php
include "dbconf.php";
?>
<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>	
<body>
	<?php
	$azione = $_POST["azione"] ?? '';
	$username = $_POST["username"] ?? '';
	$password = $_POST["password"] ?? '';
	
	if(empty($azione) || $azione != "accedi"){
	?>
	<div class="card"> 
        <h2>Login</h2>
        <form action="login.php" method="post">
            <input type="hidden" id="azione" name="azione" value="accedi">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Il tuo username" required value="<?php echo htmlspecialchars($username); ?>" />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="La tua password" required />
            </div>
            <button type="submit" name="submit" class="btn">Accedi</button>
        </form>
	</div>
<?php
	}
	if($azione == "accedi"){
		$select = "select id from utenti where attivo = 1 and canc = 0 and username = '$username' and password = PASSWORD('$password')";
		$result = mysqli_query($conn, $select);
		$totale = mysqli_num_rows($result);
		
		if($totale == 1){
			session_start();
			while($query = mysqli_fetch_array($result)){
				$id_utente = $query["id"];
			}
			$_SESSION["id_utente"] = $id_utente;
			$_SESSION["username"] = $username;
			?>
			<script language="javascript" type="application/javascript">
				window.open("pannellocontrollo.php","_top");
			</script>
			<?php
		}
		else{
			?>
            <div class="card">
                <h2>Login</h2>
                <div class="status-msg status-error">
                    Username o password non corretti!
                </div>
                <form action="login.php" method="post">
                    <input type="hidden" id="azione" name="azione" value="accedi">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Il tuo username" required value="<?php echo htmlspecialchars($username); ?>" />
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="La tua password" required />
                    </div>
                    <button type="submit" name="submit" class="btn">Riprova</button>
                </form>
            </div>
            <?php
		}
	}
?>
</body>
</html>
