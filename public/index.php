<?php
session_start();
require_once '../backend/config/db_connect.php'; // Yhteys tietokantaan
require_once '../backend/helpers/auth.php';     // Tunnistautumisen apufunktio, Jos ei ole kirautunut, ohjataan login sivulle
include "header_footer/header_frontend.php";  // Include header

// Vaaditaan, että käyttäjä on kirjautunut sisään
check_login_status();
