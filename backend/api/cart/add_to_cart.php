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
    try {
        $pdo->prepare("INSERT INTO cart (userID, createdAt) VALUES (?, NOW())")
            ->execute([$userID]);
        $cartID = $pdo->lastInsertId();
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Ostoskoriin luonti epäonnistui: " . $e->getMessage()]);
        exit;
    }
} else {
    $cartID = $cart["cartID"];
}

// Haetaan ostoskorin tuotteet ja määrä
$stmt = $pdo->prepare("SELECT amount FROM cart_items WHERE cartID = ? AND productID = ?");
$stmt->execute([$cartID, $productID]);
$item = $stmt->fetch();

if ($item) {

    // Päivitetään määrää
    try {
        $pdo->prepare("
            UPDATE cart_items SET amount = amount + 1
            WHERE cartID = ? AND productID = ?
        ")->execute([$cartID, $productID]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Tuotteen päivittäminen ostoskoriin epäonnistui: " . $e->getMessage()]);
        exit;
    }
} else {

    // Lisätään tuote koriin
    try {
        $pdo->prepare("
            INSERT INTO cart_items (cartID, productID, amount)
            VALUES (?, ?, 1)
        ")->execute([$cartID, $productID]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Tuotteen lisääminen ostoskoriin epäonnistui: " . $e->getMessage()]);
        exit;
    }
}

echo json_encode(["success" => true, "message" => "Tuote lisätty ostoskoriin!"]);
