<?php

/**
 * Tarkistaa, onko käyttäjä kirjautunut sisään.
 *
 * @return bool Palauttaa true, jos käyttäjä on kirjautunut, muuten false.
 */
function is_logged_in(): bool
{
    // Varmistetaan, että sessio on käynnissä
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['KayttajaID']);
}

/**
 * Vaatii käyttäjän olevan kirjautunut.
 * Jos käyttäjä ei ole kirjautunut, ohjaa hänet kirjautumissivulle.
 */
function check_login_status(): void
{
    if (!is_logged_in() && session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}