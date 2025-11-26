<?php
session_start();
require_once '../backend/config/db_connect.php'; // Databadse yhteys
require_once '../backend/helpers/validation.php'; // Otetaan validointifunktiot käyttöön
require_once '../backend/helpers/password_helper.php'; // Otetaan salasanan apufunktiot käyttöön
include "header_footer/header.php"; // Includetaan header

// Alustetaan muuttujat ja virhetaulukko
$errors = [];
$username = '';
$email = '';

// Käsitellään lomakkeen lähetys
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Puhdista syötteet
    $firstname = sanitize_input($_POST['firstname']);
    $lastname = sanitize_input($_POST['lastname']);
    $email = sanitize_input($_POST['email']);
    $phone = sanitize_input($_POST['phone']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Etunimi
    if (is_empty($firstname)) {
        $errors['firstname'] = "Etunimi on pakollinen.";
    }

    // Sukunimi
    if (is_empty($lastname)) {
        $errors['lastname'] = "Sukunimi on pakollinen.";
    }

    // Sähköposti
    if (is_empty($email)) {
        $errors['email'] = "Sähköposti on pakollinen.";
    } elseif (!validate_email($email)) {
        $errors['email'] = "Sähköposti täytyy olla muodossa email@gmail.com ";
    }

    // Puhelin (valinnainen)
    if (!empty($phone) && !preg_match('/^[0-9 +()-]+$/', $phone)) {
        $errors['phone'] = "Puhelinnumeron formaatti on virheellinen.";
    }

    // Salasana
    if (is_empty($password)) {
        $errors['password'] = "Salasana on pakollinen.";
    } elseif (!validate_password_length($password, 8)) {
        $errors['password'] = "Salasanan tulee olla vähintään 8 merkkiä pitkä.";
    } elseif ($password !== $password_confirm) {
        $errors['password_confirm'] = "Salasanat eivät täsmää.";
    }

    // Tarkista, onko sähköposti jo käytössä
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT userID FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $errors['form'] = "Sähköposti on jo käytössä.";
        }
    }

    // Jos virheitä ei ole → luodaan käyttäjä
    if (empty($errors)) {

        // Hashataan salasana
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Tallennetaan käyttäjä tietokantaan
        $stmt = $pdo->prepare("
            INSERT INTO users (email, firstname, lastname, phone, passHash, createdAt)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");

        // Jos tallennus onnistuu, ohjataan kirjautumissivulle
        if ($stmt->execute([$email, $firstname, $lastname, $phone, $hashed_password])) {
            header("Location: login.php?registration=success");
            exit;
        } else {
            $errors['form'] = "Rekisteröinti epäonnistui. Yritä uudelleen.";
        }
    }
}
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
            <div class="card">
                <div class="card-header">
                    
                </div>
                <div class="card-body">
                    <?php if (!empty($errors['form'])): ?>
                        <div class="alert alert-danger"><?php echo $errors['form']; ?></div>
                    <?php endif; ?>

                    <form action="register.php" method="post">

                        <div class="form-group mb-3">
                            <input type="text" placeholder="Etunimi" name="firstname" id="firstname"
                                   class="form-control <?php echo isset($errors['firstname']) ? 'is-invalid' : ''; ?>"
                                   value="<?php echo htmlspecialchars($firstname ?? '') ?>"
                                   required>
                            <?php if (isset($errors['firstname'])): ?>
                                <div class="invalid-feedback"><?php echo $errors['firstname']; ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group mb-3">
                            <input type="text" placeholder="Sukunimi" name="lastname" id="lastname"
                                   class="form-control <?php echo isset($errors['lastname']) ? 'is-invalid' : ''; ?>"
                                   value="<?php echo htmlspecialchars($lastname ?? '') ?>" required>
                            <?php if (isset($errors['lastname'])): ?>
                                <div class="invalid-feedback"><?php echo $errors['lastname']; ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group mb-3">
                          <input type="email" placeholder="Sähköposti" name="email" id="email"
                                   class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>"
                                   value="<?php echo htmlspecialchars($email ?? '') ?>" required>
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback"><?php echo $errors['email']; ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group mb-3">
                            <input type="text" placeholder="Puhelin (valinnainen)" name="phone" id="phone"
                                   class="form-control <?php echo isset($errors['phone']) ? 'is-invalid' : ''; ?>"
                                   value="<?php echo htmlspecialchars($phone ?? '') ?>">
                            <?php if (isset($errors['phone'])): ?>
                                <div class="invalid-feedback"><?php echo $errors['phone']; ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group mb-3">
                            <input type="password" placeholder="Salasana" name="password" id="password"
                                   class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>" required>
                            <?php if (isset($errors['password'])): ?>
                                <div class="invalid-feedback"><?php echo $errors['password']; ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group mb-4">
                            <input type="password" placeholder="Vahvista salasana" name="password_confirm" id="password_confirm"
                                   class="form-control <?php echo isset($errors['password_confirm']) ? 'is-invalid' : ''; ?>" required>
                            <?php if (isset($errors['password_confirm'])): ?>
                                <div class="invalid-feedback"><?php echo $errors['password_confirm']; ?></div>
                            <?php endif; ?>
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


<?php //include 'header_footer/footer.php'; ?>

</body>