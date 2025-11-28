<?php
header("Content-Type: application/json");
session_start();

require_once "../../config/db_connect.php";

if (!isset($_SESSION["userID"])) {
    echo json_encode([
        "success" => false,
        "message" => "Sinun tulee kirjautua nähdäksesi ostoskorin."
    ]);
    exit;
}

$pdo = getDBConnection();
$userID = $_SESSION["userID"];

// Hae käyttäjän ostoskori
$stmt = $pdo->prepare("SELECT cartID FROM cart WHERE userID = ?");
$stmt->execute([$userID]);
$cart = $stmt->fetch();

if (!$cart) {
    echo json_encode([
        "success" => true,
        "items" => [],
        "total" => 0
    ]);
    exit;
}

$cartID = $cart["cartID"];

// Hae tuotteet
$stmt = $pdo->prepare("
    SELECT 
        p.productID,
        p.name,
        p.price,
        pi.imagePath,
        ci.amount AS quantity
    FROM cart_items ci
    INNER JOIN products p ON p.productID = ci.productID
    LEFT JOIN product_images pi ON p.productID = pi.productID
    WHERE ci.cartID = ?
");
$stmt->execute([$cartID]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;

foreach ($items as &$item) {
    $item["cartID"] = $cartID;
    $item["price"] = (float)$item["price"];
    $item["quantity"] = (int)$item["quantity"];
    $item["total"] = $item["price"] * $item["quantity"];

    // Käytetään yhdistelmätunnistetta cartID+productID JS:ssä
    $item["cartItemID"] = $cartID . "_" . $item["productID"];

    // jos kuva puuttuu → placeholder
    if (empty($item["imagePath"])) {
        $item["imagePath"] = "assets/images/placeholder.jpg";
    } else {
        $item["imagePath"] = "../" . $item["imagePath"];
    }

    $total += $item["total"];
}

echo json_encode([
    "success" => true,
    "items" => $items,
    "total" => $total
]);
?>
