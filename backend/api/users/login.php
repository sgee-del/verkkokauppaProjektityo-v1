<?php
header("Content-Type: application/json");
session_start();

require_once "../../config/db_connect.php";
require_once "../../helpers/validation.php";
require_once "../../helpers/password_helper.php";

$pdo = getDBConnection(); // Luo datavase yhteys

$data = json_decode(file_get_contents("php://input"), true);
$errors = [];

// Poimi syötteet
$email = sanitize_input($data["email_or_username"] ?? "");
$password = $data["password"] ?? "";

// Syötteiden validointi
if (is_empty($email)) {
    $errors["email_or_username"] = "Sähköposti on pakollinen.";
}
if (is_empty($password)) {
    $errors["password"] = "Salasana on pakollinen.";
}

if (!empty($errors)) {
    echo json_encode(["success" => false, "errors" => $errors]);
    exit;
}

// Haetaan käyttäjä tietokannasta
$stmt = $pdo->prepare("SELECT userID, email, firstname, passHash FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

// Tarkistetaan salasana 
if (!$user || !password_verify($password, $user["passHash"])) {
    echo json_encode([
        "success" => false,
        "errors" => ["form" => "Virheellinen sähköposti tai salasana."]
    ]);
    exit;
}

// Kirjautuminen onnistui 
session_regenerate_id(true);
$_SESSION["userID"] = $user["userID"];
$_SESSION["email"] = $user["email"];
$_SESSION["firstname"] = $user["firstname"];

echo json_encode(["success" => true, "message" => "Kirjautuminen onnistui"]);
?>