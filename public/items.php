<?php
session_start();
require_once '../backend/config/db_connect.php'; // Yhteys tietokantaan
require_once '../backend/helpers/auth.php';      // Tunnistautumisen apufunktiot
require_once '../backend/helpers/validation.php'; // Validointifunktiot
require_once '../backend/helpers/password_helper.php'; // Salasanan apufunktiot
include "header_footer/header.php";  // Include header
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuotteet</title>
    <link rel="stylesheet" href="assets/css/root.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/items.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 class="top-margin">Tuotteet</h2>
        </div>
        <div class="col">
            <div class="row space-between nav-align">
                <h1 class="top-margin">Kategoria1</h1>
                <a href="categories.php" class="check-btn" style="width:120px">Enemmän</a>
            </div>
            <div class="categoryRow row top-margin">
                <?php
                // Fetch from API
                $url = "http://localhost/verkkokauppaProjektityo/backend/api/products/read.php";

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $url);

                $result = curl_exec($ch);
                curl_close($ch);

                // Decode JSON to associative array
                $data = json_decode($result, true);

                // Check if decoding worked
                if (!$data) {
                    echo "Invalid JSON or empty response";
                    exit;
                }

                // Loops each item and show them to user
                foreach ($data as $item):?>
                    <a href="item.php?productId=<?=$item["productID"]?>" style="all:unset;cursor:pointer">
                        <div class="col space-between box">
                            <div id="row-items">
                                <img src="assets/<?=$item["imagePath"]?>" alt="Kuva" class="product-img">
                                <div class="row space-between nav-align">
                                    <h2><?=$item["name"]?></h2>
                                    <h4><?=$item["price"]?></h4>
                                </div>
                            </div>
                        
                        <div class="row space-between">
                            <form method="post">
                                <button class="check-btn">Lisää ostoskoriin</button>
                            </form>
                        </div></a>
                    </div>
                <?php endforeach
                ?>
            </div>
        </div>
    </div>
</body>
</html>