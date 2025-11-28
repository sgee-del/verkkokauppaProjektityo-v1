<?php
session_start();
require_once '../backend/config/db_connect.php'; // Database
require_once '../backend/helpers/auth.php';      // Auth tools

// Pakotetaan kirjautuminen
require_login();

// DB-yhteys
$pdo = getDBConnection();
$userID = $_SESSION["userID"];

// Haetaan käyttäjän tilaukset 
$stmt = $pdo->prepare("
    SELECT orderID, orderDate, totalPrice, status, paymentStatus
    FROM orders
    WHERE userID = ?
    ORDER BY orderDate DESC
");
$stmt->execute([$userID]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

include "header_footer/header.php";
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Omat tilaukset</title>

    <link rel="stylesheet" href="assets/css/root.css">
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<div class="orders-container">

    <h2>Omat tilaukset</h2>
    <p>Täältä näet kaikki tekemäsi tilaukset.</p>

    <?php if (!$orders): ?>
        <p>Et ole tehnyt vielä tilauksia.</p>
    <?php endif; ?>

    <?php foreach ($orders as $order): ?>

        <?php
        // Haetaan tilauksen tuotteet  order_items ja products JOIN
        $stmtItems = $pdo->prepare("
            SELECT oi.productID, oi.amount, p.name, p.price
            FROM order_items oi
            JOIN products p ON p.productID = oi.productID
            WHERE oi.orderID = ?
        ");
        $stmtItems->execute([$order["orderID"]]);
        $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div class="order-box">
            <div class="order-title">
                Tilaus #<?= $order["orderID"] ?>
            </div>

            <div>Pvm: <?= $order["orderDate"] ?></div>
            <div>Tila: <strong><?= $order["status"] ?></strong></div>
            <div>Maksu: <strong><?= $order["paymentStatus"] ?></strong></div>
            <div>Yhteensä: <strong><?= number_format($order["totalPrice"], 2) ?> €</strong></div>

            <h4 style="margin-top:10px;">Tuotteet:</h4>
            <div class="order-items">
                <?php foreach ($items as $i): ?>
                    <div class="item-line">
                        <?= htmlspecialchars($i["name"]) ?>
                        × <?= $i["amount"] ?>
                        — <strong><?= number_format($i["amount"] * $i["price"], 2) ?> €</strong>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    <?php endforeach; ?>

</div>

</body>
</html>