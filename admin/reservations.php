<?php
$is_getId = false;
require_once("includes/fetchDomain.php");
//get method of ID
if (isset($_GET["type"]) && $_GET["type"] === "id"  && isset($_GET["text"])) {
    //fetches content of api

    //api path. $domain being the root folder where files exist
    $getId = $_GET["text"];
    if ($getId === "kaikki" || $getId === "all") {
        $getId = "a";
    }

    $apiPath = $domain . "backend/api/orders/get_orders.php?order_id=$getId";
    $is_getId = true;
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
} else {
    $apiPath = $domain . "backend/api/orders/get_orders.php?order_id=a";
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
                                <?=$row["orderStatus"]?>
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