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

    if (!is_logged_in()) {
        return false;
    }

    try {

        // Haetaan käyttäjä admins-taulusta usersin id:n perusteella TODO roolit!
        $stm = $pdo->prepare("
            SELECT ar.roleName
            FROM admins a
            JOIN admin_roles ar ON a.roleID = ar.roleID
            WHERE a.email = (
                SELECT email FROM users WHERE userID = ?
            )
        ");

        $stm->execute([$_SESSION['userID']]);
        $role = $stm->fetch();

        if ($role && $role['roleName'] === 'admin') {
            return true;
        }

    } catch (PDOException $e) {
        error_log("Admin check failed: " . $e->getMessage());
    }

    return false;
}


/* Jos käyttäjä ei ole admin → ohjaa etusivulle */
function require_admin(PDO $pdo): void
{
    if (!is_admin($pdo)) {
        header('Location: index.php'); // Ohjataan pois admin-sivulta
        exit;
    }
}