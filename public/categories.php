<?php
session_start();
require_once '../backend/config/db_connect.php'; // Yhteys tietokantaan
require_once '../backend/helpers/auth.php';      // Tunnistautumisen apufunktiot
require_once '../backend/helpers/validation.php'; // Validointifunktiot
require_once '../backend/helpers/password_helper.php'; // Salasanan apufunktiot
include "header_footer/header.php";  // Include header

require_once('header_footer/fetchDomain.php');

if (!isset($_GET["category"])) {
    header("location: items.php");
    exit;
}

$category = $_GET["category"];

$apiPath = $domain . "backend/api/products/get_products.php?category=$category";

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $apiPath);

$result = curl_exec($ch);
curl_close($ch);

// Decode JSON to associative array
$data = json_decode($result, true);

// Check if decoding worked
if (!$data) {
    echo "Invalid JSON or empty response";
    exit;
}
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuotteet</title>
    <link rel="stylesheet" href="assets/css/root.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/categories.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 class="top-margin">Tuotteet / <?=$data["categories"][0]["categoryName"]?></h2>
        </div>
        <div class="col">
            <div class="row space-between nav-align">
                <h1 class="top-margin"><?=$data["categories"][0]["categoryName"]?></h1>
                <a href="items.php" class="check-btn" style="width:120px">Takaisin</a>
            </div>
            <div class="categoryRow top-margin">
                <?php
                foreach ($data["categories"] as $category):
                    foreach ($category["products"] as $product):
                ?>
                <div class="col space-between box" onclick=redirectToItem(<?=$product["productID"]?>)>
                    <div id="row-items">
                        <img src="../<?=$product["imagePath"]?>" alt="Kuva" class="product-img">
                        <div class="row space-between nav-align">
                            <h2><?=$product["name"]?></h2>
                            <h4><?=$product["price"]?></h4>
                        </div>
                    </div>
                    <div class="row space-between">
                        <button class="check-btn">Lisää ostoskoriin</button>
                    </div>
                </div>
                <?php
                    endforeach;
                endforeach;
                ?>

            </div>
        </div>
    </div>
    <script>
        function redirectToItem(productID) {
            window.location.href = "item.php?product_id=" + productID
        }
    </script>
</body>
</html>