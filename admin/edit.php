<?php
session_start();

// csrf tokeninluonti
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

require_once "../backend/config/db_connect.php";
require_once "../backend/helpers/admin_auth.php";

$pdo = getDBConnection();

//Tuotteen muokkaus

// TUOTTEEN PÄIVITYS (POST)

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["editItem"])) {

    // CSRF
    if (
        !isset($_POST["csrf_token"]) ||
        !hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"])
    ) {
        $errors[] = "Istunto on vanhentunut, yritä uudelleen";
    }

    // Palauttaa kentän arvon: POST → DB hakee tiedot muokkaus kenttin
    function field_value(string $postKey, string $dbKey, array $data): string
    {
        if (isset($_POST[$postKey])) {
            return htmlspecialchars($_POST[$postKey]);
        }
        return htmlspecialchars($data[0][$dbKey] ?? "");
    }


    // Validoinnit
    $productID  = (int)$_GET["id"];
    $categoryID = filter_input(INPUT_POST, "editCategoryID", FILTER_VALIDATE_INT);
    $name       = trim($_POST["editProductName"] ?? "");
    $price      = filter_input(INPUT_POST, "editPrice", FILTER_VALIDATE_FLOAT);
    $stock      = filter_input(INPUT_POST, "editStock", FILTER_VALIDATE_INT);


    if ($price === false || $price < 0) {
        $errors[] = "Hinta ei ole kelvollinen";
    }

    if ($stock === false || $stock < 0) {
        $errors[] = "Varastosaldo ei ole kelvollinen";
    }


    // Kategorian olemassaolo
    if ($categoryID !== false) {
        $checkCat = $pdo->prepare("
            SELECT 1 FROM categories WHERE categoryID = :cid
        ");
        $checkCat->execute([":cid" => $categoryID]);

        if ($checkCat->rowCount() === 0) {
            $errors[] = "Valittu kategoria ei ole olemassa";
        }
    }

    // Päivitetään jos ei löydy virheitä
    if (empty($errors)) {

        $stmt = $pdo->prepare("
            UPDATE products
            SET
                name = :name,
                price = :price,
                stock = :stock,
                categoryID = :categoryID
            WHERE productID = :productID
        ");

        $stmt->execute([
            ":name"       => $name,
            ":price"      => $price,
            ":stock"      => $stock,
            ":categoryID" => $categoryID,
            ":productID"  => $productID
        ]);

        header("Location: items.php?updated=1");
        exit;
    }
}

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
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $err): ?>
                                <li><?= htmlspecialchars($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <!-- csrf -->
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION["csrf_token"] ?>">
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