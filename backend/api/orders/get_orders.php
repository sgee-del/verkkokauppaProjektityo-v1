<?php
header('Content-Type: application/json');
require_once "../../config/db_connect.php";

// Hae käyttäjän ID
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 0;

if ($order_id <= 0) {
    echo json_encode(["error" => "order ID is required and cannot be negative"]);
    exit();
}
//a fetches all data
if ($order_id === "a") {
    // SQL-kysely tilauksille
    // o = orders, oi = orderID, p.name = productName, pi.imagepath = productImage, p.desc = productDescription 
    $query = "
        SELECT
        o.orderID,
        o.userID,
        o.orderDate,
        o.totalPrice,
        o.status AS orderStatus,
        o.paymentStatus,

        GROUP_CONCAT(oi.productID) AS productIDs,
        GROUP_CONCAT(oi.amount) AS productAmounts,
        GROUP_CONCAT(p.name) AS productNames,
        GROUP_CONCAT(p.price) AS productPrices,
        GROUP_CONCAT(pi.imagePath) AS productImages,
        GROUP_CONCAT(p.descr) AS productDescriptions

        FROM lahikauppadb.orders o
        JOIN lahikauppadb.order_items oi ON o.orderID = oi.orderID
        JOIN lahikauppadb.products p ON oi.productID = p.productID
        LEFT JOIN lahikauppadb.product_images pi ON p.productID = pi.productID

        GROUP BY o.orderID
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
        o.userID,
        o.orderDate,
        o.totalPrice,
        o.status AS orderStatus,
        o.paymentStatus,

        GROUP_CONCAT(oi.productID) AS productIDs,
        GROUP_CONCAT(oi.amount) AS productAmounts,
        GROUP_CONCAT(p.name) AS productNames,
        GROUP_CONCAT(p.price) AS productPrices,
        GROUP_CONCAT(pi.imagePath) AS productImages,
        GROUP_CONCAT(p.descr) AS productDescriptions

        FROM lahikauppadb.orders o
        JOIN lahikauppadb.order_items oi ON o.orderID = oi.orderID
        JOIN lahikauppadb.products p ON oi.productID = p.productID
        LEFT JOIN lahikauppadb.product_images pi ON p.productID = pi.productID
        WHERE o.orderID = :order_id

        GROUP BY o.orderID
        ORDER BY o.orderDate DESC;
    ";
    // Yhteys ja kyselyn suoritus
    try {
        $conn = getDBConnection();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
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
