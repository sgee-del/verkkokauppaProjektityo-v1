<!-- Hae kaikki tuotteet-->
<?php
require_once "../../config/db_connect.php";

$stmt = $pdo->query("SELECT * FROM products");
echo json_encode($stmt->fetchAll());
?>