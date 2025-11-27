<!-- Lisätään ostoskoriin tuotete -->
<?php
header("Content-Type: application/json");
session_start();

require_once "../../config/db_connect.php";

if (!isset($_SESSION["userID"])) {
    echo json_encode(["success" => false, "message" => "Kirjaudu sisään lisätäksesi tuotteita."]);
    exit;
}

$pdo = getDBConnection(); // db yhteys

$data = json_decode(file_get_contents("php://input"), true);
$productID = $data["productID"] ?? null;

if (!$productID) {
    echo json_encode(["success" => false, "message" => "Virheellinen tuote."]);
    exit;
}

$userID = $_SESSION["userID"];

// Tarkistaa, onko käyttäjällä jo ostoskori
$stmt = $pdo->prepare("SELECT cartID FROM cart WHERE userID = ?");
$stmt->execute([$userID]);
$cart = $stmt->fetch();

if (!$cart) {
    // luodaan ostoskori
    $pdo->prepare("INSERT INTO cart (userID, createdAt) VALUES (?, NOW())")
        ->execute([$userID]);

    $cartID = $pdo->lastInsertId();
} else {
    $cartID = $cart["cartID"];
}

// Joias utoete on jo ostoskorissa lisätään määrää
$stmt = $pdo->prepare("SELECT quantity FROM cart_items WHERE cartID = ? AND productID = ?");
$stmt->execute([$cartID, $productID]);
$item = $stmt->fetch();

if ($item) {
    // lisää määrää
    $pdo->prepare("
        UPDATE cart_items SET quantity = quantity + 1 
        WHERE cartID = ? AND productID = ?
    ")->execute([$cartID, $productID]);
} else {
    // uusi rivi
    $pdo->prepare("
        INSERT INTO cart_items (cartID, productID, quantity)
        VALUES (?, ?, 1)
    ")->execute([$cartID, $productID]);
}

echo json_encode(["success" => true, "message" => "Lisätty ostoskoriin"]);
