<?php
$is_getId = false;
//get method of ID
if (isset($_GET["type"]) && $_GET["type"] === "id"  && isset($_GET["text"])) {
    //fetches content of api

    //api path. $domain being the root folder where files exist
    $domain = "http://localhost/verkkokauppaProjektityo-v1/";
    $getId = $_GET["text"];
    if ($getId === "kaikki" || $getId === "all") {
        $getId = "a";
    }
    
    $apiPath = $domain . "backend/api/products/get_products.php?product_id=$getId";
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
                            <option value="type">Tyyppi</option>
                            <option value="stock">Varasto</option>
                            <option value="added">Lisätty</option>
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
                    if ($is_getId):
                        foreach ($data["categories"] as $category):
                            foreach ($category["products"] as $product):
                    ?>
                                <div class="output-row rowJS" style="padding-inline:5px" id="r<?=$category["categoryID"]?>">
                                    <div>
                                        <p id="r1-categoryID">
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
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>