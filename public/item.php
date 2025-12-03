<?php
session_start();

// Sisällytetään tietokantayhteys
require_once '../backend/config/db_connect.php'; // Oletetaan, että tämä on oikea polku

// Tarkistetaan, että product_id on saatu URL:sta
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Haetaan yhteys tietokantaan
    $pdo = getDBConnection(); // Käytämme aiemmin luotua funktiota tietokannan yhteyteen

    // Hae tuotteen tiedot tietokannasta
    $stmt = $pdo->prepare("SELECT * FROM products WHERE productID = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    // Tarkistetaan, että tuote löytyi
    if (!$product) {
        echo "<p>Tuotetta ei löytynyt.</p>";
        exit;
    }

    // Hae tuotteen kategoria
    $category_id = $product['categoryID']; // Tuotteessa oleva categoryID
    $category_stmt = $pdo->prepare("SELECT * FROM categories WHERE categoryID = ?");
    $category_stmt->execute([$category_id]);
    $category = $category_stmt->fetch();

    // Hae tuotekuvat
    $image_stmt = $pdo->prepare("SELECT * FROM product_images WHERE productID = ?");
    $image_stmt->execute([$product_id]);
    $images = $image_stmt->fetchAll();
} else {
    echo "<p>Tuotteen ID puuttuu.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?></title>
    <link rel="stylesheet" href="assets/css/root.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/item.css">
</head>
<body>
    <?php include "header_footer/header.php"; ?> <!-- Include header -->

    <div class="container">
        <div class="cart-box"> 
            <div class="left-section">
                <h1><?= htmlspecialchars($product['name']) ?></h1>
                <div class="price"><?= number_format($product['price'], 2) ?> €</div>
                <p class="description"><?= nl2br(htmlspecialchars($product['descr'])) ?></p>
                <div class="features">Ominaisuudet</div>

                <div class="quantity-section">
                    <div class="quantity-control">
                        <button class="quantity-btn">−</button>
                        <div class="quantity-display">1</div>
                        <button class="quantity-btn">+</button>
                    </div>
                    <button class="add-to-cart-btn">Lisää ostoskoriin</button>
                </div>

                <div class="delivery-info">Toimitus samana päivänä</div>
            </div>

            <div class="right-section">
                <div class="breadcrumb">
                    <a href="items.php">Tuotteet</a> / <a href="categories.php?category=<?= urlencode($category['categoryName']) ?>"><?= htmlspecialchars($category['categoryName']) ?></a> / <?= htmlspecialchars($product['name']) ?>
                </div>
                <a href="items.php" class="back-btn">Takaisin</a>
                
                <?php if (!empty($images)): ?>
                    <div class="product-images">
                        <?php foreach ($images as $image): ?>
                            <img src="assets/<?= htmlspecialchars($image['imagePath']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-img">
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>Tuotteella ei ole kuvia.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
