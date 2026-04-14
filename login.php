<?php
include "dbconf.php";
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
</head>
	
<?php
//<
$azione = $_POST["azione"];
$username = $_POST["username"];
$password = $_POST["password"];
?>
	
<body>
	
	<div> 
		
		<center>
		<fieldset style="width: 30%; border-radius: 5px">
			<legend style="text-align: center"> LOGIN </legend>
			<form action="login.php" method="post">
				<input type="hidden" id="azione" name="azione" value="accedi">
				<table>
					<tr>
						<td> Username </td>
						<td> <input type="text" id="username" name="username" style="width: 150px" placeholder="inserisci il tuo username" required value="<?php echo $username; ?>" /> </td>
					</tr>
					<tr>
						<td> Password </td>
						<td> <input type="password" id="password" name="password" style="width: 150px" placeholder="inserisci la tua password" required /> </td>
					</tr>

					<tr>
						<td colspan="2" align="center">
							<button type="submit" name="submit"> Accedi </button>
						</td>
					</tr>

				</table>


			</form>
		</fieldset>
	</center>

	</div>

<?php
	if($azione == "accedi"){
		
		
		// salva username e password.
		// echo $username . "<br>";
		// echo $password . "<br>";
		
		$select = "select id from utenti where attivo = 1 and canc = 0 and username = '$username' and password = PASSWORD('$password')";
		// -
		// echo $select . "<br>";
		$result = mysqli_query($conn, $select);
		$totale = mysqli_num_rows($result);
		
		if($totale == 1){
			//salvamo in sessione idutente e username e ridirezioniamo al un altra pagina
			session_start();
			
			while($query = mysqli_fetch_array($result)){
				$id_utente = $query["id"];
			}
			
			$_SESSION["id_utente"] = $id_utente;
			$_SESSION["username"] = $username;
			
			//andiamo al pannello di controllo
			//echo "<center><span style='color:green'><b>Utente o password esistono!</b></span></center>";
			?>
			<script language="javascript" type="application/javascript">
				window.open("pannellocontrollo.php","_top");
			</script>
			<?php
		}
		else{
			//diamo errore utente o password non corretti o utente non attivo o inesistente
			echo "<center><span style='color:red'><b>Utente o password non corretti<br>o utente non attivo o inesistente!</b></span></center>";
		}
		
	}
?>
	

	

	
</body>
</html>