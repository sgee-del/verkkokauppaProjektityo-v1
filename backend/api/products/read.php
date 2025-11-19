<!-- Hae kaikki tuotteet TODO: tee sama muille -->
<?php
require_once "../../config/db_connect.php";

$stmt = $pdo->query("SELECT * FROM products");
echo json_encode($stmt->fetchAll());
?>