<?php
session_start();
require_once "../backend/config/db_connect.php";
require_once "../backend/helpers/admin_auth.php";

$pdo = getDBConnection();

if (!isset($_GET["upd"]) || $_GET["upd"] !== false) {


    if (!isset($_GET["type"]) || !isset($_GET["id"]) || !is_numeric($_GET["id"])) {
        header("location: items.php");
        exit;
    }

    $getId = $_GET["id"];

    if (isset($_GET["type"]) && $_GET["type"] === "item") {

        // PDO – haetaan tuote oikeilla sarakenimillä
        $stmt = $pdo->prepare("
    SELECT 
        c.categoryID,
        c.categoryName,
        p.productID,
        p.name AS productName,      
        p.price,
        NULL AS imagePath,          
        p.stock
    FROM products p
    JOIN categories c ON p.categoryID = c.categoryID
    WHERE p.productID = :id
");


        $stmt->execute([
            ":id" => $getId
        ]);

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$data) {
            echo "Tuotetta ei löytynyt";
            exit;
        }
    }
} else {
    // Jos admin ei ole kirjautunut, ohjataan takaisin login-sivulle
    header("location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/assets/css/root.css">
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <link rel="stylesheet" href="../admin/assets/css/admin.css">
    <title>Admin</title>
</head>

<body>
    <div class="max-1200">
        <?php
        require_once("includes/admin_nav.php");
        ?>
        <div class="main-content">
            <h1>Hallintapaneeli / Muokkaa / <?= $_GET["type"] ?></h1>
            <?php

            if ($_GET["type"] === "item"):
            ?>
                <form method="post">
                    <div class="edit-div">
                        <input type="hidden" name="editItem">
                        <div class="col space-between">
                            <h3>categoryID</h3>
                            <div class="row space-between">
                                <p><?= $data[0]["categoryID"] ?></p>
                                <input type="text" name="editCategoryID">
                            </div>
                        </div>
                        <div class="col space-between">
                            <h3>categoryName</h3>
                            <div class="row space-between">
                                <p><?= $data[0]["categoryName"] ?></p>
                                <input type="text" name="editCategoryName">
                            </div>
                        </div>
                        <div class="col space-between">
                            <h3>productID</h3>
                            <div class="row space-between">
                                <p><?= $data[0]["productID"] ?></p>
                                <input type="text" name="editProductID">
                            </div>
                        </div>
                        <div class="col space-between">
                            <h3>productName</h3>
                            <div class="row space-between">
                                <p><?= $data[0]["productName"] ?></p>
                                <input type="text" name="editProductName">
                            </div>
                        </div>
                        <div class="col space-between">
                            <h3>price</h3>
                            <div class="row space-between">
                                <p><?= $data[0]["price"] ?></p>
                                <input type="text" name="editPrice">
                            </div>
                        </div>
                        <div class="col space-between">
                            <h3>imagePath</h3>
                            <div class="row space-between">
                                <p><?= $data[0]["imagePath"] ?></p>
                                <input type="text" name="editImagePath">
                            </div>
                        </div>
                        <div class="col space-between">
                            <h3>stock</h3>
                            <div class="row space-between">
                                <p><?= $data[0]["stock"] ?></p>
                                <input type="text" name="editStock">
                            </div>
                        </div>
                    </div>
                    <div class="row space-between">
                        <input type="submit" value="Päivitä">
                        <a href="items.php">Peruuta ja Palaa</a>
                    </div>
                </form>
            <?php
            endif;
            ?>
        </div>
    </div>
</body>

</html>