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
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
    
</body>
</html>