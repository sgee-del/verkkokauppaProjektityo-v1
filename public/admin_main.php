<?php
session_start();
require_once '../backend/config/db_connect.php';
require_once '../backend/helpers/admin_auth.php';

// Vaaditaan admin-oikeudet sivun näyttämiseen.
require_admin($pdo);

// Tähän voisi sisällyttää admin-puolen headerin
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Hallintapaneeli</title>
</head>
<body>
    <h1>Tervetuloa hallintapaneeliin!</h1>
    <p>Tämä sivu näkyy vain käyttäjille, joilla on admin-oikeudet.</p>
</body>
</html>