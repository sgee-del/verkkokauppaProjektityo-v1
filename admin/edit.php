<?php
require_once("includes/fetchDomain.php");
require_once "../backend/helpers/admin_auth.php";
require_admin($pdo); 

if (!isset($_GET["upd"])) {
    //if not given any type. type means the type of request, it can be user, item or reservation
    if (!isset($_GET["type"]) || !isset($_GET["id"]) || !is_numeric($_GET["id"])) {
        header("location: items.php");
        exit;
    }
    $getId = $_GET["id"];

    if (isset($_GET["type"]) && $_GET["type"] === "item") {
        $apiPath = $domain . "backend/api/products/get_product.php?product_id=$getId";
        //fetches content of api
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $apiPath);

        $result = curl_exec($ch);
        curl_close($ch);

        // Decode JSON to associative array
        $data = json_decode($result, true);

        // Check if decoding worked
        if (!$data) {
            echo "Invalid JSON or empty response";
            exit;
        }
    }
} else {
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
            <h1>Hallintapaneeli / Muokkaa / <?=$_GET["type"]?></h1>
            <?php
            //if product (item) is the requested editable object
            if ($_GET["type"] === "item"):
            ?>
            <form method="post">
                <div class="edit-div">
                    <input type="hidden" name="editItem">
                    <div class="col space-between">
                        <h3>categoryID</h3>
                        <div class="row space-between">
                            <p><?=$data[0]["categoryID"]?></p>
                            <input type="text" name="editCategoryID">
                        </div>
                    </div>
                    <div class="col space-between">
                        <h3>categoryName</h3>
                        <div class="row space-between">
                            <p><?=$data[0]["categoryName"]?></p>
                            <input type="text" name="editCategoryName">
                        </div>
                    </div>
                    <div class="col space-between">
                        <h3>productID</h3>
                        <div class="row space-between">
                            <p><?=$data[0]["productID"]?></p>
                            <input type="text" name="editProductID">
                        </div>
                    </div>
                    <div class="col space-between">
                        <h3>productName</h3>
                        <div class="row space-between">
                            <p><?=$data[0]["productName"]?></p>
                            <input type="text" name="editProductName">
                        </div>
                    </div>
                    <div class="col space-between">
                        <h3>price</h3>
                        <div class="row space-between">
                            <p><?=$data[0]["price"]?></p>
                            <input type="text" name="editPrice">
                        </div>
                    </div>
                    <div class="col space-between">
                        <h3>imagePath</h3>
                        <div class="row space-between">
                            <p><?=$data[0]["imagePath"]?></p>
                            <input type="text" name="editImagePath">
                        </div>
                    </div>
                    <div class="col space-between">
                        <h3>stock</h3>
                        <div class="row space-between">
                            <p><?=$data[0]["stock"]?></p>
                            <input type="text" name="editStock">
                        </div>
                    </div>
                </div>
                <div class="row space-between">
                    <input type="submit" value="Päivitä" name="upd">
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