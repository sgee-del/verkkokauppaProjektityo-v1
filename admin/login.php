<?php
session_start();

// Jos admin on jo kirjautunut → ohjataan reservations.php
if (isset($_SESSION['adminID'])) {
    header("Location: reservations.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/css/root.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="cart-box">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Admin Login</h3>

                        <div id="adminLoginErrors"></div>

                        <form id="adminLoginForm">
                            <div class="form-group mb-3 row login-div">
                                <img src="../assets/images/login_g1.svg" class="login-icon">
                                <input type="text" name="email" class="form-input" placeholder="Admin sähköposti">
                            </div>

                            <div class="form-group mb-4 row login-div">
                                <img src="../assets/images/login_g2.svg" class="login-icon">
                                <input type="password" name="password" class="form-input" placeholder="Salasana">
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Kirjaudu</button>
                        </form>

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

    const errorBox = document.getElementById("adminLoginErrors");
    errorBox.innerHTML = "";

    try {
        const response = await fetch("../backend/api/admin/login.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (!result.success) {
            
            // Näytetään virheet
            for (const key in result.errors) {
                const msg = result.errors[key];
                errorBox.innerHTML += `<div class="alert alert-danger">${msg}</div>`;
            }
        } else {
            // Admin login onnistui → ohjataan reservations.php
            window.location.href = "reservations.php";
        }
        // errorit
    } catch (err) {
        errorBox.innerHTML = `<div class="alert alert-danger">Palvelinvirhe, yritä myöhemmin.</div>`;
        console.error(err);
    }
});
</script>
</body>
</html>
