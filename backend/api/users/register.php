<?php
header("Content-Type: application/json");

require_once "../../config/db_connect.php";
require_once "../../helpers/validation.php";
require_once "../../helpers/password_helper.php";

// -> Luo PDO-yhteys
$pdo = getDBConnection();

$data = json_decode(file_get_contents("php://input"), true);
$errors = [];

// Puhdisstaa syötteet
$firstname = sanitize_input($data['firstname'] ?? '');
$lastname = sanitize_input($data['lastname'] ?? '');
$email = sanitize_input($data['email'] ?? '');
$phone = sanitize_input($data['phone'] ?? '');
$password = $data['password'] ?? '';
$password_confirm = $data['password_confirm'] ?? '';

// Virhe iklmoitujkset

if (is_empty($firstname)) $errors['firstname'] = "Etunimi on pakollinen.";
if (is_empty($lastname)) $errors['lastname'] = "Sukunimi on pakollinen.";

if (is_empty($email)) {
    $errors['email'] = "Sähköposti on pakollinen.";
} elseif (!validate_email($email)) {
    $errors['email'] = "Virheellinen sähköposti.";
}

if (!empty($phone) && !preg_match('/^[0-9 +()-]+$/', $phone)) {
    $errors['phone'] = "Puhelinnumero on virheellinen.";
}

if (is_empty($password)) {
    $errors['password'] = "Salasana on pakollinen.";
} elseif (!validate_password_length($password, 8)) {
    $errors['password'] = "Salasanan tulee olla vähintään 8 merkkiä.";
} elseif ($password !== $password_confirm) {
    $errors['password_confirm'] = "Salasanat eivät täsmää.";
}

// Tarkista duplikaatti sähköposti
if (empty($errors)) {
    $stmt = $pdo->prepare("SELECT userID FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->fetch()) {
        $errors['email'] = "Sähköposti on jo käytössä.";
    }
}

if (!empty($errors)) {
    echo json_encode(["success" => false, "errors" => $errors]);
    exit;
}

// INSERT tietokantaan juuri tehdyn käyttjän tiedot
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("
    INSERT INTO users (email, firstname, lastname, phone, passHash, createdAt)
    VALUES (?, ?, ?, ?, ?, NOW())
");

$ok = $stmt->execute([$email, $firstname, $lastname, $phone, $hashed_password]);

// Lähettää vastauksen json muodossa
echo json_encode([
    "success" => $ok,
    "message" => $ok ? "Rekisteröinti onnistui" : "Rekisteröinti epäonnistui"
]);
