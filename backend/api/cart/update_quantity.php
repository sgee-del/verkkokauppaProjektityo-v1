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
$quantity = $data["quantity"] ?? null;

if (!$cartItemID || !$quantity || $quantity < 1) {
    echo json_encode(["success" => false, "message" => "Virheellinen määrä."]);
    exit;
}

// Puretaaan yhdistelmätunniste: cartID_productID
list($cartID, $productID) = explode("_", $cartItemID);

$pdo = getDBConnection(); // Teitokantayhteys

// Päivitetään määrä
$stmt = $pdo->prepare("
    UPDATE cart_items
    SET amount = ?
    WHERE cartID = ? AND productID = ?
");
$stmt->execute([$quantity, $cartID, $productID]);

echo json_encode(["success" => true]);
