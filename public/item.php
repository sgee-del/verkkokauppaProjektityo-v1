<?php
session_start();
require_once '../backend/config/db_connect.php'; // Yhteys tietokantaan
require_once '../backend/helpers/auth.php';      // Tunnistautumisen apufunktiot
require_once '../backend/helpers/validation.php'; // Validointifunktiot
require_once '../backend/helpers/password_helper.php'; // Salasanan apufunktio
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuotteen Nimi</title>
    <link rel="stylesheet" href="assets/css/root.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/item.css">
  
</head>
<body>
    <?php
    include "header_footer/header.php";  // Include header
    ?>
    <div class="container">
        <div class="cart-box"> 
        <div class="left-section">
            <h1>Tuotteen Nimi</h1>
            <div class="price">14.99 kpl</div>
            
            <p class="description">
                AJSHJK KAHshD AJSDKKA ajhsdkkjaskd ashdhk ahskjdkj asdjhksdakjhdsk ajsdjksdkja ajdsjk kajkskj aksjskjaskja
            </p>
            
            <div class="features">
                Ominaisuudet
            </div>

            <div class="quantity-section">
                <div class="quantity-control">
                    <button class="quantity-btn">−</button>
                    <div class="quantity-display">1</div>
                    <button class="quantity-btn">+</button>
                </div>
                <button class="add-to-cart-btn">Lisää ostoskoriin</button>
            </div>

            <div class="delivery-info">
                Toimitus samana päivänä 
            </div>
        </div>

        <div class="right-section">
            <div class="breadcrumb">
                Tuotteet / Kategoria / Tuotteen Nimi
            </div>
            <button class="back-btn">Takaisin</button>
            <div class="image-placeholder">
                Tuotekuva
            </div>
        </div>
        </div>
    </div>
</body>
</html>