<?php
header("Content-Type: application/json");
session_start();

require_once __DIR__ . "/../../../config/db_connect.php";
require_once __DIR__ . "/../../../helpers/admin_auth.php";

$pdo = getDBConnection();
require_admin($pdo);

$orderID = $_GET['order_id'] ?? null;

if (!$orderID) {
    echo json_encode(["success" => false, "error" => "TilausID puuttuu"]);
    exit;
}

// Haetaan tilauksen päädati
$stmt = $pdo->prepare("SELECT * FROM orders WHERE orderID = ?");
$stmt->execute([$orderID]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo json_encode(["success" => false, "error" => "Tilausta ei löytynyt"]);
    exit;
}

// Haetaan tilauksen tuotteet
$stmt2 = $pdo->prepare("
    SELECT op.productID, p.productName, op.quantity, op.price
    FROM order_products op
    JOIN products p ON op.productID = p.productID
    WHERE op.orderID = ?
");
$stmt2->execute([$orderID]);
$products = $stmt2->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "success" => true,
    "order" => $order,
    "products" => $products
]);
exit;
