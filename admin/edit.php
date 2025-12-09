<?php
require_once("includes/fetchDomain.php");
//if not given any type. type means the type of request, it can be user, item or reservation
if (!isset($_GET["type"]) || !isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("location: items.php");
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
            <h1>Hallintapaneeli / Muokkaa <?=$_GET["type"]?></h1>
            <form method="get">
                <div class="search-nav">
                    <div class="search">
                        <input type="text" name="text" class="textInput" required>
                        <select name="type" class="select-type">
                            <option value="val1">Tyyppi</option>
                            <option value="id">ID</option>
                            <option value="item">Tuote</option>
                            <option value="cate">kategoria</option>
                        </select>
                    </div>
                    <div class="btn-search">
                        <button type="submit">Hae</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>