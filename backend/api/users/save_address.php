<?php
header("Content-Type: application/json");
session_start();

require_once "../../config/db_connect.php"; // Tietokanta astukset

// Onko kirjautunut sisäöän
if (!isset($_SESSION["userID"])) {
    echo json_encode(["success" => false, "message" => "Kirjaudu sisään."]);
    exit;
}

// Tallennetaan osoiteteidot muuttujiin
$data = json_decode(file_get_contents("php://input"), true);
$street = trim($data["street"] ?? "");
$city = trim($data["city"] ?? "");
$zip = trim($data["zip"] ?? "");

if (!$street || !$city || !$zip) {
    echo json_encode(["success" => false, "message" => "Täytä kaikki kentät."]);
    exit;
}

// Tietokantayhteys
$pdo = getDBConnection();
$userID = $_SESSION["userID"];

$stmt = $pdo->prepare("SELECT addressID FROM addresses WHERE userID = ?");
$stmt->execute([$userID]);
$exists = $stmt->fetch();

// Jos osoitteidot llöytyy addresses taulukosta haetaan ne sieltä muuten tallennetaan annetut tiedot
if ($exists) {
    $stmt = $pdo->prepare("UPDATE addresses SET street=?, city=?, zip=? WHERE userID=?");
    $stmt->execute([$street, $city, $zip, $userID]);
} else {
    $stmt = $pdo->prepare("INSERT INTO addresses (userID, street, city, zip) VALUES (?, ?, ?, ?)");
    $stmt->execute([$userID, $street, $city, $zip]);
}

echo json_encode(["success" => true, "message" => "Osoite tallennettu"]);
