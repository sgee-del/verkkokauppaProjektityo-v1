<?php
header("Content-Type: application/json");
session_start();

require_once "../backend/config/db_connect.php";
require_once "../backend/helpers/validation.php";
require_once "../backend/helpers/password_helper.php";

$pdo = getDBConnection();

$data = json_decode(file_get_contents("php://input"), true);
$errors = [];

$email = sanitize_input($data["email"] ?? "");
$password = $data["password"] ?? "";

// Validointi
if (is_empty($email)) {
    $errors["email"] = "Sähköposti on pakollinen.";
}
if (is_empty($password)) {
    $errors["password"] = "Salasana on pakollinen.";
}

if (!empty($errors)) {
    echo json_encode(["success" => false, "errors" => $errors]);
    exit;
}

// Haetaan admin
$stmt = $pdo->prepare("SELECT adminID, email, passHash, roleID FROM admins WHERE email = ?");
$stmt->execute([$email]);
$admin = $stmt->fetch();

if (!$admin || !password_verify($password, $admin["passHash"])) {
    echo json_encode([
        "success" => false,
        "errors" => ["form" => "Virheellinen sähköposti tai salasana."]
    ]);
    exit;
}

// Kirjautuminen OK
session_regenerate_id(true);
$_SESSION["adminID"] = $admin["adminID"];
$_SESSION["email"] = $admin["email"];
$_SESSION["roleID"] = $admin["roleID"];

echo json_encode(["success" => true]);
?>
