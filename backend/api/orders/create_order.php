<?php
header("Content-Type: application/json");
session_start();

require_once "../../config/db_connect.php";

if (!isset($_SESSION["userID"])) {
    echo json_encode(["success" => false, "message" => "Kirjaudu sisään."]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$street = trim($data["street"] ?? "");
$zip = trim($data["zip"] ?? "");
$city = trim($data["city"] ?? "");

if (!$street || !$zip || !$city) {
    echo json_encode(["success" => false, "message" => "Täytä kaikki osoitekentät"]);
    exit;
}

$pdo = getDBConnection();
$userID = $_SESSION["userID"];

// --- PÄIVITÄ OSOITE ---
$stmt = $pdo->prepare("SELECT addressID FROM addresses WHERE userID=?");
$stmt->execute([$userID]);
$exists = $stmt->fetch();

if ($exists) {
    $pdo->prepare("UPDATE addresses SET street=?, zip=?, city=? WHERE userID=?")
        ->execute([$street, $zip, $city, $userID]);
} else {
    $pdo->prepare("INSERT INTO addresses (userID, street, city, zip) VALUES (?, ?, ?, ?)")
        ->execute([$userID, $street, $zip, $city]);
}

// --- HAE OSTOSKORI ---
$stmt = $pdo->prepare("
    SELECT ci.productID, ci.amount, p.price
    FROM cart_items ci
    JOIN products p ON p.productID = ci.productID
    JOIN cart c ON c.cartID = ci.cartID
    WHERE c.userID = ?
");
$stmt->execute([$userID]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$items) {
    echo json_encode(["success" => false, "message" => "Ostoskorisi on tyhjä"]);
    exit;
}

// --- LASKE SUMMA ---
$total = 0;
foreach ($items as $i) {
    $total += $i["amount"] * $i["price"];
}

// --- LUO TILAUS ---
$stmt = $pdo->prepare("
    INSERT INTO orders (userID, totalPrice)
    VALUES (?, ?)
");
$stmt->execute([$userID, $total]);
$orderID = $pdo->lastInsertId();

// --- ORDER ITEMS ---
$stmt = $pdo->prepare("
    INSERT INTO order_items (orderID, productID, amount)
    VALUES (?, ?, ?)
");

foreach ($items as $i) {
    $stmt->execute([$orderID, $i["productID"], $i["amount"]]);
}

// --- TYHJENNÄ OSTOSKORI ---
$pdo->prepare("
    DELETE FROM cart_items 
    WHERE cartID = (SELECT cartID FROM cart WHERE userID=?)
")->execute([$userID]);

$pdo->prepare("
    DELETE FROM cart WHERE userID=?
")->execute([$userID]);

echo json_encode([
    "success" => true,
    "message" => "Tilaus vahvistettu!"
]);
