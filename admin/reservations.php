<?php
session_start();
require_once "../backend/config/db_connect.php";
require_once "../backend/helpers/admin_auth.php";

$pdo = getDBConnection();
require_admin($pdo); // Varmistaa, että admin on kirjautunut

// Hakuparametrit
$searchId = $_GET['text'] ?? 'all';
$searchType = $_GET['type'] ?? '';

if ($searchId === 'all' || $searchId === 'kaikki') {
    $stmt = $pdo->prepare("SELECT * FROM orders ORDER BY orderDate DESC");
    $stmt->execute();
} elseif ($searchType === 'id') {
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE orderID = ?");
    $stmt->execute([$searchId]);
} else {
    $stmt = $pdo->prepare("SELECT * FROM orders ORDER BY orderDate DESC");
    $stmt->execute();
}

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Tilaukset</title>
<link rel="stylesheet" href="../public/assets/css/root.css">
<link rel="stylesheet" href="../public/assets/css/style.css">
<link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<h1>Hallintapaneeli / Tilaukset</h1>



<div class="max-1200">
        <?php
        require_once("includes/admin_nav.php");
        ?>
        <div class="main-content">
            <h1>Hallintapaneeli / Tilaukset</h1>
            <form method="get">
                <div class="search-nav">
                    <div class="search">
                        <input type="text" name="text" class="textInput" placeholder="Haku" required>
                        <select name="type" class="select-type">
                            <option value="val1" disabled selected>Tyyppi</option>
                            <option value="id">ID</option>
                        </select>
                    </div>
                    <div class="btn-search">
                        <button type="submit">Hae</button>
                    </div>
                </div>
            </form>
            <div class="output-div">
                <div class="output-headers">
                    <div>
                        <p>
                            TilausID
                        </p>
                    </div>
                    <div>
                        <p>
                            TilausPVM
                        </p>
                    </div>
                    <div>
                        <p>
                            Kokonaishinta
                        </p>
                    </div>
                    <div>
                        <p>
                            Tilauksen tila
                        </p>
                    </div>
                    <div>
                        <p>
                            Maksun tila
                        </p>
                    </div>
                </div>
                <div id="fetchOutput">
                    <?php
                        foreach ($data as $row):
                    ?>
                    <div class="output-row rowJS" style="padding-inline:5px" id="r<?=$row["orderID"]?>">
                        <div>
                            <p id="r1-reservationID">
                                <?=$row["orderID"]?>
                            </p>
                        </div>
                        <div>
                            <p id="r1-reservationDate">
                                <?=$row["orderDate"]?>
                            </p>
                        </div>
                        <div>
                            <p id="r1-subtotal">
                                <?=$row["totalPrice"]?>
                            </p>
                        </div>
                        <div>
                            <p id="r1-reservationState">
                                <?=$row["status"]?>
                            </p>
                        </div>
                        <div>
                            <p id="r1-paymentState">
                                <?=$row["paymentStatus"]?>
                            </p>
                        </div>
                    </div>
                    <?php
                        endforeach;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="popup-bg" id="popup" style="display:none">
        <div class="middle-popup col">
            <div class="row space-between">
                <h1>Tilauksen <span id="rowName"></span> tiedot</h1>
                <button type="button" class="btn-exit" id="btnClose">X</button>
            </div>
            <div class="col">
                <div class="row space-between">
                    <p>orderID</p>
                    <p id="orderID"></p>
                </div>
                <div class="row space-between">
                    <p>orderDate</p>
                    <p id="orderDate"></p>
                </div>
                <div class="row space-between">
                    <p>totalPrice</p>
                    <p id="totalPrice"></p>
                </div>
                <div class="row space-between">
                    <p>orderStatus</p>
                    <p id="orderStatus"></p>
                </div>
                <div class="row space-between">
                    <p>paymentStatus</p>
                    <p id="paymentStatus"></p>
                </div>
                <div class="row space-between">
                    <p>productIds</p>
                    <p id="productIds"></p>
                </div>
                <div class="row space-between">
                    <p>productAmounts</p>
                    <p id="productAmounts"></p>
                </div>
                <div class="row space-between">
                    <p>productNames</p>
                    <p id="productNames"></p>
                </div>
                <div class="row space-between">
                    <p>productPrices</p>
                    <p id="productPrices"></p>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/reservation.js"></script>




</body>
</html>
