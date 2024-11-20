<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Icrizione</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap');
        * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins',sans-serif;
}
body{
    display: flex; 
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: #dfdfdf;
}
.dati{
    display: flex;
    justify-content: center; 
    flex-direction: column;
    width: 440px;
    height: 480px;
    padding: 30px;
}

    </style>
    </head>
<body>
<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeUtente = $_POST["UserName"];
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $password = $_POST["password"];
    $dataNascita = $_POST["data"];

    // Controllo campi vuoti
    if (empty($nomeUtente) || empty($nome) || empty($cognome) || empty($password) || empty($dataNascita)) {
        die("Errore: tutti i campi devono essere compilati.");
    }

    // Hash della password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Query SQL
    $sql = "INSERT INTO utenti (username, nome, cognome, password, data_nascita) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Errore nella preparazione della query: " . $conn->error);
    }

    if (!$stmt->bind_param("sssss", $nomeUtente, $nome, $cognome, $passwordHash, $dataNascita)) {
        die("Errore nel binding dei parametri: " . $stmt->error);
    }

    if ($stmt->execute()) {
        echo "Registrazione completata";
    } else {
        die("Errore durante l'esecuzione della query: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
}
?>


<div class="dati">
    <h1>Registrazione completata</h1>
    <h3>Nome Utente: <?php echo htmlspecialchars($nomeUtente); ?></h3>
    <h3>Nome: <?php echo htmlspecialchars($nome); ?></h3>
    <h3>Cognome: <?php echo htmlspecialchars($cognome); ?></h3>
    <h3>Data Nascita: <?php echo htmlspecialchars($dataNascita); ?></h3>
</div>

</body>
</html>
</div>
