<?php
session_start();
include "header_footer/header.php";

// Jos käyttäjä on jo kirjautunut → etusivulle
if (isset($_SESSION['userID'])) {
    header("Location: index.php");
    exit;
}

// Näytetään onnistunut rekisteröintiviesti
$registration_success_message = '';
if (isset($_GET['registration']) && $_GET['registration'] === 'success') {
    $registration_success_message = "Rekisteröinti onnistui! Voit nyt kirjautua sisään.";
}
?>

<head>
<link rel="stylesheet" href="assets/css/root.css">
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/login.css">
  <link rel="stylesheet" href="assets/css/footer.css">
</head>

<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="cart-box">
                  <div class="card-header"></div>
                <div class="card">

                    <div class="card-body">

                        <div class="content">

                            <?php if (!empty($registration_success_message)): ?>
                                <div class="alert alert-success text-center">
                                    <?php echo $registration_success_message; ?>
                                </div>
                            <?php endif; ?>

                            <!-- AJAX-virheet näkyvät tässä -->
                            <div id="loginErrors"></div>

                            <!-- LOGIN LOMAKE -->
                            <form id="loginForm">

                                <div class="form-group mb-3 row login-div">
                                    <img src="assets/images/login_g1.svg" class="login-icon">

                                    <input type="text" name="email_or_username" id="email_or_username"
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

// AJAX LOGIN 
document.getElementById("loginForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());

    const response = await fetch("../backend/api/users/login.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
    });

    const result = await response.json();
    const errorBox = document.getElementById("loginErrors");
    errorBox.innerHTML = "";

    if (!result.success) {
        if (result.errors) {
            Object.values(result.errors).forEach(msg => {
                errorBox.innerHTML += `<div class="alert alert-danger">${msg}</div>`;
            });
        } else {
            errorBox.innerHTML = `<div class="alert alert-danger">Kirjautuminen epäonnistui.</div>`;
        }
    } else {
        // Kirjautuminen onnistui → ohjaa etusivulle
        window.location.href = "index.php";
    }
});
</script>
<?php
 include "header_footer/footer.php";  // Include footer
 ?>
</body>
