<?php

// Aloitetaan sessio, jos ei ole vielä käynnissä
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Tyhjennetään kaikki sessiomuuttujat
$_SESSION = [];

// Tarkistetaan, onko sessioncookies käytössä ja tuhotetaan ne
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();

    // setcookie-funktiolla asetetaan evästeen vanhentumaan
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Lopetetaan sessio kokonaan
session_destroy();

// Ohjataan käyttäjä kirjautumissivulle
header("Location: login.php", true, 303);
exit;
?>