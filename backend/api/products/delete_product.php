<?php
header("Content-Type: application/json");

require_once "../../config/db_connect.php";


$pdo = getDBConnection();

if (isset($_GET["product_id"]) && is_numeric($_GET["product_id"])) {

    $product_id = $_GET["product_id"];

    $stmt = $pdo->prepare("
        DELETE
        FROM products
        WHERE productID = :product_id
    ");
    
    try {
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();

        // Check how many rows were deleted
        if ($stmt->rowCount() > 0) {
            echo json_encode(["message" => "Product deleted"]);
        } else {
            echo json_encode(["message" => "Product not found"]);
        }
    } catch (PDOException $e) {
        // Virhenkäsittely
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
}

?>