<?php
session_start();

// CSRF tokenin luonti
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

require_once "../backend/config/db_connect.php";
require_once "../backend/helpers/admin_auth.php";

// Yhteys tietokantaan
$pdo = getDBConnection();

// virhetaulukko
$errors = []; 

// Funktio palauttaa kentän arvon lomakkeessa
function field_value(string $postKey, string $dbKey, array $data): string
{
    if (isset($_POST[$postKey])) {
        return htmlspecialchars($_POST[$postKey]);
    }
    return htmlspecialchars($data[0][$dbKey] ?? "");
}

// GET tarkistus ja id numero ja tietojen haku
if (!isset($_GET["type"], $_GET["id"]) || !is_numeric($_GET["id"])) {
    header("location: items.php");
    exit;
}

// tallennetaan id muuttujaan
$getId = (int)$_GET["id"];

// Haetaan tuotetiedot tietokannasta
$stmt = $pdo->prepare("
    SELECT 
        c.categoryID,
        c.categoryName,
        p.productID,
        p.name AS productName,
        p.price,
        p.stock,
        p.descr
    FROM products p
    JOIN categories c ON p.categoryID = c.categoryID
    WHERE p.productID = :id
");
$stmt->execute([":id" => $getId]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Virhe tarkastus jos tuoetetta ei löydy
if (!$data) {
    echo "Tuotetta ei löytynyt";
    exit;
}

// POST metodlla päpivitetään tuotetiedot
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["editItem"])) {

    // CSRF
    if (!isset($_POST["csrf_token"]) || !hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"])) {
        $errors[] = "Istunto on vanhentunut, yritä uudelleen";
    }

    // Syötetyt tiedot ja niiden validointi
    $productID  = (int)($_POST['editProductID'] ?? 0);
    $categoryID = filter_input(INPUT_POST, "editCategoryID", FILTER_VALIDATE_INT);
    $name       = trim($_POST["editProductName"] ?? "");
    $price      = filter_input(INPUT_POST, "editPrice", FILTER_VALIDATE_FLOAT);
    $stock      = filter_input(INPUT_POST, "editStock", FILTER_VALIDATE_INT);
    $descr      = trim($_POST["editDescr"] ?? "");

    // Tarkistukset että uudet  tiedot ovatkelvollisia
    if ($name === "") {
        $errors[] = "Tuotteen nimi ei voi olla tyhjä";
    }

    if ($price === false || $price < 0) {
        $errors[] = "Hinta ei ole kelvollinen";
    }

    if ($stock === false || $stock < 0) {
        $errors[] = "Varastosaldo ei ole kelvollinen";
    }

    // Kategorian olemassaolo
    if ($categoryID !== false) {
        $checkCat = $pdo->prepare("SELECT 1 FROM categories WHERE categoryID = :cid");
        $checkCat->execute([":cid" => $categoryID]);
        if ($checkCat->rowCount() === 0) {
            $errors[] = "Valittu kategoria ei ole olemassa";
        }
    }

    // Jos virheitä ei ole niin päivitetään ttiedot tietokantaan
    if (empty($errors)) {
        $update = $pdo->prepare("
            UPDATE products
            SET name = :name,
                price = :price,
                stock = :stock,
                categoryID = :categoryID,
                descr = :descr
            WHERE productID = :productID
        ");
        $update->execute([
            ":name"       => $name,
            ":price"      => $price,
            ":stock"      => $stock,
            ":categoryID" => $categoryID,
            ":descr"      => $descr,
            ":productID"  => $productID
        ]);

        // Ohjataan takasin items.phph sivulle päivityksen jälkeen
        header("Location: items.php?updated=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/assets/css/root.css">
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <link rel="stylesheet" href="../admin/assets/css/admin.css">
    <title>Admin - Muokkaa tuotetta</title>
</head>
<body>
<div class="max-1200">
<?php require_once("includes/admin_nav.php"); ?>
<div class="main-content">
    <h1>Hallintapaneeli / Muokkaa / <?= htmlspecialchars($_GET["type"]) ?></h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- FORM tuotetietojen muokkaukseen -->
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION["csrf_token"] ?>">
        <input type="hidden" name="editCategoryID" value="<?= field_value('editCategoryID', 'categoryID', $data) ?>">
        <input type="hidden" name="editProductID" value="<?= $data[0]['productID'] ?>">
        <input type="hidden" name="editItem" value="1">

        <div class="edit-div">
            <div class="col space-between">
                <h3>Kategoria</h3>
                <div class="row space-between">
                    <p><?= htmlspecialchars($data[0]["categoryName"]) ?></p>
                </div>
            </div>

            <div class="col space-between">
                <h3>Tuote ID</h3>
                <div class="row space-between">
                    <p><?= htmlspecialchars($data[0]["productID"]) ?></p>
                </div>
            </div>

            <div class="col space-between">
                <h3>Tuotteen nimi</h3>
                <div class="row space-between">
                    <input type="text" name="editProductName" required
                        value="<?= field_value('editProductName', 'productName', $data) ?>">
                </div>
            </div>

            <div class="col space-between">
                <h3>Hinta</h3>
                <div class="row space-between">
                    <input type="text" name="editPrice" required
                        value="<?= field_value('editPrice', 'price', $data) ?>">
                </div>
            </div>

            <div class="col space-between">
                <h3>Tuote kuvaus</h3>
                <div class="row space-between">
                    <input type="text" name="editDescr"
                        value="<?= field_value('editDescr', 'descr', $data) ?>">
                </div>
            </div>

            <div class="col space-between">
                <h3>Vaastosaldo</h3>
                <div class="row space-between">
                    <input type="text" name="editStock"
                        value="<?= field_value('editStock', 'stock', $data) ?>">
                </div>
            </div>
        </div>

        <div class="row space-between">
            <input type="submit" value="Päivitä">
            <a href="items.php">Peruuta ja Palaa</a>
        </div>
    </form>
</div>
</div>
</body>
</html>
