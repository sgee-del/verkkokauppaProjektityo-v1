<?php
header('Content-Type: application/json');
require_once "../../config/db_connect.php";


$query = "
SELECT 
    p.*,
    pi.imagePath
FROM products p
LEFT JOIN product_images pi
    ON pi.productID = p.productID
GROUP BY p.productID;
";
// Yhteys ja kyselyn suoritus
try {
    $conn = getDBConnection();
    $stmt = $conn->prepare($query);
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
?>