<?php
// Haetaan config.php:n sisältö ja asetustiedosto
require_once __DIR__ . '/config.php';

// Luodaan tietokantayhteys käyttäen config.php:n vakioita
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Tarkistetaan yhteys
if ($conn->connect_error) {
    die("Yhteys epäonnistui: " . $conn->connect_error);
}

// Asetetaan utf8mb4 charset
$conn->set_charset("utf8mb4");

// DEBUG: Jos tarvitset, voit lisätä virheilmoituksen, joka näkyy kehityksessä.
if (APP_DEBUG) {
    echo "Tietokantayhteys muodostettu onnistuneesti!";
}
?>