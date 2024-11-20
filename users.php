<?php
header("Content-Type: application/json");
include 'db.php';

// Determina il metodo HTTP
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Ottieni lista utenti
        $sql = "SELECT id, username, nome, cognome, data_nascita FROM utenti";
        $result = $conn->query($sql); //esegue il comando $sql.
        $users = [];

        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        echo json_encode($users);
        break;

    case 'POST':
        // Aggiungi un utente
        $data = json_decode(file_get_contents("php://input"), true);
        $sql = "INSERT INTO utenti (username, nome, cognome, password, data_nascita) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $data['username'], $data['nome'], $data['cognome'], password_hash($data['password'], PASSWORD_DEFAULT), $data['data_nascita']);
        
        if ($stmt->execute()) {
            echo json_encode(["message" => "Utente creato con successo"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Errore nella creazione dell'utente"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["message" => "Metodo non consentito"]);
        break;
}

$conn->close();
?>
