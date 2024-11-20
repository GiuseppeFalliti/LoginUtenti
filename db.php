<?php
$servername = "localhost";
$username = "rubricatelefono"; 
$password = "VQFzj7NBRGwf";
$dbname = "my_rubricatelefono";

// Crea connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
    echo("connessione fallita");
}
?>
