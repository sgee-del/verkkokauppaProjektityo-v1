<?php
header("Content-Type: application/json");
session_start();

require_once "../../config/db_connect.php";

if (!isset($_SESSION["userID"])) {
    echo json_encode(["success" => false, "message" => "Kirjaudu sisään."]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$cartItemID = $data["cartItemID"] ?? null;

if (!$cartItemID) {
    echo json_encode(["success" => false, "message" => "Virheellinen tuote."]);
    exit;
}

// Puretaan yhdistelmätunniste: cartID_productID
list($cartID, $productID) = explode("_", $cartItemID);

$pdo = getDBConnection(); // Tietokantayhteys

// Poistetaan tuote
$stmt = $pdo->prepare("
    DELETE FROM cart_items
    WHERE cartID = ? AND productID = ?
");
$stmt->execute([$cartID, $productID]);

echo json_encode(["success" => true]);
