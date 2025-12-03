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
    <?php
    require_once("header_footer/header.php");
    ?>
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
<!-- palvelut osio-->
 <section id="palvelut" class="service">
<h2>Palvelumme</h2>
<div class="features">
    <div class="feature-card">
    <div class="feature-icon">🥩</div>
        <h3>Tuoreet tuotteet</h3>
        <p>Laaja valikoima tuoretta lihaa.</p>
</div>
 <div class="feature-card">
     <div class="feature-icon">🚚</div>
     <h3>Nopea toimitus</h3>
    <p>Toimitamme tilaukset nopeasti ja luotettavasti suoraan kotiovellesi</p>
 </div>
 <div class="feature-card">
                <div class="feature-icon">💚</div>
                <h3>Korkea laatu</h3>
                <p>Valitsemme vain parhaat tuotteet varmistaen erinomaisen laadun</p>
            </div>
</div>
</section>

<!-- tieto osio-->
 <section id="tietoa" class="about">
        <div class="about-content">
            <h2>Tietoa meistä:</h2>
            <p>
                Ruoka on moderni verkkokauppa, joka tarjoaa laajan valikoiman laadukasta lihaa. 
                Yritys pyrkii tekemään ruokaostoksista helppoa, nopeaa ja mukavaa. Tuotteidemme valikoima 
                päivittyy jatkuvasti, ja panostamme erityisesti tuoreuteen ja laatuun.
            </p>
        </div>
    </section>
 <!-- Yhteystiedot-osio -->
    <section id="yhteystiedot" class="contact">
        <h2>Ota yhteyttä</h2>
        <div class="contact-info">
            <div class="contact-item">
                <h3>📍 Osoite</h3>
                <p>Kuopio, Suomi</p>
            </div>
            <div class="contact-item">
                <h3>📧 Sähköposti</h3>
                <p>info@ruoka.fi</p>
            </div>
            <div class="contact-item">
                <h3>📞 Puhelin</h3>
                <p>+358 44 978 7395</p>
            </div>
            
        </div>
    </section>


 
</body>
</html>