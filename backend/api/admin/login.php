<?php
require_once "../../../config/db_connect.php";

header("Content-Type: application/json");

$input = json_decode(file_get_contents("php://input"), true); // FIXED

$email = $input['email'] ?? '';
$password = $input['password'] ?? '';

$errors = [];

if (empty($email)) $errors['email'] = "Sähköposti on pakollinen";
if (empty($password)) $errors['password'] = "Salasana on pakollinen";

if (!empty($errors)) {
    echo json_encode(["success" => false, "errors" => $errors]);
    exit;
}

$stm = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
$stm->execute([$email]);
$admin = $stm->fetch();

if (!$admin || !password_verify($password, $admin['passHash'])) {
    echo json_encode([
        "success" => false,
        "errors" => ["login" => "Virheellinen sähköposti tai salasana"]
    ]);
    exit;
}

session_start();
$_SESSION['adminID'] = $admin['adminID'];
$_SESSION['roleID'] = $admin['roleID'];

echo json_encode(["success" => true]);
exit;
