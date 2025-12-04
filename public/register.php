<?php
session_start();
include "header_footer/header.php";
?>

<body>
<head>
    <link rel="stylesheet" href="assets/css/root.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/register.css">
</head>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="cart-box">
                <div class="card">
                <h3 class="text-center">Rekisteröidy</h3>
                    <div class="card-header">
                    </div>

                    <div class="card-body">
                        <!-- AJAX-virheilmoitukset -->
                        <div id="formErrors"></div>

                        <!-- REKISTERÖINTI LOMAKE -->
                        <form id="registerForm">

                            <div class="form-group mb-3">
                                <input type="text" placeholder="Etunimi" name="firstname" id="firstname"
                                       class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <input type="text" placeholder="Sukunimi" name="lastname" id="lastname"
                                       class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <input type="email" placeholder="Sähköposti" name="email" id="email"
                                       class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <input type="text" placeholder="Puhelin (valinnainen)" name="phone" id="phone"
                                       class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <input type="password" placeholder="Salasana" name="password" id="password"
                                       class="form-control" required>
                            </div>

                            <div class="form-group mb-4">
                                <input type="password" placeholder="Vahvista salasana" name="password_confirm" id="password_confirm"
                                       class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Rekisteröidy</button>
                        </form>
                    </div>

                    <div class="card-footer text-center">
                        <p>Onko sinulla jo tili? <a href="login.php">Kirjaudu sisään</a></p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
// AJAX REKISTERÖINTI 
document.getElementById("registerForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const form = document.getElementById("registerForm");
    const data = Object.fromEntries(new FormData(form).entries());

    const res = await fetch("../backend/api/users/register.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
    });

    const result = await res.json();

    // tyhjentnää virheilmoitujkset
    const errorBox = document.getElementById("formErrors");
    errorBox.innerHTML = "";

    // Jos rekisteröinti onnistui
    if (!result.success) {
        if (result.errors) {
            Object.values(result.errors).forEach(msg => {
                errorBox.innerHTML += `<div class="alert alert-danger">${msg}</div>`;
            });
        } else {
            errorBox.innerHTML = `<div class="alert alert-danger">Tuntematon virhe.</div>`;
        }
    } else {
        window.location.href = "login.php?registration=success";
    }
});
</script>

<?php //include "header_footer/footer.php"; ?>
</body>
