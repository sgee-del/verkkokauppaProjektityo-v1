<?php
session_start();
require_once '../backend/config/db_connect.php'; // Yhteys tietokantaan
require_once '../backend/helpers/auth.php';      // Tunnistautumisen apufunktiot
include "header_footer/header_frontend.php";  // Include header

// Vaaditaan, että käyttäjä on kirjautunut sisään
//require_login();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruoka</title>
    <link rel="stylesheet" href="assets/css/root.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
     <div class="hero-bg">
        <div class="hero-content">
    <div class="class-img">
<img src="../images/index.jpg" alt="">



</div>
<div class="row space-between w-100 column">
<h1 class = "text-primary">Ruoka <br>verkko <br> kauppa </h1>
<button class="class-button">Valikoima</button>

</div>
    </div>
    </div>
</body>
</html>