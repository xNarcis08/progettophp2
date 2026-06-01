<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once("PHPMailer/vendor/autoload.php");

include("dbconf.php");
session_start();

if(!isset($_SESSION["id_utente"])){
    header("Location: login.php");
    exit();
}

$messaggio_conferma = "";
if(isset($_POST['invia'])){
    $nome = $_POST['nome']; $cognome = $_POST['cognome']; $email = $_POST['email'];
    $messaggio = $_POST['messaggio']; $privacy = isset($_POST['privacy']) ? 1 : 0;
    
	$target_dir = "uploads/";
	
	$file_name = $_FILES['file']['name'];
	
	$target_file = $target_dir . basename($_FILES['file']['name']);
	
	if(move_uploaded_file($_FILES['file']['tmp_name'],$target_file)){
		$messaggio_conferma =  "il file " . $target_file . " e' stato caricato con successo";
	}
	else{
		$messaggio_conferma =  "spiacente, si è verificato un errore nel caricamento";
	}
	
    $sql = "INSERT INTO contatti (nome, cognome, email, messaggio, file, privacy) 
            VALUES ('$nome', '$cognome', '$email', '$messaggio', '$target_file', '$privacy')";
    if(mysqli_query($conn, $sql)){ $messaggio_conferma = "Messaggio inviato con successo!"; }
    else { $messaggio_conferma = "Errore nell'invio: " . mysqli_error($conn); }
	
	//inviamo una mail con PHPMailer mail: narcis08691@proton.me pass: Parola123$$$$
	
	$mail = new PHPMailer(true); //istanza di una classe
	
	try{
		$mail->isSMTP();		//Send Mail Trasfer Protocol
		$mail->SMTPDebug = 2;		//0 disable 1 enable 2 dettagli+
		$mail->Host = "mail.brigazzifabio.it"; //smtp.protonmail.ch
		$mail->SMTPAuth = true;
		$mail->Username = "info@brigazzifabio.it";	//email
		$mail->Password = "$Br1g4zz1!2023@#";	//password email
		//$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		$mail->SMTPSecure = 'tls';
		$mail->Port = 587;		//465 o 587 -> ssl o tls

		$mail->setFrom('info@brigazzifabio.it', 'brigazzi fabio');
		$mail->addAddress($email,$cognome . " " . $nome);

		$mail->isHTML(true);
		$mail->Subject = "Richiesta di Contatto";
		$mail->Body = $messaggio;
		$mail->AltBody = $messaggio;
		
		if(!empty($file_name)){
			$mail->addAttachment($target_file);
		}
		
		

		$mail->send();
		$messaggio_conferma = "Messaggio mail inviato con successo!";
	}
	catch(Exception $e){
		$messaggio_conferma = "errore invio mail: " . $mail->ErrorInfo;
	}
	
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <title>Contatti</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="card">
    <h1>Contatti</h1>
    <?php if($messaggio_conferma != ""): ?>
        <div class="status-msg <?php echo strpos($messaggio_conferma, 'successo') !== false ? 'status-success' : 'status-error'; ?>">
            <?php echo $messaggio_conferma; ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="contatti.php" enctype="multipart/form-data">
        <div class="form-group"><label>Nome *</label><input type="text" name="nome" required></div>
        <div class="form-group"><label>Cognome *</label><input type="text" name="cognome" required></div>
        <div class="form-group"><label>Email *</label><input type="email" name="email" required></div>
        <div class="form-group"><label>Carica File</label><input type="file" name="file"></div>
        <div class="form-group"><label>Messaggio *</label><textarea name="messaggio" required></textarea></div>
        <div style="display: flex; align-items: center; gap: 10px; margin: 20px 0; font-size: 13px; text-align: left;">
            <input type="checkbox" name="privacy" id="privacy" required>
            <label for="privacy" style="margin-bottom: 0; font-weight: normal;">Accetto la privacy *</label>
        </div>
        <button type="submit" name="invia" class="btn">Invia Messaggio</button>
    </form>
    <a href="pannellocontrollo.php" class="btn btn-back">Torna al MENU</a>
</div>
</body>
</html>
