<?php
header("Content-Type: application/json");
session_start();

require_once "../../config/db_connect.php";

if (!isset($_SESSION["userID"])) {
    echo json_encode(["success" => false, "message" => "Kirjaudu sisään."]);
    exit;
}

$pdo = getDBConnection();
$userID = $_SESSION["userID"];

$stmt = $pdo->prepare("SELECT street, city, zip FROM addresses WHERE userID = ?");
$stmt->execute([$userID]);
$address = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    "success" => true,
    "address" => $address ?: null
]);
