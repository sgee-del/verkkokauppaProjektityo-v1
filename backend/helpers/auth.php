<?php

/* @return bool Palauttaa true, jos käyttäjä on kirjautunut, muuten false */
function is_logged_in(): bool
{
    // Varmistetaan, että sessio on käynnissä
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['userID']);
}

/* Jos käyttäjä ei ole kirjautunut, ohjaa hänet kirjautumissivulle */
function require_login(): void
{
    if (!is_logged_in()) {
        session_start();
        header('Location: login.php');
        exit;
    }
}