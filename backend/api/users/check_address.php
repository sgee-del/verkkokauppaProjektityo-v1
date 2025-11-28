<?php
header("Content-Type: application/json");
session_start();
require_once "../../config/db_connect.php";

if (!isset($_SESSION["userID"])) {
    echo json_encode(["success" => false, "message" => "Kirjaudu sisään."]);
    exit;
}

$pdo = getDBConnection();
$userID = $_SESSION["userID"];

// Hae käyttäjän osoite jos semmoinen on asetettu
$stmt = $pdo->prepare("SELECT address, postalCode, city FROM users WHERE userID = ?");
$stmt->execute([$userID]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(["success" => false, "message" => "Käyttäjää ei löytynyt."]);
    exit;
}

// Tarkistetaan, onko osoite asetettu
$hasAddress = !empty($user["address"]) && !empty($user["postalCode"]) && !empty($user["city"]);

echo json_encode([
    "success" => true,
    "hasAddress" => $hasAddress,
    "address" => $user
]);
?>
