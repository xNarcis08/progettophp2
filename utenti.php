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
    <title>Gestione Utenti</title>
    <style>
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
            max-width: 1000px;
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
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
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
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-sizing: border-box;
            font-family: inherit;
        }
        .form-table {
            max-width: 500px;
            margin: auto;
        }
        .form-table td {
            border: none;
            padding: 5px;
        }
        .status-msg {
            padding: 12px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .status-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .icon-btn {
            cursor: pointer;
            transition: transform 0.2s;
            vertical-align: middle;
        }
        .icon-btn:hover {
            transform: scale(1.2);
        }
    </style>
	
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
    <div class="container">
		<?php
		$azione = $_GET['azione'] ?? '';
		
		if($azione == "insertok"){
			echo "<div class='status-msg status-success'>Utente inserito con successo!</div>";
			$azione = "";
		}
		
		if(empty($azione)){ 
		?>
				<?php
					$select="select * from utenti where attivo = 1 and canc = 0";
					$result = mysqli_query($conn, $select); 
					$totale = mysqli_num_rows($result)
				?>
				<h1>Utenti - Tot. <?php echo $totale ?> 
					<a href="utenti.php?azione=nuovo"><img src="images/add.png" width="25px" height="auto" class="icon-btn"></a> 
					<a href="utenti.php?azione=cestino"><img src="images/bin.png" width="25px" height="auto" class="icon-btn"></a>
				</h1>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th> ID </th>
                                <th> Username </th>
                                <th> Password </th>
                                <th> Email </th>
                                <th style="background-color: #0984e3"> Azioni </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        while($query = mysqli_fetch_array($result))
                        {
                            $id = $query["id"];
                            $username = $query["username"];
                            $password = $query["password"];
                            $email = $query["email"];
                        ?>
                            <tr>
                                <td> <?php echo $id ?> </td>
                                <td> <?php echo $username ?> </td>
                                <td> <code style="background: #eee; padding: 2px 5px; border-radius: 4px;">********</code> </td>
                                <td> <a href="mailto:<?php echo $email ?>"><?php echo $email ?></a> </td>
                                <td>
                                    <a href="utenti.php?azione=modifica&id=<?php echo $id ?>"><img src="images/edit.png" width="18px" height="auto" class="icon-btn"> </a> &nbsp; 
                                    <img src="images/remove.png" width="18px" height="auto" title="Cancella Utente" alt="Cancella Utente" onClick="cancella(<?php echo $id ?>);" style="cursor: pointer" class="icon-btn">
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
			<h1>Inserisci Nuovo Utente</h1>
			
			<form action="utenti.php" method="get">
				<input type="hidden" id="azione" name="azione" value="salva">
				<table class="form-table"> 
					<tr>
						<td style="color: #d63031; font-weight: bold;">Username *: </td>
						<td><input type="text" id="username" name="username" required placeholder="Username"></td>
					</tr>
					<tr>
						<td style="color: #d63031; font-weight: bold;">Password *:</td>
						<td><input type="password" id="password" name="password" required placeholder="Password"></td>
					</tr>
					<tr>
						<td style="color: #d63031; font-weight: bold;">Email *:</td>
						<td><input type="email" id="email" name="email" required placeholder="Email"></td>
					</tr>
					<tr>
						<td><input type="submit" value="Salva" class="btn btn-save"></td>
						<td><a href="utenti.php" class="btn btn-back" style="width: 100%; box-sizing: border-box; display: block;">Annulla</a></td>
					</tr>
				</table>
			</form>
		<?php
		}
		if($azione == "modifica"){	
			$id = $_GET["id"];
			$select="select * from utenti where id = " . $id;
			$result = mysqli_query($conn, $select);
			while($query = mysqli_fetch_array($result)) {
				$username = $query["username"];
				$password = $query["password"];
				$email = $query["email"];
			}
		?>
			<h1>Modifica Utente</h1>
			<form action="utenti.php" method="get">
				<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
				<input type="hidden" id="azione" name="azione" value="aggiorna">
				<table class="form-table"> 
					<tr>
						<td style="color: #d63031; font-weight: bold;">Username *: </td>
						<td><input type="text" id="username" name="username" required value="<?php echo $username; ?>"></td>
					</tr>
					<tr>
						<td style="color: #d63031; font-weight: bold;">Password *:</td>
						<td><input type="password" id="password" name="password" required placeholder="Nuova Password"></td>
					</tr>
					<tr>
						<td style="color: #d63031; font-weight: bold;">Email *:</td>
						<td><input type="email" id="email" name="email" required value="<?php echo $email; ?>"></td>
					</tr>
					<tr>
						<td><input type="submit" value="Aggiorna" class="btn btn-save"></td>
						<td><a href="utenti.php" class="btn btn-back" style="width: 100%; box-sizing: border-box; display: block;">Annulla</a></td>
					</tr>
				</table>
			</form>
		<?php
		}
		
		if($azione == "salva"){
			$username = $_GET["username"];
			$password = $_GET["password"];
			$email = $_GET["email"];
			
			$insert = "INSERT INTO `utenti` (`username`, `password`, `email`, `attivo`, `canc`) VALUES ('$username', PASSWORD('$password'), '$email', 1, 0)";
			mysqli_query($conn, $insert);
			
			header("Location: utenti.php?azione=insertok");
			exit;
		}
		
		if($azione == "aggiorna"){
			$id = $_GET["id"];
			$username = $_GET["username"];
			$password = $_GET["password"];
			$email = $_GET["email"];
			
			$update = "UPDATE `utenti` SET `username`='$username', `password`= PASSWORD('$password'), `email`='$email' WHERE id = $id";
			mysqli_query($conn, $update);
			
			header("Location: utenti.php");
			exit;
		}
		
		if($azione == "elimina"){
			$id = $_GET["id"];
			$delete = "UPDATE `utenti` SET canc = 1, attivo = 0 WHERE id = $id";
			mysqli_query($conn, $delete);	
			
			header("Location: utenti.php");
			exit;
		}
		
		if($azione == "recupera"){
			$id = $_GET["id"];
			$update = "UPDATE `utenti` SET canc = 0, attivo = 1 WHERE id = $id";
			mysqli_query($conn, $update);
			
			header("Location: utenti.php?azione=cestino");
			exit;
		}
		
		if($azione == "cestino"){
		?>
			<h1>Cestino Utenti</h1>
			<div class="table-container">
				<table>
					<thead>
						<tr>
							<th> ID </th>
							<th> Username </th>
							<th> Email </th>
							<th> Azioni </th>
						</tr>
					</thead>
					<tbody>
					<?php
					$select="select * from utenti where canc = 1";
					$result = mysqli_query($conn, $select);
					while($query = mysqli_fetch_array($result)) {
						$id = $query["id"];
						$username = $query["username"];
						$email = $query["email"];
					?>
						<tr>
							<td> <?php echo $id ?> </td>
							<td> <?php echo $username ?> </td>
							<td> <?php echo $email ?> </td>
							<td>
								<img src="images/recover.png" width="20px" height="auto" title="Recupera Utente" onClick="recupera(<?php echo $id ?>);" style="cursor: pointer" class="icon-btn">
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div style="text-align: center;">
				<a href="utenti.php" class="btn btn-back">Torna ad Utenti</a>
			</div>
		<?php
		}
		?>
    </div>
</body>
</html>
