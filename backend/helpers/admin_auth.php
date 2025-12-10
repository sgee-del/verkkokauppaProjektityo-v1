<?php

// Otetaan perus-autentikoinnin aputiedosto käyttöön
require_once __DIR__ . '/auth.php';

/**
 * Tarkistaa, onko sisäänkirjautunut käyttäjä admin.
 *
 * @param PDO $pdo Tietokantayhteys.
 * @return bool Palauttaa true, jos käyttäjä on admin, muuten false.
 * 
 */
function is_admin(PDO $pdo): bool {
    if (!isset($_SESSION['adminID'])) {
        return false;
    }

    // Tarkistetaan, että adminID löytyy tietokannasta
    try {
        $stm = $pdo->prepare("SELECT adminID FROM admins WHERE adminID = ?");
        $stm->execute([$_SESSION['adminID']]);
        $admin = $stm->fetch();
        return $admin ? true : false;
    } catch (PDOException $e) {
        error_log("Admin check failed: " . $e->getMessage());
        return false;
    }
}



/* Jos käyttäjä ei ole admin → ohjaa etusivulle */
function require_admin(PDO $pdo): void {
    if (!is_admin($pdo)) {
        // Jos admin ei ole kirjautunut, ohjataan login-sivulle
        header('Location: login.php');
        exit;
    }
}
