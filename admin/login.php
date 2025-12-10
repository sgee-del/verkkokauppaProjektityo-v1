<?php
session_start();
require_once "../backend/config/db_connect.php"; 
require_once "../backend/helpers/admin_auth.php"; 

if (isset($_SESSION['adminID'])) {
    header("Location: dashboard.php");
    exit;
}

?>
<form method="post">
    <input type="email" name="email" placeholder="Admin Email" required>
    <input type="password" name="password" placeholder="Salasana" required>
    <button type="submit">Kirjaudu sisään</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stm = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
    $stm->execute([$_POST['email']]);
    $admin = $stm->fetch();

    if (!$admin || !password_verify($_POST['password'], $admin['passHash'])) {
        echo "Virheellinen admin-kirjautuminen";
        exit;
    }

    $_SESSION['adminID'] = $admin['adminID'];
    $_SESSION['roleID'] = $admin['roleID'];

    header("Location: dashboard.php");
    exit;
}
