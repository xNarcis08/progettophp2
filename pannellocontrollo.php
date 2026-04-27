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
<html lang="it">
<head>
<meta charset="utf-8">
<title>Pannello di Controllo</title>
    <style>
        /* Design Moderno e Fresh */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }
        .card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            text-align: center;
            width: 100%;
            max-width: 350px;
        }
        h2 {
            margin-top: 0;
            color: #2d3436;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .welcome-text {
            color: #636e72;
            margin-bottom: 30px;
            font-size: 16px;
        }
        .btn-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 12px;
            background-color: #B7F102;
            color: #2d3436;
            font-family: 'Segoe UI', sans-serif;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(183, 241, 2, 0.2);
        }
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 14px rgba(183, 241, 2, 0.4);
            filter: brightness(1.05);
        }
        .btn-exit {
            background-color: #ff7675;
            color: white;
            box-shadow: 0 4px 6px rgba(255, 118, 117, 0.2);
            margin-top: 10px;
        }
        .btn-exit:hover {
            background-color: #d63031;
            box-shadow: 0 7px 14px rgba(214, 48, 49, 0.4);
        }
    </style>
	
	<script>
		function exit(){
			if(confirm("vuoi davvero uscire?")){
			   window.open("login.php?azione=logout","_top");
			}
		}
	</script>
	
</head>

<body>
    <div class="card">
		<h2>Pannello di Controllo</h2>
		
		<div class="welcome-text">
            Benvenuto, <strong><?php echo $_SESSION["username"]; ?></strong>
        </div>
		
        <div class="btn-container">
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
                <a href="<?php echo $url; ?>" class="btn"><?php echo $voce; ?></a>
                <?php
            }		
            ?>
            <button class="btn btn-exit" onClick="exit()">Esci</button>
        </div>
    </div>
</body>
</html>
