<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex; 
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #dfdfdf;
        }
        .dati {
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

$accessoConsentito = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeUtente = $_POST["UserName"];
    $passwordInserita = $_POST["password"];

    // Controllo dati vuoti
    if (empty($nomeUtente) || empty($passwordInserita)) {
        die("Errore: Nome utente e password sono obbligatori.");
    }

    // Query per verificare l'utente
    $sql = "SELECT username, nome, cognome, password, data_nascita FROM utenti WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Errore nella preparazione della query: " . $conn->error);
    }

    // Associa i parametri
    if (!$stmt->bind_param("s", $nomeUtente)) {
        die("Errore nel binding dei parametri: " . $stmt->error);
    }

    // Esegui la query
    if (!$stmt->execute()) {
        die("Errore nell'esecuzione della query: " . $stmt->error);
    }

    // Ottieni i risultati
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($username, $nome, $cognome, $passwordHash, $dataNascita);
        $stmt->fetch();

        // Verifica la password
        if (password_verify($passwordInserita, $passwordHash)) {
            $accessoConsentito = true;
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<div class="dati">
    <?php if ($accessoConsentito): ?>
        <h1>Accesso effettuato con successo</h1>
        <h3>Nome Utente: <?php echo htmlspecialchars($nomeUtente); ?></h3>
        <h3>Nome: <?php echo htmlspecialchars($nome); ?></h3>
        <h3>Cognome: <?php echo htmlspecialchars($cognome); ?></h3>
        <h3>Data di Nascita: <?php echo htmlspecialchars($dataNascita); ?></h3>
    <?php else: ?>
        <h1>Errore: credenziali non valide</h1>
    <?php endif; ?>
</div>

