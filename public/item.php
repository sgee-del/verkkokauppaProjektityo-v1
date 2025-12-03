<?php
session_start();
require_once '../backend/config/db_connect.php'; // Yhteys tietokantaan

// Tarkistetaan, että product_id on saatu URL:sta
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Haetaan yhteys tietokantaan
    $pdo = getDBConnection(); 

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

    <div id="toast"></div>

    <div class="container">
        <div class="cart-box"> 
            <div class="left-section">
                <h1><?= htmlspecialchars($product['name']) ?></h1>
                <div class="price"><?= number_format($product['price'], 2) ?> €</div>
                <p class="description"><?= nl2br(htmlspecialchars($product['descr'])) ?></p>
                <div class="features">Ominaisuudet</div>

                <!-- Määärän valinta -->
                <div class="quantity-section">
                    <button class="quantity-btn-minus" onclick="updateQuantity('minus')">−</button>
                    <div class="quantity-display" id="quantity-display">1</div>
                    <button class="quantity-btn-plus" onclick="updateQuantity('plus')">+</button>
                </div>

                <!-- Lisää oostoskoriin funktio -->
                <button class="add-btn" onclick="addToCart(<?= $product['productID'] ?>)">
                    Lisää ostoskoriin
                </button>
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

    <script>

        // Päivitä määrää
        function updateQuantity(action) {
            const quantityDisplay = document.getElementById("quantity-display");
            let quantity = parseInt(quantityDisplay.innerText);

            // Lisätään tai vähennetään määrää
            if (action === 'plus') {
                quantity += 1;
            } else if (action === 'minus' && quantity > 1) {
                quantity -= 1;
            }

            // Päivitetään määrä HTML:ssä
            quantityDisplay.innerText = quantity;
        }

        // Lisää ostoskoriin
        async function addToCart(productID) {
            const quantity = parseInt(document.getElementById("quantity-display").innerText);

            const res = await fetch("../backend/api/cart/add_to_cart.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ productID, quantity }) // Lähetetään tuotteen ID ja määrä
            });

            const data = await res.json();

            if (data.success) {
                showToast("Tuote lisätty ostoskoriin!");
            } else {
                showToast(data.message || "Lisääminen epäonnistui.");
            }
        }

        // Näytä toast-viesti käyttäjälle
        function showToast(msg) {
            const toast = document.getElementById("toast");

            if (toast) {
                toast.innerText = msg;
                toast.style.display = "block";

                setTimeout(() => {
                    toast.style.display = "none";
                }, 2000);
            } else {
                console.error("Toast elementtiä ei löytynyt!");
            }
        }
    </script>
</body>
</html>
