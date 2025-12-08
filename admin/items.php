<?php
require_once("includes/fetchDomain.php");

$is_getId = false;
//get method of ID
if (isset($_GET["type"]) && isset($_GET["text"]) && $_GET["type"] !== "val1") {

    //fetches content of api

    //api path. $domain being the root folder where files exist

    $getId = $_GET["text"];
    //switch case for the type of requested type
    switch ($_GET["type"]) {
        case 'id':
            $apiPath = $domain . "backend/api/products/get_product.php?product_id=$getId";
            $is_getId = true;
            break;
        case 'item':
            $getId = str_replace(" ", "+", $getId);
            $apiPath = $domain . "backend/api/products/get_product.php?product_name=$getId";
            $is_getId = true;
            break;
        case 'cate':
            $getId = str_replace(" ", "+", $getId);
            $apiPath = $domain . "backend/api/products/get_product.php?product_category=$getId";
            $is_getId = true;
            break;
        default:
            # code...
            break;
    }
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
 if (!$is_getId) {
    $apiPath = $domain . "backend/api/products/get_products.php";
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
            <h1>Hallintapaneeli / Tuotteet</h1>
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
            <div class="output-div">
                <div class="output-headers">
                    <div>
                        <p>
                            id
                        </p>
                    </div>
                    <div>
                        <p>
                            Kuva
                        </p>
                    </div>
                    <div>
                        <p>
                            Tuote
                        </p>
                    </div>
                    <div>
                        <p>
                            Tyyppi
                        </p>
                    </div>
                    <div>
                        <p>
                            Varasto
                        </p>
                    </div>
                </div>
                <div id="fetchOutput">
                    <?php
                    if (!$is_getId):
                        //fetch all possible items
                        foreach ($data["categories"] as $category):
                            foreach ($category["products"] as $product):
                            ?>
                                <div class="output-row rowJS" style="padding-inline:5px" id="r<?=$product["productID"]?>">
                                    <div>
                                        <p id="r1-productID">
                                            <?=$product["productID"]?>
                                        </p>
                                    </div>
                                    <div>
                                        <p id="r1-imagePath">
                                            <img src="../<?=$product['imagePath']?>" style="height:30px;max-width:100px">
                                        </p>
                                    </div>
                                    <div>
                                        <p id="r1-name">
                                            <?=$product["name"]?>
                                        </p>
                                    </div>
                                    <div>
                                        <p id="r1-categoryName">
                                            <?=$category["categoryName"]?>
                                        </p>
                                    </div>
                                    <div>
                                        <p id="r1-stock">
                                            <?=$product["stock"]?>
                                        </p>
                                    </div>
                                </div>
                                <?php
                            endforeach;
                        endforeach;
                    else:
                        //when only specific data is being fetched
                        foreach ($data as $row):?>
                            <div class="output-row rowJS" style="padding-inline:5px" id="r<?=$row["productID"]?>">
                                <div>
                                    <p id="r1-categoryID">
                                        <?=$row["productID"]?>
                                    </p>
                                </div>
                                <div>
                                    <p id="r1-imagePath">
                                        <img src="../<?=$row['imagePath']?>" style="height:30px;max-width:100px">
                                    </p>
                                </div>
                                <div>
                                    <p id="r1-productName">
                                        <?=$row["productName"]?>
                                    </p>
                                </div>
                                <div>
                                    <p id="r1-categoryID">
                                        <?=$row["categoryName"]?>
                                    </p>
                                </div>
                                <div>
                                    <p id="r1-stock">
                                        <?=$row["stock"]?>
                                    </p>
                                </div>
                            </div>
                    <?php
                    endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="popup-bg" id="popup" style="display:none">
        <div class="middle-popup col">
            <div class="row space-between">
                <h1>Tuotteen <span id="rowName"></span> tiedot</h1>
                <button type="button" class="btn-exit" id="btnClose">X</button>
            </div>
            <div class="col">
                <img src="assets/images/cart.png" id="productImg">
                <div class="row space-between">
                    <p>Tuote ID</p>
                    <p id="productID"></p>
                </div>
                <div class="row space-between">
                    <p>Nimi</p>
                    <p id="productName"></p>
                </div>
                <div class="row space-between">
                    <p>Kategoria</p>
                    <p id="productCategory"></p>
                </div>
                <div class="row space-between">
                    <p>Varasto</p>
                    <p id="stock"></p>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/items.js"></script>
</body>
</html>