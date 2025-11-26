<?php
header('Content-Type: application/json');
require_once "../../config/db_connect.php";

// Hae käyttäjän ID
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 0;

if ($user_id <= 0) {
    echo json_encode(["error" => "User ID is required and cannot be negative"]);
    exit();
}
//a fetches all data
if ($user_id === "a") {
    // SQL-kysely tilauksille
    // o = orders, oi = orderID, p.name = productName, pi.imagepath = productImage, p.desc = productDescription 
    $query = "
        SELECT
            o.orderID,
            o.orderDate,
            o.totalPrice,
            o.status AS orderStatus,
            o.paymentStatus,
            oi.productID,
            oi.amount AS productAmount,
            p.name AS productName,
            p.price AS productPrice,
            pi.imagePath AS productImage,
            p.descr AS productDescription
        FROM lahikauppadb.orders o
        JOIN lahikauppadb.order_items oi ON o.orderID = oi.orderID
        JOIN lahikauppadb.products p ON oi.productID = p.productID
        LEFT JOIN lahikauppadb.product_images pi ON p.productID = pi.productID
        ORDER BY o.orderDate DESC;
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

    // Sulje tietokantayhteys
    $conn = null;

} else {
    
    // SQL-kysely tilauksille
    // o = orders, oi = orderID, p.name = productName, pi.imagepath = productImage, p.desc = productDescription 
    $query = "
        SELECT
            o.orderID,
            o.orderDate,
            o.totalPrice,
            o.status AS orderStatus,
            o.paymentStatus,
            oi.productID,
            oi.amount AS productAmount,
            p.name AS productName,
            p.price AS productPrice,
            pi.imagePath AS productImage,
            p.descr AS productDescription
        FROM lahikauppadb.orders o
        JOIN lahikauppadb.order_items oi ON o.orderID = oi.orderID
        JOIN lahikauppadb.products p ON oi.productID = p.productID
        LEFT JOIN lahikauppadb.product_images pi ON p.productID = pi.productID
        WHERE o.userID = :user_id
        ORDER BY o.orderDate DESC;
    ";
    // Yhteys ja kyselyn suoritus
    try {
        $conn = getDBConnection();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
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

    // Sulje tietokantayhteys
    $conn = null;
    }



?>
