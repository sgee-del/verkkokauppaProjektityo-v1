<?php
header("Content-Type: application/json");

require_once "../../config/db_connect.php";


$pdo = getDBConnection();

//get item with product id
if (isset($_GET["product_id"]) && is_numeric($_GET["product_id"])) {

    $product_id = $_GET["product_id"];

    $stmt = $pdo->prepare("
        SELECT 
            c.categoryID,
            c.categoryName,
            p.productID,
            p.name AS productName,
            p.price,
            pi.imagePath,
            p.stock
        FROM categories c
        LEFT JOIN products p ON p.categoryID = c.categoryID
        LEFT JOIN product_images pi ON p.productID = pi.productID
        WHERE p.productID = :product_id
        ORDER BY c.categoryName, p.name;
    ");
    
    try {
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Hae kaikki tulokset
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Näytä virhe tai tilaukset
        if (empty($orders)) {
            echo json_encode(["message" => "No orders found"]);
        } else {
            // Palauta tilaukset JSON-muodossa
            echo json_encode($orders);
        }
    } catch (PDOException $e) {
        // Virhenkäsittely
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
} elseif (isset($_GET["product_name"])) {

    $product_name = $_GET["product_name"];

    $stmt = $pdo->prepare("
        SELECT 
            c.categoryID,
            c.categoryName,
            p.productID,
            p.name AS productName,
            p.price,
            pi.imagePath,
            p.stock
        FROM categories c
        LEFT JOIN products p ON p.categoryID = c.categoryID
        LEFT JOIN product_images pi ON p.productID = pi.productID
        WHERE p.name = :product_name
        ORDER BY c.categoryName, p.name;
    ");
    
    try {
        $stmt->bindParam(':product_name', $product_name, PDO::PARAM_INT);
        $stmt->execute();
        
        // Hae kaikki tulokset
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Näytä virhe tai tilaukset
        if (empty($orders)) {
            echo json_encode(["message" => "No orders found"]);
        } else {
            // Palauta tilaukset JSON-muodossa
            echo json_encode($orders);
        }
    } catch (PDOException $e) {
        // Virhenkäsittely
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
} elseif (isset($_GET["product_category"])) {
    
    $product_category = $_GET["product_category"];

    $stmt = $pdo->prepare("
        SELECT 
            c.categoryID,
            c.categoryName,
            p.productID,
            p.name AS productName,
            p.price,
            pi.imagePath,
            p.stock
        FROM categories c
        LEFT JOIN products p ON p.categoryID = c.categoryID
        LEFT JOIN product_images pi ON p.productID = pi.productID
        WHERE c.categoryName = :product_category
        ORDER BY c.categoryName, p.name;
    ");
    
    try {
        $stmt->bindParam(':product_category', $product_category, PDO::PARAM_INT);
        $stmt->execute();
        
        // Hae kaikki tulokset
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Näytä virhe tai tilaukset
        if (empty($orders)) {
            echo json_encode(["message" => "No orders found"]);
        } else {
            // Palauta tilaukset JSON-muodossa
            echo json_encode($orders);
        }
    } catch (PDOException $e) {
        // Virhenkäsittely
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
}
?>