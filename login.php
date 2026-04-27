<?php
include "dbconf.php";
?>

<!doctype html>
<html lang="it">
<head>
<meta charset="utf-8">
<title>Login</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
            padding: 20px;
        }
        .card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 350px;
            text-align: center;
        }
        h2 {
            margin-top: 0;
            color: #2d3436;
            font-size: 28px;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #2d3436;
            font-size: 14px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #dfe6e9;
            border-radius: 12px;
            box-sizing: border-box;
            font-family: inherit;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        input:focus {
            outline: none;
            border-color: #B7F102;
            box-shadow: 0 0 0 3px rgba(183, 241, 2, 0.2);
        }
        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background-color: #B7F102;
            color: #2d3436;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 4px 6px rgba(183, 241, 2, 0.2);
        }
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 14px rgba(183, 241, 2, 0.4);
            filter: brightness(1.05);
        }
        .error-msg {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            border: 1px solid #f5c6cb;
        }
        .debug-info {
            font-size: 10px;
            color: #ccc;
            margin-top: 20px;
            word-break: break-all;
        }
    </style>
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
                <div class="error-msg">
                    Username o password non corretti,<br>utente non attivo o inesistente!
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
                
                <div class="debug-info">
                    <?php 
                    // Debug info ()
                    ?>
                </div>
            </div>
            <?php
		}
	}
?>
</body>
</html>
