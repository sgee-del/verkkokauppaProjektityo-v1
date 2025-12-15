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
<link rel="stylesheet" href="../public/assets/css/root.css">
<link rel="stylesheet" href="../public/assets/css/style.css">
<link rel="stylesheet" href="../public/assets/css/login.css">
</head>
<body>

<h1>Admin Login</h1>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="cart-box">
                  <div class="card-header"></div>
                <div class="card">

                    <div class="card-body">

                        <div class="content">

                            
                            <div id="adminLoginErrors"></div>

                            <form id="adminLoginForm">

                                <div class="form-group mb-3 row login-div">
                                    <img src="assets/images/login_g1.svg" class="login-icon">

                                    <input type="text" name="email"
                                           class="form-input" placeholder="Sähköposti">
                                </div>

                                <div class="form-group mb-4 row login-div">
                                    <img src="assets/images/login_g2.svg" class="login-icon">

                                    <input type="password" name="password" id="password"
                                           class="form-input" placeholder="Salasana">
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Kirjaudu</button>

                                <div class="card-footer text-center mt-3">
                                    <p>Eikö sinulla ole tiliä? <a href="register.php">Luo tili</a></p>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

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
