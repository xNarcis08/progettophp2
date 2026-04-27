<?php
include("dbconf.php");
session_start();

if(!isset($_SESSION["id_utente"])){
    header("Location: login.php");
    exit();
}

$messaggio_conferma = "";

if(isset($_POST['invia'])){
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $messaggio = $_POST['messaggio'];
    $privacy = isset($_POST['privacy']) ? 1 : 0;
    
    $file_name = $_FILES['file']['name'];

    $sql = "INSERT INTO contatti (nome, cognome, email, messaggio, file, privacy) 
            VALUES ('$nome', '$cognome', '$email', '$messaggio', '$file_name', '$privacy')";

    if(mysqli_query($conn, $sql)){
        $messaggio_conferma = "Messaggio inviato con successo!";
    } else {
        $messaggio_conferma = "Errore nell'invio: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <title>Contatti</title>
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
            max-width: 450px;
        }
        h1 {
            margin-top: 0;
            color: #2d3436;
            font-size: 28px;
            text-align: center;
            margin-bottom: 25px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #2d3436;
            font-size: 14px;
        }
        input[type="text"],
        input[type="email"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #dfe6e9;
            border-radius: 10px;
            box-sizing: border-box;
            font-family: inherit;
            font-size: 14px;
        }
        textarea {
            height: 100px;
            resize: vertical;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 20px 0;
            font-size: 13px;
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
            text-align: center;
            text-decoration: none;
        }
        .btn:hover {
            transform: translateY(-3px);
            filter: brightness(1.05);
        }
        .btn-back {
            background-color: #6c757d;
            color: white;
            margin-top: 15px;
        }
        .status-msg {
            padding: 12px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .status-success { background-color: #d4edda; color: #155724; }
        .status-error { background-color: #f8d7da; color: #721c24; }
    </style>
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
        <div class="form-group">
            <label>Nome *</label>
            <input type="text" name="nome" required>
        </div>

        <div class="form-group">
            <label>Cognome *</label>
            <input type="text" name="cognome" required>
        </div>

        <div class="form-group">
            <label>Email *</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Carica File</label>
            <input type="file" name="file">
        </div>

        <div class="form-group">
            <label>Messaggio *</label>
            <textarea name="messaggio" required></textarea>
        </div>

        <div class="checkbox-group">
            <input type="checkbox" name="privacy" id="privacy" required>
            <label for="privacy">Accetto la privacy *</label>
        </div>

        <button type="submit" name="invia" class="btn">Invia Messaggio</button>
    </form>

    <a href="pannellocontrollo.php" class="btn btn-back">Torna al Menu</a>
</div>

</body>
</html>
