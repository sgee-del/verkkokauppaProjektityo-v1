<?php
session_start();
require_once '../backend/config/db_connect.php'; // Yhteys tietokantaan
require_once '../backend/helpers/auth.php';      // Tunnistautumisen apufunktiot
require_once '../backend/helpers/validation.php'; // Validointifunktiot
require_once '../backend/helpers/password_helper.php'; // Salasanan apufunktiot
include "header_footer/header.php";  // Include header

// Jos käyttäjä on jo kirjautunut, ohjataan hänet etusivulle.
if (is_logged_in()) {
    header('Location: index.php');
    exit;
}

$errors = [];
$email = '';

// Käsitellään lomakkeen lähetys
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Puhdista syötteet
    $email = sanitize_input($_POST['email_or_username']);
    $password = $_POST['password'];

    if (is_empty($email)) {
        $errors['email_or_username'] = "Sähköposti on pakollinen.";
    }
    if (is_empty($password)) {
        $errors['password'] = "Salasana on pakollinen.";
    }

    //Jos syöte ok → tarkistetaan käyttäjä
    if (empty($errors)) {

        // Haetaan käyttäjä sähköpostin perusteella
        $stmt = $pdo->prepare("SELECT userID, email, passHash FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Tarkistetaan salasana
        if ($user && password_verify($password, $user['passHash'])) {

            session_regenerate_id(true);

            // Tallennetaan käyttäjä sessioon
            $_SESSION['userID'] = $user['userID'];
            $_SESSION['email'] = $user['email'];

            header("Location: index.php");
            exit;

        } else {
            $errors['form'] = "Virheellinen sähköposti tai salasana.";
        }
    }
}
?>
<head>
<link rel="stylesheet" href="assets/css/root.css">
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/login.css">

</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
             <div class="card-header"></div>
            <div class="card">
                <div class="card-body">     
                    <div class="content">
                        <form action="login.php" method="post">
                            <div class="form-group mb-3 row login-div">
                                <img src="assets/images/login_g1.svg" class="login-icon">
                                <input type="text" name="email_or_username" id="email_or_username" 
                                    class="form-input <?php echo isset($errors['email_or_username']) ? 'is-invalid' : ''; ?>" 
                                    value="<?php echo htmlspecialchars($email); ?>">
                                <?php if (isset($errors['email_or_username'])): ?>
                                    <div class="invalid-feedback"><?php echo $errors['email_or_username']; ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-4 row login-div">
                                <img src="assets/images/login_g2.svg" class="login-icon">
                                <input type="password" name="password" id="password" 
                                    class="form-input <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>">
                                <?php if (isset($errors['password'])): ?>
                                    <div class="invalid-feedback"><?php echo $errors['password']; ?></div>
                                <?php endif; ?>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Kirjaudu</button>

                            <div class="card-footer text-center">
                                    <p>Eikö sinulla ole tiliä? <a href="register.php">Luo tili</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (isset($errors['form'])): ?>
                        <div class="alert alert-danger"><?php echo $errors['form']; ?></div>
                    <?php endif; ?>
</body>
<?php //include 'header_footer/footer.php'; ?>
