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
    <link rel="stylesheet" href="assets/css/categories.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 class="top-margin">Tuotteet / Kategoria1</h2>
        </div>
        <div class="col">
            <div class="row space-between nav-align">
                <h1 class="top-margin">Kategoria1</h1>
                <a href="items.php" class="check-btn" style="width:120px">Takaisin</a>
            </div>
            <div class="categoryRow top-margin">
                <div class="col space-between box">
                    <div id="row-items">
                        <img src="assets/images/background/green.svg" alt="Kuva" class="product-img">
                        <div class="row space-between nav-align">
                            <h2>Makkara</h2>
                            <h4>12.99</h4>
                        </div>
                    </div>
                    <div class="row space-between">
                        <button class="check-btn">Lisää ostoskoriin</button>
                    </div>
                </div>
                <div class="col space-between box">
                    <div id="row-items">
                        <img src="assets/images/background/green.svg" alt="Kuva" class="product-img">
                        <div class="row space-between nav-align">
                            <h2>Makkara</h2>
                            <h4>12.99</h4>
                        </div>
                    </div>
                    <div class="row space-between">
                        <button class="check-btn">Lisää ostoskoriin</button>
                    </div>
                </div>
                <div class="col space-between box">
                    <div id="row-items">
                        <img src="assets/images/background/green.svg" alt="Kuva" class="product-img">
                        <div class="row space-between nav-align">
                            <h2>Makkara</h2>
                            <h4>12.99</h4>
                        </div>
                    </div>
                    <div class="row space-between">
                        <button class="check-btn">Lisää ostoskoriin</button>
                    </div>
                </div>
                <div class="col space-between box">
                    <div id="row-items">
                        <img src="assets/images/background/green.svg" alt="Kuva" class="product-img">
                        <div class="row space-between nav-align">
                            <h2>Makkara</h2>
                            <h4>12.99</h4>
                        </div>
                    </div>
                    <div class="row space-between">
                        <button class="check-btn">Lisää ostoskoriin</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>