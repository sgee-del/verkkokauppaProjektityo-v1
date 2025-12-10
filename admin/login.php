<?php
session_start();
require_once "../backend/config/db_connect.php";
require_once "../backend/helpers/admin_auth.php";

$pdo = getDBConnection();

// Jos admin on jo kirjautunut, ohjataan suoraan reservations.php
if (is_admin($pdo)) {
    header("Location: reservations.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<link rel="stylesheet" href="../public/assets/css/style.css">
</head>
<body>

<h1>Admin Login</h1>

<div id="adminLoginErrors"></div>

<form id="adminLoginForm">
    <input type="text" name="email" placeholder="Sähköposti" required>
    <input type="password" name="password" placeholder="Salasana" required>
    <button type="submit">Kirjaudu</button>
</form>

<script>
document.getElementById("adminLoginForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());

    const response = await fetch("../backend/api/admin/login_auth.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
    });

    const result = await response.json();
    const errorBox = document.getElementById("adminLoginErrors");
    errorBox.innerHTML = "";

    if (!result.success) {
        Object.values(result.errors).forEach(msg => {
            errorBox.innerHTML += `<div class="alert alert-danger">${msg}</div>`;
        });
    } else {
        // Kirjautuminen onnistui → ohjataan reservations.php
        window.location.href = "reservations.php";
    }
});
</script>

</body>
</html>
