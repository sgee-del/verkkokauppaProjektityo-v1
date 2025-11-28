<?php
header("Content-Type: application/json");
session_start();

require_once "../../config/db_connect.php";

if (!isset($_SESSION["userID"])) {
    echo json_encode(["success" => false, "message" => "Kirjaudu sisään lisätäksesi tuotteita."]);
    exit;
}

// Tietokantayhteys
$pdo = getDBConnection();

$data = json_decode(file_get_contents("php://input"), true);
$productID = $data["productID"] ?? null;

if (!$productID) {
    echo json_encode(["success" => false, "message" => "Virheellinen tuote."]);
    exit;
}

$userID = $_SESSION["userID"];

// Haetaan ostoskori
$stmt = $pdo->prepare("SELECT cartID FROM cart WHERE userID = ?");
$stmt->execute([$userID]);
$cart = $stmt->fetch();

if (!$cart) {
    // Luodaan uusi ostoskori
    $pdo->prepare("INSERT INTO cart (userID, createdAt) VALUES (?, NOW())")
        ->execute([$userID]);
    $cartID = $pdo->lastInsertId();
} else {
    $cartID = $cart["cartID"];
}

// Haetaan ostoskorin tuotteet ja määrä
$stmt = $pdo->prepare("SELECT amount FROM cart_items WHERE cartID = ? AND productID = ?");
$stmt->execute([$cartID, $productID]);
$item = $stmt->fetch();

if ($item) {
    // Päivitetään määrää jso on
    $pdo->prepare("
        UPDATE cart_items SET amount = amount + 1
        WHERE cartID = ? AND productID = ?
    ")->execute([$cartID, $productID]);
} else {
    // Lisätään tuote koriin jos ei
    $pdo->prepare("
        INSERT INTO cart_items (cartID, productID, amount)
        VALUES (?, ?, 1)
    ")->execute([$cartID, $productID]);
}

echo json_encode(["success" => true, "message" => "Tuote lisätty ostoskoriin!"]);
?>
